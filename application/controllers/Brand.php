<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function brandList(){
        $data['brand'] = $this->AdminModel->getList('brand');
        $this->load->view('brand/brand',$data);
    }
    public function addBrand(){
        $this->form_validation->set_rules('brand','Brand','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('brand'=>$this->input->post('brand'));

            $checkMenu = $this->AdminModel->getDetails('brand',$filter);
            if($checkMenu){
                    $returnArr['errCode']                   = 3;
                    $returnArr['messages']['brand']      = '<p class="error">Brand Already Exists</p>';
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

                    $data = array('brand'           =>$this->input->post('brand'),
                                  'image'           =>$image,
                                  'status'          =>$this->input->post('status')
                              );

                    $addExperience = $this->AdminModel->insert('brand',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Brand Added Successfully';
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
    public function editBrand(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $category = $this->AdminModel->getDetails('brand',$filter);
            if($category){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $category;
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
    public function updateBrand(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('brand','Brand','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'brand'=>$this->input->post('brand'));

            $brand_data = $this->AdminModel->getDetails('brand',$filter);
            if($brand_data){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['brand']      = '<p class="error">Brand Already Exists</p>';
            }else{
                if(isset($_FILES) && !empty($_FILES)){
                    $upload = upload_image($_FILES,'file');

                    if($upload['errCode'] == -1){
                        $image = $upload['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['messages']['image']      = $upload['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $image = $this->input->post('old_image');
                }

                $filter     = array('id'=>$this->input->post('id'));
                 $data = array('brand'          =>$this->input->post('brand'),
                               'image'          =>$image,
                               'status'          =>$this->input->post('status')
                              );
                $updateMenu = $this->AdminModel->update('brand',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'Brand Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']     = 'Please try again';
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

    public function deleteBrand(){
        $id = $this->uri->segment(3);
        if($id){
            $update = $this->AdminModel->deleteBatch('brand','id',$id);

            $update = $this->AdminModel->deleteBatch('categories','brand_id',$id);

            $update = $this->AdminModel->deleteBatch('products','brand_id',$id);

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

    public function viewBrand(){
        $filter = array('status'=>'1');
        $data['brand'] = $this->AdminModel->getList('brand',$filter,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,'sequence');

        $this->load->view('brand/viewBrand',$data);
    }

    public function orderUpdate(){ 
        // Get id of the images 
        $ids = $this->input->post('ids'); 
        

        if(!empty($ids)){ 
            // Generate ids array 
            $idArray = explode(",", $ids); 
             
            $count = 1; 
            foreach ($idArray as $id){ 
                // Update image order by id 
                $filter = array('id'=>$id);
                $data = array('sequence' => $count); 
                $update = $this->AdminModel->update('brand',$filter, $data); 
                $count++;     
            } 
             
        } 
         
        return true; 
    }

}
