<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function newsList(){
        $data['news']    = $this->AdminModel->getList('news');
        $this->load->view('news/news',$data);
    }
    public function newsForm(){
        $this->load->view('news/add_news');
    }
    public function addNews(){
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('title'=>$this->input->post('title'));

            $checkMenu = $this->AdminModel->getDetails('news',$filter);
            if($checkMenu){
                    $returnArr['errCode']                   = 3;
                    $returnArr['messages']['title']      = '<p class="error">News Already Exists</p>';
            }else{  
                    if(isset($_FILES)){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['message']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = '';
                    }

                    $data = array('image'           =>$image,
                                  'title'           =>$this->input->post('title'),
                                  'description'     =>$this->input->post('description'),
                                  'status'          =>'1'
                              );

                    $addExperience = $this->AdminModel->insert('news',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'News Added Successfully';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
            }
        }else{
            $returnArr['errCode'] = 3;

            $returnArr['message']['file'] = form_error('file');
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function editNews(){
        $filter = array('id'=>$this->uri->segment(3));

        $news = $this->AdminModel->getDetails('news',$filter);
        if($news){
            $data['news'] = $news;
            $this->load->view('News/edit_news',$data);
        }else{
            redirect(base_url().'News/newsList');
        }
    }
    public function updateNews(){

       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'title'=>$this->input->post('title'));

            $news = $this->AdminModel->getDetails('news',$filter);
            if($news){
                    $returnArr['errCode']               = 3;
                    $returnArr['message']['title']      = '<p class="error">News Already Exists</p>';
            }else{

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

                $filter     = array('id'=>$this->input->post('id'));
                 $data = array('image'           =>$image,
                               'title'           =>$this->input->post('title'),
                               'description'     =>$this->input->post('description'),
                               'status'          =>$this->input->post('status')
                              );


                $news = $this->AdminModel->update('news',$filter,$data);
                if($news){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'News Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']     = 'Please try again';
                }
            }
            
        }else{

            print_r(validation_errors());exit;

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
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

    public function deleteNews(){
        $id = $this->uri->segment(3);
        if($id){
            $filter = array('id'=>$id);
            $data   = array('status'=>'0');

            $update = $this->AdminModel->update('news',$filter,$data);

            if($update){
                $returnArr['error'] = false;
                $returnArr['message'] = 'Delete Successfully';
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'Please trya again';
            }
        }else{
            $returnArr['error'] = true;
            $returnArr['message'] = 'Id is required';
        }
        echo json_encode($returnArr);

    }

}
