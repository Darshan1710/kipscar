<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Banner
    public function bannerList(){
        if($this->session->userdata('logged_in')){
            $filter = array('deleted_at'=>null);
            $data['banner'] = $this->AdminModel->getList('banners',$filter);
            $this->load->view('banner/bannerList',$data);
        }else{
            redirect(base_url().'Admin/logout');
        }
    }
    public function addBanner(){ 
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('activity','Activity','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('value_code','Value Code','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();


            if(isset($_FILES)){
                $upload = upload_image($_FILES,'file');

                if($upload['errCode'] == -1){
                    $image = $upload['image'];
                }else{
                    $returnArr['errCode']      = 3;
                    $returnArr['messages']['image']      = $upload['image'];
                    echo json_encode($returnArr);exit;
                }
            }else{
                $image = '';
            }

            $data = array(  'image'         => $image,
                            'activity'      => $input_data['activity'],
                            'value_code'    => $input_data['value_code'],
                            'active'        => $input_data['active']  
                            );

            $result = $this->AdminModel->insert('banners',$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Added Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{

            $returnArr['message']['file'] = form_error('file');
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function editBanner(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->AdminModel->getDetails('banners',$filter);


            $returnArr['errCode'] = -1;
            $returnArr['data']    = $result;
            
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function updateBanner(){ 
        $this->form_validation->set_rules('activity','Activity','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('value_code','Value Code','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            if(isset($_FILES) && !empty($_FILES['file']['name'])){
                $upload = upload_image($_FILES,'file');

                if($upload['errCode'] == -1){
                    $image = $upload['image'];
                }else{
                    $returnArr['errCode']      = 3;
                    $returnArr['message']['image']      = $upload['image'];
                    echo json_encode($returnArr);exit;
                }
            }else{
                $image = $this->input->post('old_image');
               
            }

            $filter = array('id'=>$input_data['id']);
            $data = array(  'image'         => $image,
                            'activity'      => $input_data['activity'],
                            'value_code'    => $input_data['value_code'],
                            'active'        => $input_data['active']  
                            );
            
            $result = $this->AdminModel->update('banners',$filter,$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Updated Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            $returnArr['message']['file'] = form_error('file');
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }

    public function file_check($str){
        $allowed_mime_type_arr = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
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
    }
   

}
