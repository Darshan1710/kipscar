<?php

defined('BASEPATH') OR exit('No direct script access allowed');
const API_ACCESS_KEY = 'AAAAM-HFrvg:APA91bFXNj2sPIeRZnP6F0ZRDvrqaTJOyKcepLluaFbnuMJ9IhlOx2QSP8gDig7IWK6hIDTCYVHAut7Rc1jsqoPMU_eKUD0OycETxWdzNs5IH-RSiPocXzy-gX4mWBMyW7mIhKhLxiLz';
class Notification extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Banner
    public function notificationForm(){             
        $this->load->view('notification/notificationForm'); 
    }
    public function addNotification(){
        $this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('file', '', 'callback_file_check');
        $this->form_validation->set_rules('activity', 'Activity', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('value_code', 'Value Code', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $title              = $this->input->post('title');
            $activity           = $this->input->post('activity');
            $value_code         = $this->input->post('value_code');
            $description        = $this->input->post('description');
            

            $notification_image['errCode']  = -1;
            $notify_image                   = '';

            if(!empty($_FILES['file']['name'])){
                    $new_image_name = time().$_FILES['file']['name'];
                    
                    $config['upload_path']      = 'uploads/';     
                    $config['allowed_types']    = '*';
                    $config['file_name']        = $new_image_name;
                    $config['max_size']         = '0';
                    $config['max_width']        = '0';
                    $config['max_height']       = '0';
                    $config['min_width']        = '0';
                    $config['min_height']       = '0';
                    

                    $this->load->library('upload', $config);
                    
                    if($this->upload->do_upload('file')){
                         $notification_image['errCode']     = -1;
                         $image       = $config['upload_path'].$new_image_name;
                     
                    }else{
                        
                        $notification_image['errCode']  = 2;
                        $image                   = '';
                    }   
                        
                }

                $notification['title']              = $title;
                $notification['image']              = $image;
                $notification['status']             = 0;
                $notification['activity']           = $activity;
                $notification['description']        = $description;
                $notification['value_code']         = $value_code;

    
                $addNotification = $this->AdminModel->insert('notification',$notification);
                if($addNotification){
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'success';
                }else{
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'failed';
                }
            }else{

                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'failed';
            }
            echo json_encode($returnArr);
    }

    public function notificationList(){
        $filter           = array('status'=>'0');
        $data['notifications'] = $this->AdminModel->getList('notification');
        $this->load->view('notification/notification_list',$data); 
    }
    public function editNotification(){
        $this->form_validation->set_rules('id', 'Id', 'required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $id              = $this->input->post('id');            

            $filter = array('id'=>$id);
            $notification = $this->AdminModel->getDetails('notification',$filter);
            if($notification){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = $notification;
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'failed';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function updateNotification(){
      
        $this->form_validation->set_rules('id', 'Id', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('activity', 'Activity', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('value_code', 'Value Code', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            
            $input_data = $this->input->post();

            $filter = array('id'=>$input_data['id']);
            $data = array('title'       =>$input_data['title'],
                          'activity'    =>$input_data['activity'],
                          'value_code'  =>$input_data['value_code'],
                          'description'  =>$input_data['description'],
                          'status'      =>$input_data['status']
                      );
            

            if(!empty($_FILES['file']['name'])){
                    $new_image_name = time().$_FILES['file']['name'];
                    
                    $config['upload_path']      = 'uploads/';     
                    $config['allowed_types']    = '*';
                    $config['file_name']        = $new_image_name;
                    $config['max_size']         = '0';
                    $config['max_width']        = '0';
                    $config['max_height']       = '0';
                    $config['min_width']        = '0';
                    $config['min_height']       = '0';
                    

                    $this->load->library('upload', $config);
                    
                    if($this->upload->do_upload('file')){
                         $notification_image['errCode']     = -1;
                         $image       = $config['upload_path'].$new_image_name;
                     
                    }  
                        
                }else{
                    $image = $this->input->post('old_image');
                }

                $data['image'] = $image;
    
                $addNotification = $this->AdminModel->update('notification',$filter,$data);
                if($addNotification){
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'success';
                }else{
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'failed';
                }
            }else{

                $returnArr['errCode'] = 3;
                foreach ($this->input->post() as $key => $value) {
                    $returnArr['message'][$key] = form_error($key);
                }
            }
            echo json_encode($returnArr);
    }
     public function getNotificationList(){

         $data = $row = array();

        // Fetch member's records
        $memData = $this->NotificationModel->getNotificationDetailsRows($_POST);
        

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
                                    <li><a href="#" id="'.$member->id.'" class="edit" data-toggle="modal" data-target="#edit_modal"><i class="icon-file-excel"></i> Edit</a></li>
                                    <li><a href="'.base_url().'Notification/sendnotification/'.$member->id.'"><i class="icon-file-excel"></i> Send</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';

            $image = '<img src="'.base_url().$member->image.'" width="50px" height="50px">';

            $data[] = array(
                            $member->id,
                            $member->title, 
                            $image,
                            $member->activity,
                            $member->value_code,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->NotificationModel->countAllNotificationDetails(),
            "recordsFiltered" => $this->NotificationModel->countFilteredCustomerDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function sendNotificationForm(){
        //get notification details
        $notif_id = $this->uri->segment(3);
        $filter   = array('notif_id'=>$notif_id);
        $data['notification_data'] = $this->dealer_model->getNotificationDetailsData($filter);
        $data['regions']            = $this->dealer_model->getAllRegion();
        $this->load->view('header');
        $this->load->view('menu');              
        $this->load->view('dealers/notifications',$data); 
        $this->load->view('footer');
    }
    public function setCronNotification(){
        $send_time = date('Y-m-d H:i');

        $ids = $this->dealer_model->getCronAllNotificationList($send_time);
        
        foreach($ids as $row){
            $this->sendnotification($row['notif_id']);
        }
    }
    public function sendnotification($id){

        
            // $id = $this->uri->segment(3);
            $filter = array('id'=>$id);
            $notification_details = $this->AdminModel->getDetails('notification',$filter);

            $notificationId      = $notification_details['id'];        
            $notification_title  = $notification_details['title'];
            $activity            = $notification_details['activity'];
            $valuecode           = $notification_details['value_code'];
            $notification_body   = $notification_details['description'];
            $notify_image        = $notification_details['image'];
            $notification_filter = 'all';

            if($notification_filter == "all"){
            $app_registration_ids = $this->NotificationModel->getAllAppId();

            $j = 1;
            $k = 0;
            $c = 0;
            $count = count($app_registration_ids);

            $fcm_id = array_chunk($app_registration_ids,300);



            foreach ($fcm_id as $row) {

                $registration_ids = array_map(function($value) {
                                        return $value['fcm_token'];
                                    }, $row);


                $result = $this->send_bulk_notification($registration_ids, $notification_body, $notification_title,$activity,$valuecode,$notify_image,$notificationId); 

                $countResult = count($result);
                for($i = 0;$i < $countResult;$i++){
                    if(!isset($result[$i]['message_id'])){
                        $received_status = 0;
                    }else{
                        $received_status = 1;
                    }

                    $notificationLog[] = array('notification_id'  =>$notificationId,
                                               'customer_id'      =>$app_registration_ids[$c]['id'],
                                               'received_status'  => $received_status
                                            );

                    $c++;
                }
                $addNotificationLog = $this->AdminModel->insertBatch('notification_log',$notificationLog);
                $notificationLog = '';
                
                $k++;
                sleep(30);
            }
            

           
        }else if($notification_filter == 'region'){
            
            if($region_id == "all")
                $app_registration_ids = $this->dealer_model->getAllAppId();
            else    
                $app_registration_ids = $this->dealer_model->getRegionAppId($region_id);

            $j = 1;
            $k = 0;
            $c = 0;
            $count = count($app_registration_ids);

            $fcm_id = array_chunk($app_registration_ids,300);


            foreach ($fcm_id as $row) {
                
                $registration_ids = array_map(function($value) {
                                        return $value['fcm_id'];
                                    }, $row);

                $result = $this->send_bulk_notification($registration_ids, $notification_body, $notification_title,$activity,$valuecode,$notify_image,$notificationId); 

                $countResult = count($result);
                for($i = 0;$i < $countResult;$i++){
                    if(!isset($result[$i]['message_id'])){
                        $received_status = 0;
                    }else{
                        $received_status = 1;
                    }

                    $notificationLog[] = array('notification_id'  =>$notificationId,
                                               'dealer_id'        =>$app_registration_ids[$c]['dealer_id'],
                                               'received_status'  => $received_status
                                            );

                    $c++;
                }
                $addNotificationLog = $this->dealer_model->insertNotificationLog('notification_log',$notificationLog);
                $notificationLog = '';
                
                $k++;
                sleep(30);
            }

            
            
        }else if($notification_filter == "appID"){
            
            $ids                = explode(',',$app_id);

            foreach($ids as $row){
                $registration_ids[] = $row;
            }

            $result = $this->send_bulk_notification($registration_ids, $notification_body, $notification_title,$activity,$valuecode,$notify_image,$notificationId);
            $countResult = count($result);


            $filter = array('fcm_id'=>$ids);
            $app_registration_ids = $this->dealer_model->getDealerInfoData($filter);

            for($i = 0;$i < $countResult;$i++){

                if(!isset($result[$i]['message_id'])){
                        $received_status = 0;
                    }else{
                        $received_status = 1;
                    }

                $notificationLog[] = array('notification_id'=>$notificationId,
                                           'dealer_id'      =>$app_registration_ids['dealer_id'],
                                           'received_status'=> $received_status
                                        );
            }

            $addNotificationLog = $this->dealer_model->insertNotificationLog($notificationLog);
        }else{



            $phone_numbers       = explode(",",$phone_numbers);
            
            $app_registration_ids = $this->dealer_model->getFCMId($phone_numbers);


            $registration_ids = array();

            $j = 1;
            $k = 0;
            $c = 0;
            $count = count($app_registration_ids);

            $fcm_id = array_chunk($app_registration_ids,300);


            foreach ($fcm_id as $row) {
                
                $registration_ids = array_map(function($value) {
                                        return $value['fcm_id'];
                                    }, $row);

                $result = $this->send_bulk_notification($registration_ids, $notification_body, $notification_title,$activity,$valuecode,$notify_image,$notificationId); 

                $countResult = count($result);
                for($i = 0;$i < $countResult;$i++){
                    if(!isset($result[$i]['message_id'])){
                        $received_status = 0;
                    }else{
                        $received_status = 1;
                    }

                    $notificationLog[] = array('notification_id'  =>$notificationId,
                                               'dealer_id'        =>$app_registration_ids[$c]['dealer_id'],
                                               'received_status'  => $received_status
                                            );

                    $c++;
                }
                $addNotificationLog = $this->dealer_model->insertNotificationLog($notificationLog);
                $notificationLog = '';
                
                $k++;
                sleep(30);
            }

        }

        //update status
        $n_filter = array('id'=>$notificationId);
        $n_data   = array('status'  =>'1');
        $update_status = $this->AdminModel->update('notification',$n_filter,$n_data);

        redirect(base_url().'/Notification/notificationList');    
            

    }

    public function file_check($str){
        $allowed_mime_type_arr = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        
        if(!empty($_FILES)){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
                if(in_array($mime, $allowed_mime_type_arr)){
                    return true;
                }else{
                    $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png/csv file.');
                    return false;
                }
            }else{

                $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
                return false;
        }
    }

    private function send_bulk_notification($registration_ids, $notification_body, $notification_title,$activity,$valuecode,$notification_image){
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    
        $extraNotificationData = ["message" => $notification_body,"activity" =>$activity,'valuecode'=>$valuecode];
        $notification = [
            'title'         => $notification_title,
            'body'          => $notification_body,
            'icon'          =>'myIcon', 
            'sound'         => 'mySound',
            'activity'      => $activity,
            'valuecode'     => $valuecode,
            'image'         => $notification_image 
        ];
       

        $fcmNotification = [
            'registration_ids' => $registration_ids,
            'data'             => $notification,
            'output'           => $extraNotificationData
        ];


        $headers = [
            'Authorization: key= '.API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        
        $response = json_decode($result,true);

        curl_close($ch);

        //echo json_encode($fcmNotification);
        return $response['results'];    
    }
   

}
