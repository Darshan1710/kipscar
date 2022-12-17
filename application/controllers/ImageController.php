<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImageController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AdminModel');
    }

    public function gallery($id) {
        
        $filter = array('product_id'=>$id,'status'=>'1','type'=>'1');
        $album_data = $this->AdminModel->getList('product_images',$filter);

        $data = array();
        if($album_data){
            $index = 0;
            foreach ($album_data as $row){

                    $data['images'][$index]['id']        = $row['id'];
                    $data['images'][$index]['thumbnail'] = $row['product_images'];
                    $index++;
            }
        }        


        $this->load->view('product/gallery', $data);
    }
    //
     public function create_album() {
        $album_id = NULL;
        $input_data = $this->input->post();
        $filter = array('album_name'=>$input_data['album_name']);
        $album_exist = $this->AdminModel->check_album_exist($filter);
        if(empty($album_exist)) {
        $path = "assets/images/album";
        $album = $path . '/' . $input_data['album_name'];
        $album_thumbnail = $path . '/' . $input_data['album_name'];

        $album_data = array(
            'album_name' => $input_data['album_name']        );

        $album_id = $this->AdminModel->insert_album_data($album_data);
        $album = $path . '/' . $album_id;

        $album_thumbnail = $path . '/' . $album_id;
        mkdir($album, 0755, TRUE);
        // mkdir($album_thumbnail, 0755, TRUE);
        }
        if($album_id){
            $result = array('status'=>'true','album_id'=>$album_id);
        }else{
            $result = array('status'=>'false','album_id'=>'');
        }

        echo json_encode($result);
    }
    
    public function album_name_exist() {  
        $this->Admin_model->check_album_exist();
    }
    public function deleteAlbum(){
        $album_id = $this->uri->segment(3);
        $filter = array('album_id'=>$album_id);
        $album_details = $this->AdminModel->getPhotoList($filter);

        if($album_details){
            foreach($album_details as $row){
                unlink('assets/images/album/'.$row['album_id'].'/'.$row['image']);    
            }    
        }
        
        
        $deletePhoto = $this->AdminModel->deletePhoto($filter);

        rmdir('assets/images/album/'.$album_id);

        $deleteAlbum = $this->AdminModel->deleteAlbum($filter);
        if($deletePhoto){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'Delete Successfully';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'Error Occur';
        }
        echo json_encode($returnArr);
    } 
    public function view_photos($product_id) {

        $filter = array('id'=>$product_id);
        $product_details = $this->AdminModel->getDetails('products',$filter);
        $data['name'] = $product_details['vehicale_name'].' ('.$product_details['model_no'].')';

        $p_filter = array('product_id'=>$product_id);
        $data['photo_data'] = $this->AdminModel->getList('product_images',$p_filter,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,'img_order');

        $this->load->view('product/viewPhoto', $data);
    }

    public function imageListView() {
        $data['data'] = $this->AdminModel->getImageDetails();
        $data['main_view'] = 'imageView';
        $this->load->view('base_template_admin', $data);
    }

    public function addImage() {
        $this->AdminModel->addImage();
    }

    public function deletePhoto() {
        $id = $this->input->post('id');
        $filter = array('id'=>$id);

        $photo_details = $this->AdminModel->getDetails('product_images',$filter);

        unlink('.'.$photo_details['product_images']);
        $data = array('status'=>'0');

        $deletePhoto = $this->AdminModel->update('product_images',$filter,$data);
        if($deletePhoto){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'Delete Successfully';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'Error Occur';
        }
        echo json_encode($returnArr);
    }
    public function upload_photo($album_id) {
        

        if($album_id){
            $filter = array('product_id'=>$album_id);
            $images = $this->AdminModel->getList('product_images',$filter);

            

            if(COUNT($images) < 8){
                $image_name = $this->input->post('file');
                if(!empty($_FILES['file']['name'])){

                    $extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

                    $config['upload_path'] = './uploads';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['file_name'] = time().'.'.$extension;
                    $config['max_size'] = '10000';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 784;                
                    $config['height'] = 588;
                    $config['overwrite'] = TRUE;
                    $config['remove_spaces'] = TRUE;
                    
                    $this->load->library('upload', $config);

                         if (!$this->upload->do_upload('file'))
                        {
                            $error = array('error' => $this->upload->display_errors());  

                            $returnArr['error'] = 2;
                            $returnArr['message'] = $error;
                        }
                        else
                        {
                            $upload_data =$this->upload->data();

                            
                            $config['source_image'] = $upload_data['full_path'];
                            //The image path,which you would like to watermarking
                            $config['image_library'] = 'gd2';
                            $config['wm_type'] = 'overlay';
                            $config['wm_overlay_path'] = './uploads/1.png';     //the overlay image
                            $config['wm_opacity'] = 50;
                            $config['wm_vrt_alignment'] = 'middle';
                            $config['wm_hor_alignment'] = 'center';
                            $this->image_lib->initialize($config);
                            if (!$this->image_lib->watermark()) {
                                return $this->image_lib->display_errors();
                            }
                            
                            
                            if($this->image_lib->watermark()){
                                $path_parts = pathinfo($upload_data['file_name']);
                                $image_path =  'uploads/'.$path_parts['filename'].'.'.$path_parts['extension'];
                                
                            }else{
                                 $errors =  $ci->image_lib->display_errors();

                                 $image_path = $errors;
                            }

                                $data = array(
                                    'product_images' => 'uploads/'.$config['file_name'],
                                    'product_id' => $album_id,
                                    'status'     =>'1'
                                 );
                                $this->AdminModel->insert('product_images',$data); 

                                $returnArr['error'] = -1;
                                $returnArr['message'] = 'Success';
                        }
                    }else{
                        $returnArr['error'] = 2;
                        $returnArr['message'] = 'Please Select File';
                    }

            }else{
                $returnArr['error'] = 2;
                $returnArr['message'] = 'Image limit exceed';
            }
        }else{
            $returnArr['error']   = 2;
            $returnArr['message'] = 'Package Not found';
        }

        echo json_encode($returnArr);
        
    }
    public function getImageDetails(){
        $id       = $this->input->post('id');
        $filter   = array('id'=>$id);
        $imageDetails = $this->AdminModel->getDetails('product_images',$filter);

        if($imageDetails){
            $returnArr['errCode'] = -1;
            $returnArr['data']    = $imageDetails;
          }else{
            $returnArr['errCode'] = 2;
            $returnArr['data']    = 'No data';
        }
        echo json_encode($returnArr);
    }

    public function updateImageDetails(){

        $this->form_validation->set_rules('photo_id','Photo Id','required|trim|xss_clean|numeric');
        if($this->form_validation->run()){
            $photo_id = $this->input->post('photo_id');
            $image    = $this->input->post('old_image');

            $filter = array('id'=>$photo_id);
            $imageDetails = $this->AdminModel->getDetails('product_images',$filter);

            $upload = upload_product_image($_FILES,'file');


            if($upload['errCode'] == -1){
                $image = $upload['image'];
                $returnArr['errCode']      = -1;
                $returnArr['message']      = 'success';

                $filter = array('id'=>$photo_id);
                $data = array(
                    'product_images'     => $upload['image']
                 );
                $this->AdminModel->update('product_images',$filter,$data);
            }else{
                $returnArr['errCode']      = 2;
                $returnArr['message']      = $upload['image'];
            }

            
        }else{
            $returnArr['errCode'] = 2;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function videoGallery(){
        $data['result']    = $this->AdminModel->getVideos();
        $data['main_view'] = 'video_gallery';
        $this->load->view('base_template_admin', $data);
    }
    public function addVideo(){
        if($this->session->userdata('logged_in')){
            $this->form_validation->set_rules('video','Video URL','required|trim|max_length[255]');
            if($this->form_validation->run()){
                $video = $this->input->post('video');

                $url_array = explode('=',$video);
                $data = array('video'=>end($url_array));

                $add_video = $this->AdminModel->addVideo($data);
                redirect(base_url().'ImageController/videoGallery');
            }else{  
                $data['main_view'] = 'video_gallery';
                $this->load->view('base_template_admin', $data);           
            }
        }else{
            redirec(base_url());
        }
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
                $data = array('img_order' => $count); 
                $update = $this->AdminModel->update('product_images',$filter, $data); 
                $count++;     
            } 
             
        } 
         
        return true; 
    }
    
    
     

}
