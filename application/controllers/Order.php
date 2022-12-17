<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function getOrderList(){
        $data = $row = array();
    

        // Fetch member's records
        $memData = $this->OrderModel->getOrderDetailsRows($_POST);


        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $status = '';
            if($member->order_status == 1){
                $status =  '<button class="btn btn-success btn-sm">Complete</button>';
            }else if($member->order_status == 2){
                $status = '<button class="btn btn-warning btn-sm">Pending</button>';
            }



            // $view_ordrer = '<a href="'.base_url().'Order/orderDetails/'.$member->order_id.'/'.$member->unique_id.'" class="btn btn-sm btn-success">View Order</a>';

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Order/invoice/'.$member->order_id.'"><i class="icon-file-excel"></i> Invoice</a></li>
                                    <li><a href="'.base_url().'Order/editOrder/'.$member->order_id.'"><i class="icon-pencil"></i> Edit</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';

            
            $data[] = array($member->order_id,
                            $i,
                            $member->sales_person, 
                            $member->customer_name,
                            $member->invoice_no,
                            $member->total,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->order_created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->OrderModel->countAllOrderDetails(),
            "recordsFiltered" => $this->OrderModel->countFilteredOrderDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function orderList(){
        $this->load->view('order/orderList');
    }
    public function orderForm(){
        $filter = array('status'=>'1');
        $data['client'] = $this->AdminModel->getList('client',$filter);

        $s_filter = array('user_type'=>'2','status'=>'1');
        $data['sales_person'] = $this->AdminModel->getList('customers',$s_filter);
        $this->load->view('order/order_form',$data);
    }
    public function addOrder(){
        $this->form_validation->set_rules('client_id','Client Id','trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data     = $this->input->post();
            $client_id      = $this->input->post('id');
            $total          = 0;
            $add            = false;
            $sales_person_id= $input_data['sales_person_id'];

            $c_filter = array('id'=>$client_id);
            $client_details = $this->AdminModel->getDetails('customers',$c_filter);

            if(!empty($_POST['product_id'][0])){
                foreach($this->input->post('product_id') as $key => $value){
                    
                    if(!empty($_POST['product_id'][$key])){
                        $p_filter = array('id'=>$_POST['product_id'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $qty = $_POST['qty'][$key];
                        $mrp = $_POST['mrp'][$key];
                        $subtotal = $mrp * $qty;
                        $discount = $_POST['discount'][$key];
                        $final_discount = ($subtotal * $discount) / 100; 
                        $subtotal = $subtotal - $final_discount;
                        $total += $subtotal;
                    }

                    if($_POST['qty'][$key] == 0){
                        $returnArr['errCode'] = 2;
                        $returnArr['message'] = $p_details['model_no'].' Quantity should not be 0';
                        echo json_encode($returnArr);exit;
                    }

                        
                }

                $this->db->trans_start();

                $last_invoice = $this->AdminModel->getDetails('orders',null,1,null,'order_id DESC');

                $invoice_id = sprintf("%05s",++$last_invoice['order_id']);

                $order_data  = array('customer_id'      =>$client_id,
                                     'client_contact_id'=>$input_data['client_contact_id'],
                                     'sales_person_id'  =>$sales_person_id,
                                     'invoice_no'       =>'APK'.$invoice_id,
                                     'status'           =>'2',
                                     'total'            =>$total
                                     );

                    $order_id    = $this->AdminModel->insert('orders',$order_data);


                foreach($this->input->post('product_id') as $key => $value){
                
                    if(!empty($_POST['product_id'][$key])){
                        $order_details[] = array('order_id'    =>$order_id,
                                                 'product_id'  =>$_POST['product_id'][$key],
                                                 'mrp'         =>$_POST['mrp'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'discount_percentage'    =>$_POST['discount'][$key],
                                                'created_at'   =>date('Y-m-d h:i:s'));

                    }
                        
                }


                $add = $this->AdminModel->insertBatch('order_list',$order_details);
            
           
                        $this->db->trans_complete();

                        if($add){

                            $filter_1   = array('o.order_id'=>$order_id);
                        $order_data_1 = $this->AdminModel->getDetails('orders o',$filter_1);

                        if(is_null($order_data_1['sales_person_id'])){
                            $data['customer'] = $this->OrderModel->getCustomerOrderData($filter_1);
                            $data['sales_person'] = false;
                        }else{
                            $data['customer'] = $this->OrderModel->getClientOrderData($filter_1);
                            $data['sales_person'] = true;
                        }

                        $customer_id = $data['customer']['id'];

                        $data['order_details'] = $this->OrderModel->getOrderDetails($filter_1);


                        $filename = $order_data['invoice_no'];

                        $html = $this->load->view('order/mobile_invoice',$data,true);
                        $this->pdf->createPDF($html, $filename, true);

                        $invoice_order_id = array('order_id'=>$order_id);
                        $invoice_link_data = array('invoice_link'=>base_url().'uploads/order/'.$filename.'.pdf');
                        $this->AdminModel->update('orders',$invoice_order_id,$invoice_link_data);

                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']  = 'Order Added Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }else{
                $returnArr['errCode']     = 5;
                $returnArr['message']     = '<p class="error">Product Name is required</p><p class="error">Qty is required</p>';
            }
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            } 
        }
        echo json_encode($returnArr);
    }

    public function editOrder(){
        $order_id = $this->uri->segment(3);
        $filter   = array('o.order_id'=>$order_id);
        $order_data = $this->AdminModel->getDetails('orders o',$filter);


        if(is_null($order_data['sales_person_id']) || $order_data['sales_person_id'] == $order_data['customer_id']){
            $data['order'] = $this->OrderModel->getCustomerOrderData($filter);
            $data['sales_person'] = false;
        }else{
            $data['order'] = $this->OrderModel->getClientOrderData($filter);
            $data['sales_person'] = true;
        }



        $customer_id = $data['order']['id'];

        $order_details = $this->OrderModel->getOrderDetails($filter);

        foreach($order_details as $key => $row){
            $order_details[$key]['subtotal'] = calculate_total($row['mrp'],$row['qty'],$row['discount']);
        }

        $data['order_details'] = $order_details;

        $data['products'] = $this->AdminModel->getList('products');

        $s_filter = array('user_type'=>'2','status'=>'1');
        $data['sales_person_list'] = $this->AdminModel->getList('customers',$s_filter);

        $this->load->view('order/edit_order',$data);
    }
    public function updateOrder(){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data = $this->input->post();
            $order_id = $this->input->post('order_id');
            $customer_id = $this->input->post('id');
            $total = 0;
            $add = false;
            if(!empty($_POST['id'][0])){

                //insert backup data
                $o_filter = array('order_id'=>$order_id);   
                $order_backup_data = $this->AdminModel->getList('order_list',$o_filter);

                $this->db->trans_start();


                foreach($this->input->post('model_no') as $key => $value){
                
                
                    if(!empty($_POST['model_no'][$key])){

                        $p_filter = array('id'=>$_POST['model_no'][$key],'status'=>'1');;
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        if($_POST['qty'][$key] == 0){
                            $returnArr['errCode'] = 2;
                            $returnArr['message'] = 'Quantity should not be 0';
                            echo json_encode($returnArr);exit;
                        }


                        //new data
                        $order_details[] = array('order_id'    =>$order_id,
                                                 'product_id'  =>$_POST['model_no'][$key],
                                                 'mrp'         =>$_POST['mrp'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'discount_percentage'       =>$_POST['discount'][$key]);

                        $qty = $_POST['qty'][$key];
                        $mrp = $_POST['mrp'][$key];
                        $subtotal = $mrp * $qty;
                        $discount = $_POST['discount'][$key];
                        $final_discount = ($subtotal * $discount) / 100; 
                        $subtotal = $subtotal - $final_discount;
                        $total += $subtotal;

                    }
                        
                }                

                if($order_backup_data){
                    foreach($order_backup_data as $backup){
                    $order_backup_details[] = array('order_id'  =>$backup['order_id'],                           'product_id'=>$backup['product_id'],
                                                    'mrp'       =>$backup['mrp'],
                                                    'qty'       =>$backup['qty'],
                                                    'discount_percentage'  =>$backup['discount_percentage'],
                                                    'created_at'=>date('Y-m-d h:i:s')
                                                    );

                    }

                    $this->AdminModel->insertBatch('order_list_backup',$order_backup_details);  
                }
                
                if(empty($input_data['sales_person_id'])){
                    $input_data['sales_person_id'] = $customer_id;
                }

                $om_filter         = array('order_id'=>$order_id);
        $order_master_data = array('customer_id'    =>$customer_id,
                                 'sales_person_id'  =>$input_data['sales_person_id'],
                                 'client_contact_id'=>$input_data['client_contact_id'],
                                 'invoice_no'       =>time(),
                                 'total'            =>$total   
                         );

                $this->AdminModel->update('orders',$om_filter,$order_master_data);

                //delete data from order details
                $o_data = array('órder_id'=>$order_id);
                $delete_orders = $this->AdminModel->delete("order_list",$o_filter);

                $add = $this->AdminModel->insertBatch('order_list',$order_details);

                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']    = $order_id;
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }else{
                $returnArr['errCode']     = 5;
                $returnArr['message']     = '<p class="error">Product Name is required</p><p class="error">Qty is required</p>';
            }

            
            

        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            } 
        }
        echo json_encode($returnArr);
    }
    public function cancelOrder(){
        $ids = $this->input->post('id');

        $total = 0;
        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $order_id   = $order_details['order_id'];

            $total = $order_details['qty'] * $order_details['rate'];
        }


        $f_filter = array('id'=>$order_id);
        $order_data  = $this->AdminModel->getDetails('order_master',$f_filter);

        $final_total = 0;
        if($order_data['final_total'] > 0){
            $final_total  = $order_data['final_total'] - $total;
             $final_total  = $final_total - $total;
        
            $f_data = array('final_total'=>$final_total);
            $this->AdminModel->update('order_master',$f_filter,$f_data);
        }

       

        $data = array('product_status'=>'2');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function damageOrder(){
        $ids = $this->input->post('id');

        $total = 0;
        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $order_id   = $order_details['order_id'];

            $total = $order_details['qty'] * $order_details['rate'];
        }


        $f_filter = array('id'=>$order_id);
        $order_data  = $this->AdminModel->getDetails('order_master',$f_filter);

        $final_total = 0;
        if($order_data['final_total'] > 0){
            $final_total  = $order_data['final_total'] - $total;
             $final_total  = $final_total - $total;
        
            $f_data = array('final_total'=>$final_total);
            $this->AdminModel->update('order_master',$f_filter,$f_data);
        }

        $data = array('product_status'=>'3');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }
    public function deliveredOrder(){
        $id = $this->input->post('id');

        $filter = array('id'=>$id);
        $data = array('order_status'=>'1');
        $update = $this->AdminModel->update('order_masters',$filter,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }
    public function deletOrder(){
        $ids = $this->input->post('id');

        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $qty        = $order_details['qty'];
            $product_id = $order_details['product_id'];
            $this->PurchaseModel->addStockOut('stock',$qty,$product_id);
        }

        $data = array('product_status'=>'4','status'=>'0');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function getOrderDetails(){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('id'=>$this->input->post('order_id'));
            $order_details = $this->AdminModel->getDetails('order_masters',$filter);


            $p_filter = array('id'=>$this->input->post('order_id'));
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $amount = $order_details['final_total'];


            if($p_data){
                $amount = $order_details['final_total'] - round($p_data['amount'],2);
            }

            $data['amount'] = $amount;
            if($order_details){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = $data;
            }else{  
                $returnArr['errCode']       = 2;
                $returnArr['message']       = 'Please try again';
            }

        }else{
          
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function changeDeliveryStatus(){
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
    
        $filter = array('order_status'=>$status);
        $update_status = $this->AdminModel->updateMulitple('order_masters',$ids,$filter);
      //  echo $this->db->last_query();exit;
        if($update_status){

             $this->session->set_flashdata('success', 'Product Delivery Status Change successfully');

            $returnArr['error']     = false;
            $returnArr['message']   = 'success';
        }else{
            $returnArr['error']     = true;
            $returnArr['message']   = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function invoice(){
       

        $order_id = $this->uri->segment(3);
        $filter   = array('o.order_id'=>$order_id);
        $order_data = $this->AdminModel->getDetails('orders o',$filter);

        if(is_null($order_data['sales_person_id']) || $order_data['sales_person_id'] == $order_data['customer_id']){
            $data['customer'] = $this->OrderModel->getCustomerOrderData($filter);
            $data['sales_person'] = false;
        }else{
            $data['customer'] = $this->OrderModel->getClientOrderData($filter);
            $data['sales_person'] = true;
        }

        $customer_id = $data['customer']['id'];

        $data['order_details'] = $this->OrderModel->getOrderDetails($filter);

        $this->load->view('order/invoice',$data);
    }

     public function orderDetails(){
        $id = $this->uri->segment(3);
        $o_filter = array('o.id'=>$id);
        $data['order'] = $this->AdminModel->getOrderMasterData($o_filter);

        $filter = array('order_id'=>$id,'od.status'=>'1');
        $data['order_details'] = $this->AdminModel->getOrderDetails($filter);
        $this->load->view('order/order_details',$data);
    }

    public function checkoutForm($order_id,$customer_id = NULL){
        
        
        $order_filter = array('id'=>$order_id);
        $status_details = $this->AdminModel->getDetails('order_masters',$order_filter);

        if($status_details['order_status'] != '2'){
           $this->session->set_flashdata('warning', 'Payment will be done after delivered status');
           redirect('/Order/orderList','refresh'); 
        }else{


            $data['order_id'] = $order_id;
            if($customer_id){
                $data['customer_id'] = $customer_id;
            }else{
                $data['customer_id'] = 0;
            }
        
            $filter = array('order_id'=>$order_id);
            $data['payment'] = $this->AdminModel->getList('payment_details',$filter);        

            $filter = array('id'=>$order_id);
            $order_details = $this->AdminModel->getDetails('order_masters',$filter);

            $p_filter = array('order_id'=>$order_id);
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $amount = $order_details['final_total'];


            if($p_data){
                $amount = $order_details['final_total'] - round($p_data['amount'],2);
            }

            $data['amount'] = $amount;
            $this->load->view('order/checkout',$data);
        }
    }


    public function addPayment(){
    
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_id','Customer Id','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('payment_mode','Payment Mode','required|trim|xss_clean|max_length[255]');
        if($this->input->post('payment_mode') == 'cash'){
            $payment_mode = '1';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cash_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('change','Change','required|trim|xss_clean|max_length[255]');
        }else if($this->input->post('payment_mode') == 'cheque'){
            $payment_mode = '2';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_number','Cheque Number','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_date','Cheque Date','required');
        }else if($this->input->post('payment_mode') == 'nfet'){
            $payment_mode = '4';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('nfet_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('account_number','Account Number','required|trim|xss_clean|max_length[255]');
        }else if($this->input->post('payment_mode') == 'upi'){
            $payment_mode = '3';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('upi_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('transcation_id','Transcation Id','trim|xss_clean|max_length[255]');
        }
        
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            if(isset($input_data['customer_id'])){
                $unique_id = $input_data['customer_id'];
            }else{
                $unique_id = time();
            }

            $data = array('order_id'             =>$this->input->post('order_id'),
                          'payment_mode'        =>$payment_mode
                        );

            if($this->input->post('payment_mode') == 'cash'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['cash_recieved_amount'];
                $data['change']             = $input_data['change'];
            }else if($this->input->post('payment_mode') == 'cheque'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['cheque_recieved_amount'];
                $data['cheque_number']      = $input_data['cheque_number'];
            }else if($this->input->post('payment_mode') == 'nfet'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['nfet_recieved_amount'];
                $data['account_number']     = $input_data['account_number'];
            }else if($this->input->post('payment_mode') == 'upi'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['upi_recieved_amount'];
                $data['transcation_id']     = $input_data['transcation_id'];
            }

            $update = $this->AdminModel->insert('payment_details',$data);

            $p_filter = array('id'=>$this->input->post('order_id'));
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $o_filter = array('id'=>$this->input->post('order_id'));
            $o_data   = $this->AdminModel->getDetails('order_masters',$o_filter);


            if($o_data['final_total'] == $p_data['amount']){
                $payment_status_data = array('payment_status'=>'2');
                $this->AdminModel->update('order_masters',$o_filter,$payment_status_data);
            }

            if($update){
                $this->session->set_flashdata('success', 'Payment Added Successfully');

                $returnArr['errCode']       = -1;
                $returnArr['order_id']      = $this->input->post('order_id');
                $returnArr['customer_id']   = $this->input->post('customer_id');
                $returnArr['proceed']       = $o_data['final_total'] == $p_data['amount'] ? true : false;
            }else{  
                $returnArr['errCode']       = 2;
                $returnArr['message']       = 'Please try again';
            }
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function deletePayment(){

        $id = $this->input->post('id');

        $filter = array('id'=>$id);
        $details = $this->AdminModel->getDetails('payment_details',$filter);

        $backup_data = array('payment_id'       =>$details['id'],
                             'order_id'         =>$details['order_id'],
                             'payment_mode'     =>$details['payment_mode'],
                             'recieved_amount'  =>$details['recieved_amount'],
                             'upi'              =>$details['upi'],
                             'transacation_id'  =>$details['transacation_id'],
                             'card_number'      =>$details['card_number'],
                             'cheque_number'    =>$details['cheque_number'],
                             'cheque_date'      =>$details['cheque_date'],
                             'amount'           =>$details['amount'],
                             'change'           =>$details['change'],
                             );

        $this->AdminModel->insert('payment_backup_details',$backup_data);

        $delete = $this->AdminModel->deletePayment($filter);

        if($delete){
            $returnArr['error']  = -1;
            $returnArr['message']= 'success';
        }else{
            $returnArr['error']  = 2;
            $returnArr['message']= 'failed';
        }

        echo json_encode($returnArr);
    }
}
