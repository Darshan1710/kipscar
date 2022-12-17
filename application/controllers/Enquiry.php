<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function enquiryList(){
        $this->load->view('enquiry/enquiry_list');
    }
    public function getEnquiryList(){
        $data = $row = array();
    
        // Fetch member's records
        $memData = $this->AdminModel->getEnquiryDetailsRows($_POST);

        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $status = '';
            if($member->enquiry_status == 1){
                $status =  '<button class="btn btn-primary btn-sm">pending</button>';
            }else if($member->enquiry_status == 2){
                $status = '<button class="btn btn-success btn-sm">delivered</button>';
            }


            $address_data  = array('flat_house'   =>$member->flat_house,
                                  'street_society'=>$member->street_society,
                                  'city'          =>$member->city,
                                  'pincode'       =>$member->pincode
                                );

            $address = implode(',',$address_data);


            $view_enquiry = '<a href="'.base_url().'Enquiry/getEnquiryDetails/'.$member->enquiry_id.'" class="btn btn-sm btn-success">View Enquiry</a>';

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Enquiry/editEnquiry/'.$member->enquiry_id.'"><i class="icon-file-excel"></i> Edit</a></li>
                                    <li><a href="'.base_url().'Enquiry/convertToOrder/'.$member->enquiry_id.'"><i class="icon-file-excel"></i> Convert To Order</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';

            $name = isset($member->name) ? $member->name : 'Walk in';
            $address = wordwrap($address,15,"<br>\n");
            $data[] = array(
                            $i,
                            $name, 
                            $member->mobile,
                            $member->email,
                            $address,
                            $view_enquiry,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->enquiry_created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllOrderDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredOrderDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function enquiryForm(){
        $this->load->view('enquiry_form');
    }
    public function addEnquiry(){
        $this->form_validation->set_rules('customer_unique_id','Customer Id','trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data     = $this->input->post();
            $id             = $this->input->post('enquiry_id');
            $final_total          = 0;
            $add            = false;
            $customer_unique_id = $input_data['customer_unique_id'];


            $c_filter = array('unique_id'=>$customer_unique_id);
            $customer_details = $this->AdminModel->getDetails('customers',$c_filter);

            $ca_filter = array('customer_unique_id'=>$customer_unique_id);
            $customer_addresses = $this->AdminModel->getDetails('customer_addresses',$ca_filter);
            if(!empty($_POST['product_name'][0])){
                foreach($this->input->post('product_name') as $key => $value){
                    
                    if(!empty($_POST['product_name'][$key])){
                        $p_filter = array('id'=>$_POST['product_name'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $final_total += $p_details['sell_price'] * $_POST['qty'][$key];
                    }

                    if($_POST['qty'][$key] == 0){
                        $returnArr['errCode'] = 2;
                        $returnArr['message'] = $p_details['product_name'].' Quantity should not be 0';
                        echo json_encode($returnArr);exit;
                    }

                        
                }

                $this->db->trans_start();

                if($customer_unique_id == 'new'){
                    $customer_unique_id = time();
                }

                $order_data  = array('customer_unique_id'=>$customer_unique_id,
                                     'total'        =>$final_total,
                                     'final_total'  =>$final_total,
                                     'created_at'   =>date('Y-m-d h:i:s')
                                     );

                    $enquiry_id    = $this->AdminModel->insert('enquiry_master',$order_data);


                foreach($this->input->post('product_name') as $key => $value){
                
                    if(!empty($_POST['product_name'][$key])){
                        $p_filter = array('id'=>$_POST['product_name'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $order_details[] = array('enquiry_id'    =>$enquiry_id,
                                                 'product_id'  =>$_POST['product_name'][$key],
                                                 'rate'        =>$_POST['sell_price'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'price'        =>$p_details['sell_price'] * $_POST['qty'][$key],
                                                'created_at'   =>date('Y-m-d h:i:s'));

                        $final_total += $p_details['sell_price'] * $_POST['qty'][$key];
                        

                    }
                        
                }

                $add = $this->AdminModel->insertBatch('enquiry_details',$order_details);
            
                // send email

            //     $addresses_data = array('flat_house'    =>$customer_addresses['flat_house'],
            //                             'street_society'=>$customer_addresses['street_society'],
            //                             'pincode'       =>$customer_addresses['pincode'],
            //                             'city'          =>$customer_addresses['city']);
            // //send email
            //      $bodyContent = "<div>Name: ".$customer_details['name']."<br>Mobile: ".$customer_details['mobile']."<br>Email: ".$customer_details['email']."<br>Address: ".implode(',', $addresses_data)."<br>Total : ".$final_total."<br></div><br><table>
            //     <tbody>
            //         <tr style='background-color:#A9A9A9'>
            //             <td style='padding:20px'>Product Name*</td>
            //             <td style='padding:20px'>Unit Price*</td>
            //             <td style='padding:20px'>Qty</td>
            //             <td style='padding:20px'>Price</td>
            //         </tr>";

            //     foreach($this->input->post('product_name') as $row){

            //          $bodyContent .= "<tr style='background-color:#A9A9A9'>
            //                 <td style='padding:20px'>".$_POST['product_name'][$key]."</td>
            //                 <td style='padding:20px'>".$_POST['offline_price'][$key]."</td>
            //                 <td style='padding:20px'>".$_POST['qty'][$key]."</td>
            //                 <td style='padding:20px'>".$_POST['offline_price'][$key] * $_POST['qty'][$key]."</td>
            //             </tr>";
                    
            //     }

            //     $bodyContent .= "</tbody></table>";

                //$this->send_mail('kinidarshan07@gmail.com','Thanks for your order',$bodyContent);


                //send sms
                $msg = 'Thanks for your order';
                $mobile = $customer_details['mobile'];

                $username = urlencode("u_alphacore"); 
                $msg_token = urlencode("EEYN6t"); 
                $sender_id = urlencode("612324"); // optional (compulsory in transactional sms) 
                $message = urlencode($msg); 
                $mobile = urlencode($mobile); 


                $api = "http://la-suit.vispl.in/api/send_promotional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

                $response = file_get_contents($api);

                $data = json_decode($response,true);

                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']  = $order_id;
                    $returnArr['customer_unique_id']  = $customer_unique_id;
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
    public function editEnquiry(){
        $enquiry_id = $this->uri->segment(3);
        $filter   = array('em.id'=>$enquiry_id);
        $data['enquiry'] = $this->AdminModel->getEnquiryMasterData($filter);

        $customer_unique_id = $data['enquiry']['customer_unique_id'];
        $address_id         = $data['enquiry']['address'];

        $filter['ed.status']  = '1';
        $data['enquiry_details'] = $this->AdminModel->getEnquiryDetails($filter);

        $filter = array('customer_unique_id'=>$customer_unique_id,
                        'id'                =>$address_id);
        $data['address'] = $this->AdminModel->getList('customer_addresses',$filter);

        $c_filter = array('unique_id'=>$customer_unique_id);
        $data['customer'] = $this->AdminModel->getDetails('customers',$c_filter);


        $data['products'] = $this->AdminModel->getList('products');


        $this->load->view('edit_enquiry',$data);
    }
    public function updateEnquiry(){
        $this->form_validation->set_rules('enquiry_id','Enquiry Id','required|trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data = $this->input->post();
            $enquiry_id = $this->input->post('enquiry_id');
            $customer_unique_id = $this->input->post('customer_unique_id');
            $total = 0;
            $add = false;
            $final_discount = 0;
            $final_total = 0;
            if(!empty($_POST['product_name'][0])){

                //insert backup data
                $o_filter = array('enquiry_id'=>$enquiry_id,'status'=>'1');   
                $enquiry_backup_data = $this->AdminModel->getList('enquiry_details',$o_filter);

                $this->db->trans_start();


                foreach($this->input->post('product_name') as $key => $value){
                
                    if(!empty($_POST['product_name'][$key])){

                        $p_filter = array('id'=>$_POST['product_name'][$key],'status'=>'1');;
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        if($_POST['qty'][$key] == 0){
                            $returnArr['errCode'] = 2;
                            $returnArr['message'] = 'Quantity should not be 0';
                            echo json_encode($returnArr);exit;
                        }


                        //new data
                        $enquiry_details[] = array('enquiry_id'    =>$enquiry_id,
                                                 'product_id'  =>$_POST['product_name'][$key],
                                                 'rate'        =>$_POST['sell_price'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'price'       =>$p_details['sell_price'] * $_POST['qty'][$key]);

                        $final_total += $_POST['qty'][$key] * $_POST['sell_price'][$key];

                    }
                        
                }                

  
                foreach($enquiry_backup_data as $backup){
                $enquiry_backup_details[] = array('enquiry_id'  =>$backup['enquiry_id'],                           'product_id'=>$backup['product_id'],
                                                'rate'      =>$backup['rate'],
                                                'qty'       =>$backup['qty'],
                                                'price'     =>$backup['price'],
                                                'created_at'=>date('Y-m-d h:i:s')
                                                );

                }

                $this->AdminModel->insertBatch('enquiry_backup_details',$enquiry_backup_details);


                $om_filter         = array('id'=>$enquiry_id);
        $enquiry_master_data = array('customer_unique_id'  =>$this->input->post('customer_unique_id'),
                                 'total'        =>$final_total,
                                 'final_total'  =>$final_total,
                                 );

                $this->AdminModel->update('enquiry_master',$om_filter,$enquiry_master_data);

                //delete data from order details
                $o_data = array('status'=>'0');
                $delete_orders = $this->AdminModel->update("enquiry_details",$o_filter,$o_data);

                $update_data[] = array(
                                    'enquiry_id'   =>$enquiry_id,
                                    'status'        =>'0');
                $this->AdminModel->updateBatch('enquiry_details',$update_data,'enquiry_id');

                $add = $this->AdminModel->insertBatch('enquiry_details',$enquiry_details);
                

                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']    = $enquiry_id;
                    $returnArr['customer_unique_id'] = $customer_unique_id;
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

}
