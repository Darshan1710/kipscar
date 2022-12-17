<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}  
//
    public function customerList(){
      $this->load->view('customer/customer_list');
    }
    public function customerForm(){
      $data = array();
      $data['id'] = 'new';
      $id = $this->uri->segment(3);

      if($id){
        $data['id'] = $id;
        $filter = array('id'=>$id);
        $data['customer']   = $this->AdminModel->getDetails('customers',$filter);

      }

      $this->load->view('customer/customer_form',$data);
    }
	
    //user role
    public function getCustomerListDetails(){

         $data = $row = array();


        // Fetch member's records
        $memData = $this->AdminModel->getCustomerDetailsRows($_POST);
        
        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;



            if($member->status == 2){
              $status = '<button class="btn btn-danger btn-sm">Inactive</button>';
            }else{
              $status = '<button class="btn btn-success btn-sm">Active</button>';
            }

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" id="'.$member->id.'" class="editCustomer" data-toggle="modal" data-target="#edit_modal"><i class="icon-file-excel"></i> Edit</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';


            $data[] = array($member->mobile,
                            $member->id,
                            $member->name, 
                            $member->mobile,
                            $member->email,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->created)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllCustomerDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredCustomerDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function addCustomer(){
        $this->form_validation->set_rules('unique_id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('password','Password','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean|max_length[255]|matches[password]');
        if($this->form_validation->run()){
            

            $input_data = $this->input->post();
            
           

            $id = $input_data['unique_id'];
            $data = array('unique_id'=>time(),
                          'name'     =>$input_data['name'],
                          'mobile'   =>$input_data['mobile'],
                          'email'    =>$input_data['email'],
                          'password' =>$input_data['password']
                        );

            if($id == 'new'){
               $filter = ' email = "'.$input_data['email'].'" OR mobile = "'.$input_data['mobile'].'"';
              $customer_exists = $this->AdminModel->getDetails('customers',$filter);

              if($customer_exists){
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Mobile or Email already exists';
                $returnArr['unique_id'] = $customer_exists['unique_id'];
              }else{

                $add = $this->AdminModel->insert('customers',$data);

                if($add){

                  $c_filter = array('id'=>$add);
                  $customer = $this->AdminModel->getDetails($c_filter);

                  $returnArr['errCode']     = -1;
                  $returnArr['unique_id'] = $customer['unique_id'];
                  $returnArr['message']     = 'success';

                  $msg = 'Thanks for registration';
                  $mobile = $this->input->post('mobile');

                  $username = urlencode("u_alphacore"); 
                  $msg_token = urlencode("EEYN6t"); 
                  $sender_id = urlencode("612324"); // optional (compulsory in transactional sms) 
                  $message = urlencode($msg); 
                  $mobile = urlencode($mobile); 


                  $api = "http://la-suit.vispl.in/api/send_promotional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

                  if(date('H') < 21){
                    $response = file_get_contents($api);

                    json_decode($response,true);
                  }
                }else{
                  $returnArr['errCode'] = 2;
                  $returnArr['customer_id'] = '';
                  $returnArr['message'] = 'failed';
                }
              }
            }else{
              $filter = array('unique_id'=>$id);
              $update = $this->AdminModel->update('customers',$filter,$data);

              if($update){
                $returnArr['errCode'] = -1;
                $returnArr['customer_id'] = $id;
                $returnArr['message'] = 'success';
              }else{
                $returnArr['errCode'] = 2;
                $returnArr['customer_id'] = $id;
                $returnArr['message'] = 'failed';
              }

            }
            
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function addOrderCustomer(){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('password','Password','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_type','Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_flat_house','Flat House','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_street_society','Street Society','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_pincode','Pincode','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_city','City','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('customer_mobile'));

            $checkMenu = $this->AdminModel->getCustomerDetails($filter);

            if($checkMenu){
                
                if($checkMenu['flat_house'] == $this->input->post('flat_house') && $checkMenu['street_society'] == $this->input->post('street_society')){
                         $default_address_id = $checkMenu['default_address'];
                
                        $filter = array('id'=>$default_address_id);
                        $address_data = array('customer_unique_id'=>$checkMenu['unique_id'],
                                              'type'              =>$this->input->post('customer_type'),
                                              'flat_house'        =>$this->input->post('customer_flat_house'),
                                              'street_society'    =>$this->input->post('customer_street_society'),
                                              'pincode'           =>$this->input->post('customer_pincode'),
                                              'city'              =>$this->input->post('customer_city')
                                            );
                        $add_address = $this->AdminModel->update('customer_addresses',$filter,$address_data);
                 
                        if($add_address){
                            $returnArr['errCode']       = -1;
                            $returnArr['message']       = 'success';
                        }else{  
                            $returnArr['errCode']       = 2;
                            $returnArr['message']       = 'Please try again';
                        }
                }else{
                        $address_data = array('customer_unique_id'=>$checkMenu['unique_id'],
                                              'type'              =>$this->input->post('customer_type'),
                                              'flat_house'        =>$this->input->post('customer_flat_house'),
                                              'street_society'    =>$this->input->post('customer_street_society'),
                                              'pincode'           =>$this->input->post('customer_pincode'),
                                              'city'              =>$this->input->post('customer_city')
                                            );

                        $add_address = $this->AdminModel->insert('customer_addresses',$address_data);

                        $c_filter = array('unique_id'=>$checkMenu['unique_id']);
                        $c_data   = array('default_address'   =>$add_address);
                        $update   = $this->AdminModel->update('customers',$c_filter,$c_data);

                        if($add_address){
                            $returnArr['errCode']       = -1;
                            $returnArr['message']       = 'success';
                        }else{  
                            $returnArr['errCode']       = 2;
                            $returnArr['message']       = 'Please try again';
                        }
                }
               
            }else{
                $data = array('unique_id'       =>time(),
                              'name'            =>$this->input->post('customer_name'),
                              'email'           =>$this->input->post('customer_email'),
                              'mobile'          =>$this->input->post('customer_mobile'),
                              'password'        =>md5($this->input->post('password'))
                          );

                $add = $this->AdminModel->insert('customers',$data);


                $address_data = array('customer_unique_id'=>$data['unique_id'],
                                      'type'              =>$this->input->post('customer_type'),
                                      'flat_house'        =>$this->input->post('customer_flat_house'),
                                      'street_society'    =>$this->input->post('customer_street_society'),
                                      'pincode'           =>$this->input->post('customer_pincode'),
                                      'city'              =>$this->input->post('customer_city')
                                    );

                $add_address = $this->AdminModel->insert('customer_addresses',$address_data);

                $c_filter = array('unique_id'=>$data['unique_id']);
                $c_data   = array('default_address'   =>$add_address);
                $update   = $this->AdminModel->update('customers',$c_filter,$c_data);


                $o_filter = array('id'=>$this->input->post('order_id'));
                $o_data   = array('customer_unique_id'=>$data['unique_id'],
                                  'address'           =>$add_address);
                $update_order = $this->AdminModel->update('order_master',$o_filter,$o_data);

                if($add){
                    $returnArr['errCode']       = -1;
                    $returnArr['message']       = 'success';
                }else{  
                    $returnArr['errCode']       = 2;
                    $returnArr['message']       = 'Please try again';
                }
            }
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function editOrderCustomer(){
        $this->form_validation->set_rules('customer_unique_id','Customer Unique Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        if($this->form_validation->run()){

            $filter = array("mobile"=>$this->input->post('customer_mobile'));
            $customer = $this->AdminModel->getDetails("customers",$filter);

            $o_filter = array("id"=>$this->input->post('order_id'));
            $data = array('customer_unique_id'=>$this->input->post('customer_unique_id'));
            $update = $this->AdminModel->update("order_master",$o_filter,$data);

            if($update){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = 'success';
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
    public function getAddressDetails(){


        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $address = $this->AdminModel->getDetails('customer_addresses',$filter);
            if($address){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $address;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function addAddress(){
        $this->form_validation->set_rules('unique_id','Unique Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('type','Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('street_address','Street address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('pincode','Pincode','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('is_default','Is Default','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('city','City','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){


            $data = array('customer_unique_id'=>$this->input->post('unique_id'),
                          'type'            =>$this->input->post('type'),
                          'street_address'  =>$this->input->post('street_address'),
                          'pincode'         =>$this->input->post('pincode'),
                          'is_default'      =>$this->input->post('is_default'),
                          'city'            =>$this->input->post('city')
                      );

            $add = $this->AdminModel->insert('customer_addresses',$data);

            if($add){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = 'success';
                $returnArr['unique_id']     = $this->input->post('unique_id');
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
    public function updateAddress(){
        $this->form_validation->set_rules('address_id','Address Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('type','Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('street_address','Street Address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('pincode','Pincode','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('city','City','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('is_default','Is Default','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('id'=>$this->input->post('address_id'));

            $data = array(
                          'type'            =>$this->input->post('type'),
                          'street_address'  =>$this->input->post('street_address'),
                          'pincode'         =>$this->input->post('pincode'),
                          'city'            =>$this->input->post('city'),
                          'is_default'      =>$this->input->post('is_default')
                      );

            $add = $this->AdminModel->update('customer_addresses',$filter,$data);


            if($add){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = 'success';
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
    public function delete(){

        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){


            $filter = array('id'=>$this->input->post('id'));

            $data = array('status'            =>'0');

            $add = $this->AdminModel->update('customer_addresses',$filter,$data);

            if($add){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = 'success';
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

    public function multipleDelete(){

            $ids = $this->input->post('ids');

            foreach ($ids as $row) {
              $data[] = array('id'=>$row,
                              'status'=>'0');
            }
            

            $add = $this->AdminModel->updateBatch('customer_addresses',$data,'id');

            if($add){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = 'success';
            }else{  
                $returnArr['errCode']       = 2;
                $returnArr['message']       = 'Please try again';
            }

           echo json_encode($returnArr);
    }

    public function editCustomer(){
      
        $this->form_validation->set_rules('unique_id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('unique_id'=>$this->input->post('unique_id'));

            $customer = $this->AdminModel->getCustomerDetails($filter);
            if($customer){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $customer;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function getClientDetails(){
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('mobile'));

            $customer = $this->CustomerModel->getClientDetails($filter);

            if($customer){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $customer;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function getCustomerAddressDetails(){
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('mobile'));

            $customer = $this->AdminModel->getDetails('customers',$filter);

            $a_filter = array('customer_unique_id'=>$customer['unique_id']);
            $customer['address'] = $this->AdminModel->getList('customer_addresses',$a_filter);

            if($customer){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $customer;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function updateCustomer(){

       $this->form_validation->set_rules('unique_id','unique_id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('password','Password','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('unique_id !='=>$this->input->post('unique_id'),
                            'mobile'=>$this->input->post('mobile'));

            $customer_details = $this->AdminModel->getDetails('customers',$filter);
            if($customer_details){
                    $returnArr['errCode']                   = 3;
                    $returnArr['message']['mobile']       = '<p class="error">Customer Already Exists</p>';
            }else{
                $filter     = array('unique_id'=>$this->input->post('unique_id'));
                 $data = array('name'            =>$this->input->post('name'),
                              'email'           =>$this->input->post('email'),
                              'mobile'          =>$this->input->post('mobile'),
                              'status'          =>$this->input->post('status')
                          );
                $update = $this->AdminModel->update('customers',$filter,$data);

                if($update){
                    $returnArr['errCode']       = -1;
                    $returnArr['message']       = 'Customer Updated Successfully';
                }else{
                    $returnArr['errCode']       = 2;
                    $returnArr['message']       = 'Please try again';
                }
            }
            
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function deleteCustomer(){
        if($this->session->userdata('logged_in')){
            $filter = array('id'=>$this->uri->segment(3));

            if($filter){    
                $data = array('status'=>'0');
                $update = $this->Package_model->update('customer',$filter,$data);
                redirect(base_url().'Customer/customerList');
            }else{
                redirect(base_url().'Customer/customerList');
            }
        }else{
            $this->load->view('login');
        }
    }

    function send_mail($to,$subject,$bodyContent,$attachment = NULL) {
        

        $ci = & get_instance();
        $ci->load->library('email');
        $ci->email->from("naikjay75@gmail.com");
        $ci->email->to('naikjay75@gmail.com');
        $ci->email->cc('naikjay75@gmail.com');
        $ci->email->subject($subject);
        $ci->email->message($bodyContent);
        if($ci->email->send()){
            return  true;
        }else{
             return false;
        }
        

    }

    public function getClientNumber(){

        $mobile            = $this->input->post('mobile');
        $customer_details    = $this->CustomerModel->getClientNumber($mobile);

        $newArray = array();
        foreach($customer_details as $key => $value) {
                $newArray['items'][] =  array('label'=>$value['mobile'],'value'=>$value['mobile']);
        }
        
        echo json_encode($newArray);
    }

     public function customerReport(){
        $data['customer_report'] = $this->AdminModel->getCustomerReport();
        $this->load->view('report/customer_report',$data);
    }
    public function customerOrderList(){
        $id = $this->uri->segment(3);
        $filter = array('unique_id'=>$id);
        $data['customer_report_master'] = $this->AdminModel->getcustomerOrderList($filter);
        $this->load->view('report/customer_report_master',$data);
    }
    public function viewOrderDetails(){
        $id = $this->uri->segment(3);
        $o_filter = array('o.id'=>$id);
        $data['order'] = $this->AdminModel->getOrderMasterData($o_filter);

        $filter = array('order_id'=>$id);
        $data['customer_report_master_details'] = $this->AdminModel->getOrderDetails($filter);
        $this->load->view('report/customer_report_master_details',$data);
    }

}
