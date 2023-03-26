<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

     public function getProductList(){
        $filter = array('status'=>'1');
        $products = $this->AdminModel->getList('products',$filter);
        if($products){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = $products;
        }else{  
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'No products found';
        }
        echo json_encode($returnArr);
    }
    public function getProductDetails(){
        $id = $this->input->post('id');

        $filter = array('status'=>'1','p.id'=>$id);
        $products = $this->AdminModel->getProductData($filter);

        if($products){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = $products;
        }else{  
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'No products found';
        }
        echo json_encode($returnArr);
    }
    public function productList(){
        
        // $c_filter = array('status'=>'1');
        // $data['category'] = $this->AdminModel->getList('categories',$c_filter);
        // $product = $this->AdminModel->getProductList('products');
        // $i = 0;
        // foreach($product as $row){
        //     $filter = array('product_id'=>$row['product_id'],
        //                     'section_id'=>'1'
        //                 );
        //     $new_products = $this->AdminModel->getDetails('home_section_products',$filter);

        //     $product[$i]['new_products'] = isset($new_products) ? '1' : '0';

        //     $filter = array('product_id'=>$row['product_id'],
        //                     'section_id'=>'2'
        //                 );
        //     $top_selling_products = $this->AdminModel->getDetails('home_section_products',$filter);

        //     $product[$i]['top_selling_products'] = isset($top_selling_products) ? '1' : '0';

        //     $i++;
        // }

        // $data['category'] = $this->AdminModel->getList('categories');
        $data['brand'] = $this->AdminModel->getList('brand');
        $data['home_sections'] = $this->AdminModel->getList('home_sections');
        // $data['product']     = $product;
        $this->load->view('product/products',$data);
    }
    public function getProductListDetails(){

         $data = $row = array();

     //     echo "<pre>";
       //   print_r($_POST);exit;

        // Fetch member's records
        $memData = $this->AdminModel->getProductDetailsRows($_POST);
        
   //     echo $this->db->last_query();exit;
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
                                                    <li><a href="'.base_url().'Product/editProduct/'.$member->product_id.'" id="'.$member->product_id.'"><i class="icon-file-pdf"></i> Edit</a></li>
                                                    
                                                    <li><a href="'.base_url().'ImageController/gallery/'.$member->product_id.'"><i class="icon-file-excel"></i> Add Images</a></li>
                                                    <li><a href="'.base_url().'ImageController/view_photos/'.$member->product_id.'"><i class="icon-file-excel"></i> Reorder Images</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>';


            $image_url = !empty($member->image)  ? base_url().$member->image : 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg';

            $image = '<img src="'.$image_url.'" width="50px" height="50px">';


            if($member->new_products == '1'){
                $new_products = '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $new_products =  '<button class="btn btn-danger btn-sm">Inactive</button>';
            };

            if($member->top_selling_products == '1'){
                $top_selling_products =  '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $top_selling_products = '<button class="btn btn-danger btn-sm">Inactive</button>';
            } 
                                    
            if($member->status == '1'){
                $status =  '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $status = '<button class="btn btn-danger btn-sm">Inactive</button>';
            } 
                                    

            $data[] = array($member->product_id,
                            $i,
                            $action,
                            $image,
                            $member->model_no,
                            $member->vehicale_name, 
                            $member->brand,
                            $member->category,
                            $member->mrp,
                            $new_products,
                            $top_selling_products,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->created)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllProductDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredProductDetails ($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }

    public function addProduct(){

        $this->form_validation->set_rules('model_no','Model No','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('vehicale_name','Vehical Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('brand_id','Brand','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mrp','MRP','required|trim|xss_clean|max_length[255]');
        
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','');
        $this->form_validation->set_rules('vehical_application','Vehical Application','trim|xss_clean');
        $this->form_validation->set_rules('other_information','Other Information','trim|xss_clean');
        $this->form_validation->set_rules('disclaimer','Disclaimer','trim|xss_clean');
        $this->form_validation->set_rules('features','Features','');
        $this->form_validation->set_rules('youtube_1','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_1','Youtube Thumbnail','');
        $this->form_validation->set_rules('youtube_2','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_2','Youtube Thumbnail','');
        $this->form_validation->set_rules('youtube_3','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_3','Youtube Thumbnail','');
        $this->form_validation->set_rules('installation_pdf','Installation PDF','');
        $this->form_validation->set_rules('color_code','Color Code','required');
        $this->form_validation->set_rules('background_color','Background Color','required');
        

        if($this->form_validation->run()){
            $filter = array('model_no'=>$this->input->post('model_no'));

            $checkMenu = $this->AdminModel->getDetails('products',$filter);
         
                     $image = '';
                    $youtube_thumbnail_1 = '';
                    $youtube_thumbnail_2 = '';
                    $youtube_thumbnail_3 = '';
                    $installation_pdf = '';

                    if(isset($_FILES)){


                        $upload = upload_product_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['message']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }

                        if(!empty($_FILES['youtube_thumbnail_1']['name'])){
                            $youtube_thumbnail_1 = upload_image($_FILES,'youtube_thumbnail_1');

                            if($youtube_thumbnail_1['errCode'] == -1){
                                $youtube_thumbnail_1 = $youtube_thumbnail_1['image'];
                            }else{
                                $returnArr['errCode']      = 3;
                                $returnArr['message']['youtube_thumbnail_1']      = $youtube_thumbnail_1['image'];
                                echo json_encode($returnArr);exit;
                            }
                        }

                        if(!empty($_FILES['youtube_thumbnail_2']['name'])){
                            $youtube_thumbnail_2 = upload_image($_FILES,'youtube_thumbnail_2');
                            if($youtube_thumbnail_2['errCode'] == -1){
                                $youtube_thumbnail_2 = $youtube_thumbnail_2['image'];
                            }else{
                                $returnArr['errCode']      = 3;
                                $returnArr['message']['youtube_thumbnail_2']      = $youtube_thumbnail_2['image'];
                                echo json_encode($returnArr);exit;
                            }
                        }

                        if(!empty($_FILES['youtube_thumbnail_3']['name'])){
                            $youtube_thumbnail_3 = upload_image($_FILES,'youtube_thumbnail_3');
                            if($youtube_thumbnail_3['errCode'] == -1){
                                $youtube_thumbnail_3 = $youtube_thumbnail_3['image'];
                            }else{
                                $returnArr['errCode']      = 3;
                                $returnArr['message']['youtube_thumbnail_3']      = $youtube_thumbnail_3['image'];
                                echo json_encode($returnArr);exit;
                            }
                        }

                        if(!empty($_FILES['installation_pdf']['name'])){
                            $installation_pdf = upload_image($_FILES,'installation_pdf');
                            if($installation_pdf['errCode'] == -1){
                                $installation_pdf = $installation_pdf['image'];
                            }else{
                                $returnArr['errCode']      = 3;
                                $returnArr['message']['installation_pdf']      = $installation_pdf['image'];
                                echo json_encode($returnArr);exit;
                            }
                        }
                    }


                    $model_no = $this->input->post('model_no');
                    $data = array('model_no'    =>$this->input->post('model_no'),
                                  'vehicale_name'    =>$this->input->post('vehicale_name'),
                                  'image'       =>$image,
                                  'brand_id'    =>$this->input->post('brand_id'),
                                  'category_id' =>$this->input->post('category_id'),
                                  'mrp'         =>$this->input->post('mrp'),
                                  'status'      =>$this->input->post('status'),
                                  'description' =>$this->input->post('description'),
                                  'vehical_application' =>$this->input->post('vehical_application'),
                                  'features' =>$this->input->post('features'),
                                  'other_information' =>$this->input->post('other_information'),
                                  'disclaimer' =>$this->input->post('disclaimer'),
                                  'color_code' =>$this->input->post('color_code'),
                                  'background_color'=>$this->input->post('background_color'),
                                  'tags'       =>str_replace(['-', ':', '/'], '', $model_no),
                                  'installation_pdf' => $installation_pdf
                              );

                    $id = $this->AdminModel->insert('products',$data);

                    if($id){


                        $video_data[] = array('product_id'=>$id,
                                            'product_images'=>$youtube_thumbnail_1,
                                            'video' =>$this->input->post('youtube_1'),
                                            'type'=>'2',
                                            'status'=>'1'
                                        );

                        $video_data[] = array('product_id'=>$id,
                                            'product_images'=>$youtube_thumbnail_2,
                                            'video' =>$this->input->post('youtube_2'),
                                            'type'=>'2',
                                            'status'=>'1'
                                        );

                        $video_data[] = array('product_id'=>$id,
                                            'product_images'=>$youtube_thumbnail_3,
                                            'video' =>$this->input->post('youtube_3'),
                                            'type'=>'2',
                                            'status'=>'1'
                                        );

                        $this->AdminModel->insertBatch('product_images',$video_data);

                        $returnArr['errCode']     = -1;
                        $returnArr['product_id']  = $id;
                        $returnArr['product_type'] = $this->input->post('product_type');
                        $returnArr['message']  = 'Products Added Successfully';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
            
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
            $returnArr['message']['file'] = form_error('file');
        }
        echo json_encode($returnArr);
    }
    public function imageUpload(){
        if(isset($_FILES)){
            $upload = upload_image($_FILES,'upload');

            if($upload['errCode'] == -1){
                $url = base_url().$upload['image'];
            }else{
                $url = $upload['image'];
            }
        }else{
            $url = '';
        }

        echo json_encode(array('url'=>$url));
    }
    public function editProduct(){
            

            $b_filter = array('status'=>'1');
            $data['brand'] = $this->AdminModel->getList('brand',$b_filter);



            $filter = array('id'=>$this->uri->segment(3));

            $data['product'] = $this->AdminModel->getDetails('products',$filter);

            $c_filter = array('status'=>'1','brand_id'=>$data['product']['brand_id']);
            $data['category'] = $this->AdminModel->getList('categories',$c_filter);

            $video_filter = array('product_id'=>$this->uri->segment(3),
                                  'type'=>'2');
            $youtube_details = $this->AdminModel->getList('product_images',$video_filter);
            
            foreach($youtube_details as $key => $row){
                $data['youtube_thumbnail_'.++$key] = $row['product_images'];
                $data['youtube_'.$key] = $row['video'];
            }

           

            $this->load->view('product/editProduct',$data);

    }
    public function updateProduct(){
       $this->form_validation->set_rules('model_no','Model No','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('vehicale_name','Vehical Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('brand_id','Brand','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mrp','MRP','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','');
        $this->form_validation->set_rules('vehical_application','Vehical Application','trim|xss_clean');
        $this->form_validation->set_rules('other_information','Other Information','trim|xss_clean');
        $this->form_validation->set_rules('disclaimer','Disclaimer','trim|xss_clean');
        $this->form_validation->set_rules('features','Features','');
        $this->form_validation->set_rules('youtube_1','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_1','Youtube Thumbnail','');
        $this->form_validation->set_rules('youtube_2','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_2','Youtube Thumbnail','');
        $this->form_validation->set_rules('youtube_3','Youtube','');
        $this->form_validation->set_rules('youtube_thumbnail_3','Youtube Thumbnail','');
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('color_code','Color Code','required');
        $this->form_validation->set_rules('background_color','Background Color','required');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'model_no'=>$this->input->post('model_no'));

    
            $product_data = $this->AdminModel->getDetails('products',$filter);



            // if($product_data){
            //         $returnArr['errCode']               = 3;
            //         $returnArr['messages']['model_no']      = '<p class="error">Product Already Exists</p>';
            // }else{
                if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){

                    $upload = upload_product_image($_FILES,'image');

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

                //
                if(isset($_FILES['new_thumbnail_1']['name']) && !empty($_FILES['new_thumbnail_1']['name'])){

                    $youtube_thumbnail_1 = upload_image($_FILES,'new_thumbnail_1');

                    if($youtube_thumbnail_1['errCode'] == -1){
                        $youtube_thumbnail_1 = $youtube_thumbnail_1['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['messages']['image']      = $youtube_thumbnail_1['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $youtube_thumbnail_1 = $this->input->post('old_thumbnail_1');
                }

                if(isset($_FILES['new_thumbnail_2']['name']) && !empty($_FILES['new_thumbnail_2']['name'])){

                    $youtube_thumbnail_2 = upload_image($_FILES,'new_thumbnail_2');

                    if($youtube_thumbnail_2['errCode'] == -1){
                        $youtube_thumbnail_2 = $youtube_thumbnail_2['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['messages']['image']      = $youtube_thumbnail_2['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $youtube_thumbnail_2 = $this->input->post('old_thumbnail_2');
                }

                if(isset($_FILES['new_thumbnail_3']['name']) && !empty($_FILES['new_thumbnail_3']['name'])){

                    $youtube_thumbnail_3 = upload_image($_FILES,'new_thumbnail_3');

                    if($youtube_thumbnail_3['errCode'] == -1){
                        $youtube_thumbnail_3 = $youtube_thumbnail_3['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['messages']['image']      = $youtube_thumbnail_3['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $youtube_thumbnail_3 = $this->input->post('old_thumbnail_3');
                }

                if(isset($_FILES['installation_pdf']['name']) && !empty($_FILES['installation_pdf']['name'])){

                    $installation_pdf = upload_image($_FILES,'installation_pdf');

                    if($installation_pdf['errCode'] == -1){
                        $installation_pdf = $installation_pdf['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['messages']['image']      = $installation_pdf['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $installation_pdf = $this->input->post('old_installation_pdf');
                }



                $filter     = array('id'=>$this->input->post('id'));
                $data = array(  'model_no'    =>$this->input->post('model_no'),
                                'vehicale_name'    =>$this->input->post('vehicale_name'),
                                'brand_id'  =>$this->input->post('brand_id'),
                                  'image'       =>$image,
                                  'category_id' =>$this->input->post('category_id'),
                                  'mrp'         =>$this->input->post('mrp'),
                                  'status'      =>$this->input->post('status'),
                                  'description' =>$this->input->post('description'),
                                  'vehical_application' =>$this->input->post('vehical_application'),
                                  'features' =>$this->input->post('features'),
                                  'other_information' =>$this->input->post('other_information'),
                                  'disclaimer' =>$this->input->post('disclaimer'),
                                  'color_code' =>$this->input->post('color_code'),
                                  'background_color' =>$this->input->post('background_color'),
                                  'installation_pdf' => $installation_pdf
                              );

                $updateMenu = $this->AdminModel->update('products',$filter,$data);


                $i_filter = array('product_id'=>$this->input->post('id'));
                $i_data   = $this->AdminModel->getDetails('product_images',$i_filter);

                if(empty($i_data)){
                    $image_data = array('product_id'=>$this->input->post('id'),
                                        'product_images'=>$image);
                    $this->AdminModel->insert('product_images',$image_data);
                }
            

                if($updateMenu){

                    $video_filter = array('product_id'=>$this->input->post('id'),
                                        'type'      =>'2');

                    $video = $this->AdminModel->delete('product_images',$video_filter);
                    
                    $video_data[] = array('product_id'=>$this->input->post('id'),
                                        'product_images'=>$youtube_thumbnail_1,
                                        'video' =>$this->input->post('youtube_1'),
                                        'type'=>'2',
                                        'status'=>'1'
                                    );

                    $video_data[] = array('product_id'=>$this->input->post('id'),
                                        'product_images'=>$youtube_thumbnail_2,
                                        'video' =>$this->input->post('youtube_2'),
                                        'type'=>'2',
                                        'status'=>'1'
                                    );

                    $video_data[] = array('product_id'=>$this->input->post('id'),
                                        'product_images'=>$youtube_thumbnail_3,
                                        'video' =>$this->input->post('youtube_3'),
                                        'type'=>'2',
                                        'status'=>'1'
                                    );

                    $this->AdminModel->insertBatch('product_images',$video_data);
                     
                    
                    $returnArr['errCode']     = -1;
                    $returnArr['product_id']  = $this->input->post('id');
                    $returnArr['product_type']= $this->input->post('product_type');
                    $returnArr['message']  = 'Product Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            // }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }


        }
        echo json_encode($returnArr);
    }
    public function addSectionProductsStatus(){
        $ids = $this->input->post('ids');    
        $section = $this->input->post('section');
        
        $ids = explode(',',$ids);
        $ids = array_unique($ids);



        $filter = array('id'=>$section);
        $section_details = $this->AdminModel->getDetails('home_sections',$filter);

        if($section_details['title'] == 'Top Selling Products'){
            $section_name = 'top_selling_products';
        }else if($section_details['title'] == 'New Products'){
            $section_name = 'new_products';
        }

        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['product_id'] =$row;
            $data[$i]['section_id'] = $section;
            
            $product_data[$i]['id'] = $row;
            $product_data[$i][$section_name] = '1';
 
            $i++;


        }
            


        $update = $this->AdminModel->insertBatch('home_section_products',$data);

        $this->AdminModel->updateBatch('products',$product_data,'id');
        echo $this->db->last_query();exit;
        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function activateProductsStatus(){
        $ids = $this->input->post('ids');    
        
        $ids = explode(',',$ids);
        $ids = array_unique($ids);
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['status'] = '1';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function deactivateProductsStatus(){
        $ids = $this->input->post('ids');    
        
        $ids = explode(',',$ids);
        $ids = array_unique($ids);
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['status'] = '0';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function removeSectionProductsStatus(){
        $ids = $this->input->post('ids');    
        $section = $this->input->post('section');
  
        $product_data = [];
        $i = 0;

        $ids = explode(',',$ids);
        $ids = array_unique($ids);

        $filter = array('id'=>$section);
        $section_details = $this->AdminModel->getDetails('home_sections',$filter);

        if($section_details['title'] == 'Top Selling Products'){
            $section_name = 'top_selling_products';
        }else if($section_details['title'] == 'New Products'){
            $section_name = 'new_products';
        }

        
        foreach($ids as $row){            
            $product_data[$i]['id'] = $row;
            $product_data[$i][$section_name] = '2';
 
            $i++;
        }

        $delete = $this->AdminModel->updateBatch('products',$product_data,'id');
        

        if($delete){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function outOfStock(){
        $ids = $this->input->post('ids');    
        
  
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['out_of_stock'] = '1';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');
        
        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function stockIn(){
        $ids = $this->input->post('ids');    
        
  
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['out_of_stock'] = '0';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');
        
        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }

    public function importProductsForm(){
        $this->load->view('product/importProductsForm');
    }

    public function importProductsData(){
        $this->form_validation->set_rules('file','','callback_file_check');
        if($this->form_validation->run()){

                $new_image_name = time().str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['file']['name']);

                $config['upload_path']      = 'uploads/';
                $config['allowed_types']    = 'csv';
                $config['file_name']        = $new_image_name;
                $config['max_size']         = '0';
                $config['max_width']        = '0';
                $config['max_height']       = '0';
                $config['$min_width']       = '0';
                $config['min_height']       = '0';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('file');
                if(!$upload)
                {
                    $data['error'] = true;
                    $data['imageError'] =  $this->upload->display_errors();
                    
                }else{
                    $excelData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);


                    $csvData = $excelData['csvData'];
                    $errData = $excelData['errData'];

                    

                    if(!empty($csvData)){
                        $insertCount = $updateCount = $rowCount = $notAddCount = 0;


                        foreach($csvData as $row){
                            
                            if(!empty($row['Model No'])){
                                $rowCount++;
                                // $category_name = ucfirst(strtolower($row['Category']));


                                // //brand
                                // $b_filter = array('brand'=>$row['Brand']);
                                // $brand = $this->AdminModel->getDetails('brand',$b_filter);

                                // if($brand){
                                //     $brand_id = $brand['id'];
                                // }else{
                                //     $brand_data = array('brand'=>$row['Brand'],'status'=>'1');
                                //     $brand_id = $this->AdminModel->insert('brand',$brand_data);
                                // }

                                // $c_filter = array('brand_id'=>$brand_id,'category_name'=>$category_name);
                                // $category = $this->AdminModel->getDetails('categories',$c_filter);

                                // if($category){
                                //     $category_id = $category['id'];
                                // }else{
                                //     $category_data = array('category_name'=>$category_name,'brand_id'=>$brand_id);
                                //     $category_id = $this->AdminModel->insert('categories',$category_data);
                                // }

                                 $filter = array('model_no'=>$row['Model No']);
                                $product = $this->AdminModel->getDetails('products',$filter);

                                if($product){
                                    $filter = array('model_no'=>$row['Model No']);
                                    $data   = array(
                                                    // 'model_no'   =>$row['Model No'],
                                                    // 'brand_id'   =>$brand_id,
                                                    // 'category_id'=>$category_id,
                                                    'mrp'        =>$row['Price']

                                                    // ,
                                                    // 'description'=>$row['Discription'],
                                                    // 'vehical_application'=>$row['Vehical Application'],
                                                    // 'features'=>$row['Features'],
                                                    // 'other_information'=>$row['Other Information'],
                                                    // 'disclaimer'=>$row['Disclaimer'],
                                                    // 'status'    =>'1'
                                                   );
                                    $this->AdminModel->update('products',$filter,$data);
                                    $updateCount++;
                                }else{

                                    // $data   = array('model_no'   =>$row['Model No'],
                                    //                 'category_id'=>$category_id,
                                    //                 'brand_id'   =>$brand_id,
                                    //                 'mrp'        =>$row['Price'],
                                    //                 'description'=>$row['Discription'],
                                    //                 'vehical_application'=>$row['Vehical Application'],
                                    //                 'features'=>$row['Features'],
                                    //                 'other_information'=>$row['Other Information'],
                                    //                 'disclaimer'=>$row['Disclaimer'],
                                    //                 'status'    =>'1'
                                    //                );
                                    // $this->AdminModel->insert('products',$data);
                                    // $insertCount++;
                                }
                            }

                        }

                        $notAddCount = $rowCount - $insertCount;

                        $data['notAddCount'] = $notAddCount;
                        $data['rowCount']    = $rowCount;
                        $data['updateCount'] = $updateCount;
                        $data['insertCount'] = $insertCount;
                        $data['message']     = 'Import Successfully';

                        
                    }

                    if(!empty($errData)){
                        $this->exportErrorData($errData);
                    }

                    $this->load->view('product/importProductsForm',$data);               
                }

        }else{
            $this->load->view('product/importProductsForm');
        }

    }

    public function exportErrorData($errData){
        
             header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"test".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($errData as $data_array) {
                fputcsv($handle, $data_array);
            }
            fclose($handle);
            exit;
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
     public function attributeValues(){
        
        $id = $this->uri->segment(3);
        $data['product_id'] = $id;
        
        $filter = array('status'=>'1');
        $data['attributes'] = $this->AdminModel->getList('product_attribute',$filter);

        $this->load->view('product/attribute_values_form',$data);
    } 
    public function getAttributeValues(){
        $attribute_id = $this->input->post('id');

        $filter = array('id'=>$attribute_id);
        $values = $this->AdminModel->getList('product_attribute',$filter);

        $data = explode(',',$values);

        if(!empty($data)){
            $error = false;
            $message = $data;
        }else{
            $error = true;
            $message = '';
        }

        echo json_encode(array('error'=>$error,'message'=>$message));
    }

    public function addConfigurableProducts(){
         $this->form_validation->set_rules('product_id','Product Id','trim|xss_clean|max_length[255]');
          $this->form_validation->set_rules('attribute_id','Attribute Id','trim|xss_clean|max_length[255]');
          if($this->form_validation->run()){
            $id = $this->input->post('product_id');

            $filter = array('id'=>$id);
            $product = $this->AdminModel->getDetails('products',$filter);

            $product_data = array();
            $i = 1;
            if(!empty($_POST['packaging_size'][0])){
                foreach($this->input->post('packaging_size') as $key => $value){

                    $product_data = array('product_name'=>$product['product_name'],
                                            'sku'         =>$product['sku'].'_'.$i,
                                            'moq'         =>$_POST['moq'][$key],
                                            'packaging_size'=>$_POST['packaging_size'][$key],
                                            'image'       =>$product['image'],
                                            'unit_price'  =>$_POST['mrp'][$key],
                                            'sell_price'  =>$_POST['sell_price'][$key],
                                            'discount'    =>$_POST['discount'][$key],
                                            'seller_name' =>$product['seller_name'],
                                            'product_type'=>'1',
                                            'category_id' =>$product['category_id'],
                                            'sub_category'=>$product['sub_category'],
                                            'status'      =>'1',
                                            'active'      =>'2',
                                            'long_description'=>$product['long_description'],
                                            'short_description'=>$product['short_description']
                                        );

                    $add = $this->AdminModel->insert('products',$product_data);

                    $attribute_data = array('parent_id'=>$this->input->post('product_id'),
                                            'product_id'=>$add,
                                            'packaging_size'=>$_POST['packaging_size'][$key],
                                            );

                    $this->AdminModel->insert("product_attribute_values",$attribute_data);

                    $stock_data = array("product_id"=>$add,
                                        "stock_in"  =>$_POST['stock'][$key],
                                        "stock_out" =>0,
                                        "remaning_stock"=>$_POST['stock'][$key]
                                        );
                    $this->AdminModel->insert("stocks",$stock_data);

                    $i++;
                }

                //$add = $this->AdminModel->insertBatch('products',$product_data);

                if($add){
                    //foreach ($this->input->post('packaging_size') as $key => $value) {
                        
                    

                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'Add Successfully';
                }else{
                    $returnArr['errCode'] = 2;
                    $returnArr['message'] = 'Please try again';
                }
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please add some variants';
            }

            
            
          }else{
            $returnArr['errCode'] = 3;

            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
          }
          echo json_encode($returnArr);
    }

    public function deleteProduct(){
        $ids = $this->input->post('ids');    
        $section = $this->input->post('section');
        
        $ids = explode(',',$ids);
        $ids = array_unique($ids);

        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['status'] = '0';
            $i++;
        }

        
        $update = $this->AdminModel->updateBatch('products',$data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }

    public function deleteMultipleProduct(){


        $ids = $this->input->post('ids');   
        $ids = explode(',', $ids);
        $ids = array_unique($ids);     
        $update = $this->AdminModel->deleteBatch('products','id',$ids);

        $update = $this->AdminModel->deleteBatch('product_images','product_id',$ids);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }

    public function getSuggestionList(){
        $this->load->view('product/suggestion_list');
    }

     public function getSuggestiontListDetails(){

         $data = $row = array();

         // echo "<pre>";
         // print_r($_POST);exit;

        // Fetch member's records
        $memData = $this->AdminModel->getSuggestionProductDetailsRows($_POST);
        
      //  echo $this->db->last_query();exit;
        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $action = '<td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="'.base_url().'Product/suggestionForm/'.$member->product_id.'"><i class="icon-file-pdf"></i> Edit</a></li>
                                                    <li><a href="#" id="'.$member->id.'" class="delete" data-url="'.base_url().'Product/deleteSuggestedProduct/'.$member->id.'"><i class="icon-file-excel"></i> Delete</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>';


                           
            if($member->status == '1'){
                $status =  '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $status = '<button class="btn btn-danger btn-sm">Inactive</button>';
            } 
                                    

            $data[] = array($i,
                            $member->product_name,
                            $member->condition,
                            $member->suggested_product,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllSuggestionProductDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredSuggestionProductDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }

    public function suggestionForm($id){

        $filter = array('status'=>'1');
        $data['products'] = $this->AdminModel->getList('products',$filter);

        $data['condition'] = $this->AdminModel->getList('condition',$filter);
        
        $p_filter = array('status'=>'1');

        if($id != 'new'){
            $p_filter['product_id'] = $id;
        }else{
            $p_filter['product_id'] = 'new';
        }


        $data['model_no'] = $id;
        $data['product_details'] = $this->AdminModel->getList('suggested_products',$p_filter);


        $this->load->view('product/suggestion_form',$data);
    }

    public function getSuggestionData(){
        $filter = array('status'=>'1');
        $data['condition'] = $this->AdminModel->getConditions($filter);
        $data['products']  = $this->AdminModel->getProducts($filter);


        if(!empty($data['condition']) && !empty($data['products'])){
            $returnArr['errCode']  = -1;
            $returnArr['message'] = $data;
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'No data found';
        }

        echo json_encode($returnArr);
    }

    public function addSuggestedProduct(){
        
        $this->form_validation->set_rules('model_no','Model No','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){

            if(!empty($_POST['product'][0])){

                $add = false;
                $update = false;
                $this->db->trans_start();

                $sp_filter = array('product_id'=>$this->input->post('model_no'));
                $delete = $this->AdminModel->delete('suggested_products',$sp_filter);

               // echo $this->db->last_query();exit;
                foreach($this->input->post('product') as $key => $value){
                
                    if(!empty($_POST['product'][$key])){
                        $p_filter = array('product_id'=>$this->input->post('model_no'),
                                          'condition_id'=>$_POST['condition'][$key]
                                      );
                        $p_details = $this->AdminModel->getDetails('suggested_products',$p_filter);

                        if($p_details){

                            $s_data = array('suggested_product_id'=>$_POST['product'][$key]);
                            $update = $this->AdminModel->update("suggested_products",$p_filter,$s_data);
                        }else{
                            $s_data = array('product_id'=>$this->input->post('model_no'),
                                            'condition_id'=>$_POST['condition'][$key],
                                            'suggested_product_id'=>$_POST['product'][$key],
                                            'status'        =>'1'
                                      );
                            $add = $this->AdminModel->insert("suggested_products",$s_data);
                        }

                    }
                        
                }


                $this->db->trans_complete();

                if($add || $update){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'Data added Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }else{
                $returnArr['errCode']     = 5;
                $returnArr['message']     = '<p class="error">Condition and Product Name is required</p>';
            }
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            } 
        }
        echo json_encode($returnArr);
    }

    public function deleteSuggestedProduct(){
        $id = $this->uri->segment(3);
        if($id){


            $update = $this->AdminModel->deleteBatch('suggested_products','id',$id);

          //  $update = $this->AdminModel->deleteBatch('condition',$id);


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

    public function getModelNames(){

            $product = $this->AdminModel->getModelNames();
            if($product){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = $product;
            }else{
                $returnArr['error'] = 2;
                $returnArr['message'] = 'Please trya again';
            }
           echo json_encode($returnArr);

    }

    public function uploadImage(){
        $upload = upload_product_image($_FILES,'upload');
        if($upload['errCode'] == -1){
            $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
            $url = $upload['path'];
            $msg = 'Image uploaded Successfully';
            $image = $upload['image'];
            $output = '<script>window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.', "'.$url.'", "'.$msg.'")</script>';
        }else{
            $returnArr['errCode']      = 3;
            $returnArr['message']['image']      = $upload['image'];
            $output = '<script>alert("'.$upload['image'].'")</script>';
        }
        echo $output;
    }
}
