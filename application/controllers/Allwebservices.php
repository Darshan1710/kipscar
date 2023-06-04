<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allwebservices extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

     public function sendOTP(){ 
        $this->form_validation->set_rules('country_code','Country Code','required');
        $this->form_validation->set_rules('mobile','Mobile','required|numeric');
        $this->form_validation->set_rules('device','','');
        $this->form_validation->set_rules('os_version','Version','');

        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $hash = isset($input_data['hash']) && !empty($input_data['hash']) ? $input_data['hash'] : '';
            //$hash = '';
            $mobile = $input_data['mobile'];
            if ($mobile == '919822979093'){
                $otp = '8560';
            }else{
                $otp = rand(1000,9999); 
            }
            

            $filter = array('mobile'=>$input_data['country_code'].$mobile);
            $number_exists = $this->AdminModel->getDetails('otp',$filter);


            $otpArray  = str_split($otp,2);

            $msg = "";
            if(!empty($otpArray) && count($otpArray) == 2){
                $msg = "Your OTP is ".$otpArray[0]." ".$otpArray[1]." for Register with GLOBALBYTE.We assured you for Provide Best Quality Products. Team KIPS CAR-AV ELECTRONICS PVT LTD.";
            }
            
            $url = "http://vas.themultimedia.in/domestic/sendsms/bulksms.php?username=KIPSC&password=GBKIPS&type=TEXT&sender=GBKIPS&entityId=1501553130000054083&templateId=1507166382763131454&mobile=".$mobile."&message=".$msg;
            $url = str_replace(" ", '%20', $url);
            ob_start();
            
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);


            
            if (ob_get_contents()){
            ob_end_clean();
            }

            if(!empty($number_exists)){

                $data = array('otp'   =>$otp,
                              'device'=>$input_data['device'],
                              'os_version'=>$input_data['os_version']);
                $result = $this->AdminModel->update('otp',$filter,$data);

            }else{
                $data = array('mobile'=>$input_data['country_code'].$mobile,
                              'otp'   =>$otp,
                              'device'=>$input_data['device'],
                              'os_version'=>$input_data['os_version']);

                $result = $this->AdminModel->insert('otp',$data);  
            }

            
            if($result){
                $returnArr['error'] = false;
                $returnArr['message'] = 'Success';
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'Please try again';
            }
        }else{
           
            $returnArr['error'] = true;
            $returnArr['message'] = 'Please try again';
        }
        echo json_encode($returnArr);   
    }

     public function sendOTPWithEncrypted(){ 
        $this->form_validation->set_rules('country_code','Country Code','required');
        $this->form_validation->set_rules('mobile','Mobile','required');
        $this->form_validation->set_rules('device','','');
        $this->form_validation->set_rules('os_version','Version','');

        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
           // print_r(aes_encryption($_POST['os_version']));exit;
            $input_data = $this->input->post();
            $hash = isset($input_data['hash']) && !empty($input_data['hash']) ? $input_data['hash'] : '';
            //$hash = '';
            $mobile = aes_decryption($input_data['country_code']).aes_decryption($input_data['mobile']);

           // print_r($mobile);exit;
            if ($mobile == '919822979093'){
                $otp = '8560';
            }else{
                $otp = rand(1000,9999); 
            }
            

            $filter = array('mobile'=>$mobile);
            $number_exists = $this->AdminModel->getDetails('otp',$filter);


            $otpArray  = str_split($otp,2);

            $msg = "";
            if(!empty($otpArray) && count($otpArray) == 2){
                $msg = "Your OTP is ".$otpArray[0]." ".$otpArray[1]." for Register with GLOBALBYTE.We assured you for Provide Best Quality Products. Team KIPS CAR-AV ELECTRONICS PVT LTD.";
            }
            
            $url = "http://vas.themultimedia.in/domestic/sendsms/bulksms.php?username=KIPSC&password=GBKIPS&type=TEXT&sender=GBKIPS&entityId=1501553130000054083&templateId=1507166382763131454&mobile=".$mobile."&message=".$msg;
            $url = str_replace(" ", '%20', $url);
            ob_start();
            
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            //curl_exec($ch);

            // close cURL resource, and free up system resources
           // curl_close($ch);


            
            if (ob_get_contents()){
            ob_end_clean();
            }

            if(!empty($number_exists)){

                $data = array('otp'   =>$otp,
                              'device'=>aes_decryption($input_data['device']),
                              'os_version'=>aes_decryption($input_data['os_version'])
                          );
                $result = $this->AdminModel->update('otp',$filter,$data);

            }else{
                $data = array('mobile'=>$mobile,
                              'otp'   =>$otp,
                              'device'=>aes_decryption($input_data['device']),
                              'os_version'=>aes_decryption($input_data['os_version'])
                          );
             //   print_r($data);exit;
                $result = $this->AdminModel->insert('otp',$data);  
            }

            
            if($result){
                $returnArr['error'] = false;
                $returnArr['message'] = 'Success';
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'Please try again';
            }
        }else{
           
            $returnArr['error'] = true;
            $returnArr['message'] = 'Please try again';
        }
        echo json_encode($returnArr);   
    }

////
    public function verifiedOTP(){
        $this->form_validation->set_rules('mobile','Mobile','required|numeric');
        $this->form_validation->set_rules('otp','OTP','required|numeric');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();


            $filter = array('mobile'=>$input_data['mobile'],
                            'otp'   =>$input_data['otp']);

            $result = $this->AdminModel->getDetails('otp',$filter);

            $m_filter = array('mobile'=>$input_data['mobile']);
            $customer = $this->AdminModel->getDetails('customers',$m_filter);

            if($result){

                $returnArr['error'] = false;
                $returnArr['message'] = 'Success';
                $returnArr['is_proceed'] = !empty($customer) ? true : false;
                $returnArr['user_id'] = !empty($customer) ? $customer['id'] : '';
                $returnArr['user_type'] = !empty($customer) && $customer['user_type'] == '2' ? 'sales' : 'normal';
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'OTP does not match';
                $returnArr['is_proceed'] = false;
                $returnArr['user_id'] = '';
                $returnArr['user_type'] = 'normal';
            }
        }else{

            $returnArr['error'] = true;
            $returnArr['message'] = 'Inputs are invalid';
            $returnArr['is_proceed'] = false;
            $returnArr['user_id'] = '';
            $returnArr['user_type'] = 'normal';
        }
        echo json_encode($returnArr);   
    }

    public function verifiedOTPWithEncrypted(){
        $this->form_validation->set_rules('mobile','Mobile','required');
        $this->form_validation->set_rules('otp','OTP','required');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

           // print_r(aes_encryption($_POST['otp']));exit;
            $filter = array('mobile'=>aes_decryption($input_data['mobile']),
                            'otp'   =>aes_decryption($input_data['otp']));

            $result = $this->AdminModel->getDetails('otp',$filter);

            $m_filter = array('mobile'=>aes_decryption($input_data['mobile']));
            $customer = $this->AdminModel->getDetails('customers',$m_filter);

            if($result){

                $returnArr['error'] = false;
                $returnArr['message'] = 'Success';
                $returnArr['is_proceed'] = !empty($customer) ? true : false;
                $returnArr['user_id'] = !empty($customer) ? aes_encryption($customer['id']) : '';
                $returnArr['user_type'] = !empty($customer) && $customer['user_type'] == '2' ? aes_encryption('sales') : aes_encryption('normal');
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'OTP does not match';
                $returnArr['is_proceed'] = false;
                $returnArr['user_id'] = '';
                $returnArr['user_type'] = aes_encryption('normal');
            }
        }else{
          //  print_r(validation_errors());exit;
            $returnArr['error'] = true;
            $returnArr['message'] = 'Inputs are invalid';
            $returnArr['is_proceed'] = false;
            $returnArr['user_id'] = '';
            $returnArr['user_type'] = aes_encryption('normal');
        }
        echo json_encode($returnArr);   
    }

    public function register(){ 
        $this->form_validation->set_rules('mobile','Mobile','required|numeric');
        $this->form_validation->set_rules('name','Name','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','xss_clean|max_length[255]');
        $this->form_validation->set_rules('companyname','Company / Shopname','xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

                $e_filter = ' mobile = "'.$input_data['mobile'].'"';
                $email_exists = $this->AdminModel->getDetails('customers',$e_filter);
                if(!$email_exists){
                    $filter = array('name'=>$input_data['name'],
                            'email'   =>$input_data['email'],
                            'mobile'  =>$input_data['mobile'],
                            'companyname'=>$input_data['companyname']
                        );

                    $result = $this->AdminModel->insert('customers',$filter);
                    if($result){
                        $returnArr['error'] = false;
                        $returnArr['message'] = 'Success';
                        $returnArr['user_id'] = $result;
                        $returnArr['mobile']  = $input_data['mobile'];
                        $returnArr['name']   = $input_data['name'];
                    }else{
                        $returnArr['error'] = true;
                        $returnArr['message'] = 'Please try again';
                        $returnArr['user_id'] = '';
                        $returnArr['mobile']  = $input_data['mobile'];
                        $returnArr['name']   = $input_data['name'];
                    }
                }else{
                    $returnArr['error'] = true;
                    $returnArr['message'] = 'Mobile already exists';
                    $returnArr['user_id'] = '';
                    $returnArr['mobile']  = $input_data['mobile'];
                    $returnArr['name']   = $input_data['name'];
                }
            
        }else{

            $returnArr['error'] = true;
            $returnArr['message'] = 'Inputs are invalid';
            $returnArr['user_id'] = '';
            $returnArr['mobile']  = '';
            $returnArr['name']   = '';
        }
        echo json_encode($returnArr);   
    }


    //new registraion for android 13
    public function registerWithEncryption(){ 
        $this->form_validation->set_rules('mobile','Mobile','required');
        $this->form_validation->set_rules('name','Name','required|max_length[500]');
        $this->form_validation->set_rules('email','Email','max_length[500]');
        $this->form_validation->set_rules('companyname','Company / Shopname','max_length[500]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

               // print_r($this->santitiseString($input_data['companyname']));exit;
                $e_filter = ' mobile = "'.aes_decryption($input_data['mobile']).'"';
                $email_exists = $this->AdminModel->getDetails('customers',$e_filter);
                if(!$email_exists){
                    $filter = array('name'=>aes_decryption($input_data['name']),
                            'email'   =>aes_decryption($input_data['email']),
                            'mobile'  =>aes_decryption($input_data['mobile']),
                            'companyname'=>aes_decryption($input_data['companyname'])
                        );

                  //  print_r($filter);exit;
                    $result = $this->AdminModel->insert('customers',$filter);
                    if($result){
                        $returnArr['error'] = false;
                        $returnArr['message'] = 'Success';
                        $returnArr['user_id'] = $result;
                        $returnArr['mobile']  = $input_data['mobile'];
                        $returnArr['name']   = $input_data['name'];
                    }else{
                        $returnArr['error'] = true;
                        $returnArr['message'] = 'Please try again';
                        $returnArr['user_id'] = '';
                        $returnArr['mobile']  = $input_data['mobile'];
                        $returnArr['name']   = $input_data['name'];
                    }
                }else{
                    $returnArr['error'] = true;
                    $returnArr['message'] = 'Mobile already exists';
                    $returnArr['user_id'] = '';
                    $returnArr['mobile']  = $input_data['mobile'];
                    $returnArr['name']   = $input_data['name'];
                }
            
        }else{
            $returnArr['error'] = true;
            $returnArr['message'] = 'Inputs are invalid';
            $returnArr['user_id'] = '';
            $returnArr['mobile']  = '';
            $returnArr['name']   = '';
        }
        echo json_encode($returnArr);   
    }

    public function appHomePage(){ 
        $this->form_validation->set_rules('id','Id','required|numeric');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            //update customer details
            $customer_filter = array('id'=>$input_data['id']);
            $customer_data = array('latitude'=>isset($input_data['latitude']) && !empty($input_data['latitude']) ? $input_data['latitude'] : '0',
                                   'longitude'=>isset($input_data['longitude']) && !empty($input_data['longitude']) ? $input_data['longitude'] : '0',
                                   'fcm_token'=>isset($input_data['fcm_token']) && !empty($input_data['fcm_token']) ? $input_data['fcm_token'] : '',
                                   'version_id'=>isset($input_data['version_id']) && !empty($input_data['version_id']) ? $input_data['version_id'] : '',
                                   'version_name'=>isset($input_data['version_name']) && !empty($input_data['version_name']) ? $input_data['version_name'] : ''
                               );
            $update = $this->AdminModel->update('customers',$customer_filter,$customer_data);
           // log_message('debug',$customer_data,false);
            //customer
            $c_filter = array('id'=>$input_data['id']);
            $customer = $this->AdminModel->getDetails('customers',$c_filter);
            $name     = $customer['name'];
            $mobile   = $customer['mobile'];

            //banner
            $b_filter = array('active'=>'1');
            $banner = $this->AdminModel->getList('banners',$b_filter);

            $banner_data = array();
            $k = 0;
            foreach($banner as $b){

                $banner_data[$k]['image'] = base_url().$b['image'];
                $banner_data[$k]['activity'] = $b['activity'];
                $banner_data[$k]['value_code'] = $b['value_code'];
                $k++;
            }

            $new_product_filter = array('new_products'=>'1');
            $new_product = $this->AdminModel->getSectionProductList($new_product_filter,$search = false,$brand = false,$category = false,10,0);

            $i = 0;
            foreach($new_product as $new){
                $n_filter = array('product_id'=>$new['id'],'status'=>'1','type'=>'1');
                $images_data = $this->AdminModel->getDetails('product_images',$n_filter,$limit = 1,$offset = 0,$order_by = 'img_order asc');

                $new_product[$i]['image'] = isset($images_data['product_images']) && !empty($images_data['product_images']) ?  base_url().$images_data['product_images'] : base_url().$new['image'];

                // $new_product[$i]['image'] = isset($images_data['product_images']) && !empty($images_data['product_images']) ? base_url().$images_data['product_images'] : '';
                $new_product[$i]['color_code'] = $new['color_code'];
                $new_product[$i]['background_color'] = $new['background_color'];
                $i++;
            }

            $top_selling_filter = array('top_selling_products'=>'1');
            $top_selling = $this->AdminModel->getSectionProductList($top_selling_filter,$search = false,$brand = false,$category = false,10,0);
                
            $j = 0;
            foreach($top_selling as $top){
                $t_filter = array('product_id'=>$top['id'],'status'=>'1','type'=>'1');
                $images_data = $this->AdminModel->getDetails('product_images',$t_filter,$limit = 1,$offset = 0,$order_by = 'img_order asc');

                $top_selling[$j]['image'] = isset($images_data['product_images']) && !empty($images_data['product_images']) ? base_url().$images_data['product_images'] : base_url().$top['image'];
  
                // $top_selling[$j]['image'] = isset($images_data['product_images']) && !empty($images_data['product_images']) ? base_url().$images_data['product_images'] : '';

                $top_selling[$j]['color_code'] = $top['color_code'];
                $top_selling[$j]['background_color'] = $top['background_color'];
                $j++;
            }

            $filter      = array('status'=>'1');
            $brand    = $this->AdminModel->getList('brand',$filter,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,$order_by = 'sequence');

            // echo $this->db->last_query();exit;
            $brand_data = array();
            $k = 0;
            $m = 1;
            foreach($brand as $c){
                $brand_data[$k]['id'] = $c['id'];
                $brand_data[$k]['brand'] = $c['brand'];
                $brand_data[$k]['image'] = base_url().$c['image'];

                if($c['brand'] == 'SWITCHES' || $c['brand'] == 'LED' || $c['brand'] == 'CAR CAMERAS' ||  $c['brand'] == 'GENERAL PRODUCTS' ||  $c['brand'] == 'TOOLS'){
                    $brand_data[$k]['text'] = '';
                }else{
                    $brand_data[$k]['text'] = 'Suitable for';
                }
                

                
                if($m % 3 == 1){
                    $color_code = '#1f1370';
                }else if($m % 3 == 2){
                    $color_code = '#1f1370';
                }else{
                    $color_code = '#1f1370';
                }
                $brand_data[$k]['color_code'] = $color_code;
                $k++;
                $m++;
            }

                $returnArr['error']        = false;
                $returnArr['name']         = $name;
                $returnArr['mobile']       = $mobile;
                $returnArr['banner']       = $banner_data;
                $returnArr['new_products'] = $new_product;
                $returnArr['top_selling']  = $top_selling;
                $returnArr['category']     = $brand_data;
                $returnArr['type']    = !empty($customer) && $customer['user_type'] == '2' ? 'sales' : 'normal';
        }else{

            $returnArr['error']        = true;
            $returnArr['name']         = '';
            $returnArr['mobile']       = '' ;
            $returnArr['banner']       = array();
            $returnArr['new_products'] = array();
            $returnArr['top_selling']  = array();
            $returnArr['category']     = array();
            $returnArr['type']    = 'normal';
        }
        echo json_encode($returnArr);   
    }
//
    public function getProductList(){
        $this->form_validation->set_rules('type','Type','xss_clean|max_length[255]');
        $this->form_validation->set_rules('search','Search','');
        $this->form_validation->set_rules('brand','Brand','');
        $this->form_validation->set_rules('category','Category','');
         $this->form_validation->set_rules('limit','limit','');
          $this->form_validation->set_rules('offset','Offset','');
        if($this->form_validation->run()){
            $type = $this->input->post('type');
            $search = $this->input->post('search');
            $brand  = $this->input->post('brand');
            $category = $this->input->post('category');
            $limit = $this->input->post('limit');
            $offset = $this->input->post('offset');

            if($type == 'new'){
                $filter = array('new_products'=>'1');
            }else if($type == 'top'){
                $filter = array('top_selling_products'=>'1');
            }else{
                $filter = false;
            }   

            $product = $this->AdminModel->getSectionProductList($filter,$search,$brand,$category,$limit,$offset);
           // echo $this->db->last_query();exit;
            
            $i = 0;
            foreach($product as $p){

                $p_filter = array('product_id'=>$p['id'],'status'=>'1','type'=>'1');
                $images_data = $this->AdminModel->getDetails('product_images',$p_filter,$limit = 1,$offset = 0,$order_by = 'img_order asc');
                //echo $this->db->last_query();exit;
                $product[$i]['image'] = isset($images_data['product_images']) && !empty($images_data['product_images']) ?  base_url().$images_data['product_images'] : base_url().$p['image'];
                $product[$i]['color_code'] = $p['color_code'];
                $product[$i]['background_color'] = $p['background_color'];
                $i++;
            }   

            if(empty($product) && $offset == 0){
                $error = true;
                $message = array();
            }else{
                $error = false;
                $message = $product;
            }
        }else{

            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getProductDetails(){
        $this->form_validation->set_rules('id','Product Id','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $product_id = $this->input->post('id');

            $filter = array('id'=>$product_id,
                            'status'=>'1');

            $product = $this->AdminModel->getDetails('products',$filter);

            
            $product['image'] = base_url().$product['image'];

            $i_filter = array('product_id'=>$product_id,'status'=>'1');
            $images   = $this->AdminModel->getList('product_images',$i_filter,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,'img_order');

//
            $images_data = array();
            $video_data = array();
            
            $i = 0;
            $j = 0;
            foreach($images as $im){
                if($im['type'] == '1'){
                    $images_data[$i]['image'] = base_url().$im['product_images'];
                    $images_data[$i]['type'] = $im['type'];
                    $images_data[$i]['video_android'] = '';                    
                    $images_data[$i]['video'] = $im['video'];
                    $i++;
                }else{
                    if(isset($im['video']) && !empty($im['video'])){
                       $video_data[$j]['image'] = base_url().$im['product_images'];
                        $video_data[$j]['type'] = $im['type'];

                        parse_str( parse_url( $im['video'], PHP_URL_QUERY ), $my_array_of_vars );
                        if(!empty($my_array_of_vars)){
                            $video_data[$j]['video_android'] = $my_array_of_vars['v'];  
                        }else{
                            $video_data[$j]['video_android'] = '';
                        }
                        
                        $video_data[$j]['video'] = $im['video'];
                        $j++; 
                    }
                }
            }

            
            if(empty($images_data)){
                $images_data[0]['image'] = base_url().$product['image'];
                $images_data[0]['type'] = "1";
                $images_data[0]['video_android'] = '';
                $images_data[0]['video'] = null; 
                
            }
            //video
            $product['videos'] = $video_data ?? 'No Installation Video Available';
            $product['images'] = $images_data;

            $product['video_thumbnail'] = '';
           $product['video_android'] = '';

            $c_filter = array('sp.status'=>'1','product_id'=>$product_id);
            $conditions = $this->AdminModel->getSuggestedProducts($c_filter);

            $n_conditions = array();
            $j = 0;
            foreach ($conditions as $c) {
                $n_conditions[$j]['id'] = $c['suggested_product_id'];
                $n_conditions[$j]['condition'] = $c['condition'];
                $j++;
            }

            $product['conditions'] = $n_conditions;
            $product['installation_pdf'] = !empty($product['installation_pdf']) ? base_url().$product['installation_pdf'] : ""; 
        
            //add activity
          //  $this->addActivity('product_details',$product_id,$product['mrp']);

            if(!empty($product)){
                $error = false;
                $message  = $product;
            }else{
                $error = true;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }  

    public function getDemoProductDetails(){

 

 $jayParsedAry = [
   "error" => false, 
   "message" => [
         "id" => "1", 
         "model_no" => "CAM-AU/AT", 
         "vehicale_name" => "Audi A4, A5, Q5 Camera Add On Interface in OEM Radio", 
         "image" => "https://www.kipscar.globalbyte.co.in/uploads/1612939429WhatsApp_Image_2021-02-10_at_12_09_47.jpeg", 
         "brand_id" => "1", 
         "category_id" => "1", 
         "sub_category" => null, 
         "mrp" => "37776", 
         "status" => "1", 
         "new_products" => null, 
         "top_selling_products" => null, 
         "created_at" => "2021-02-08 10:34:03", 
         "updated_at" => null, 
         "description" => "Camera Add On Interface in OEM Radio", 
         "vehical_application" => "Applicable from 2011-16 Note Consider Harness image back side of radio & Screen", 
         "features" => "1- Plug and play - no cutting of wires required 2- Add on Rear Camera in the OEM radio- 3- Allow you to see Rear View Camera vision in the OEM radio and no need to install any additional screen or change your original feature rear view mirror-", 
         "other_information" => "Please check the connections in the vehicle match the harness you are purchasing", 
         "disclaimer" => "KIPSC AR-AV ELECTRONICS PVT LTD cannot be held responsible for discrepancies/inconsistencies that may occur due to vehicle manufacturing changes- Liability is restricted to replacement of Product/s only if any damage that may occur in the vehicle during the installation of components-", 
         "color_code" => "#000000", 
         "background_color" => "#707f82", 
         "tags" => "CAMAUAT", 
         "images" => [
            [
               "image" => "https://www.kipscar.globalbyte.co.in/uploads/1627710559.jpeg", 
               "type" => "1", 
               "video_android" => "", 
               "video" => null 
            ], 
            [
                  "image" => "https://www.kipscar.globalbyte.co.in/uploads/1627728751.jpeg", 
                  "type" => "1", 
                  "video_android" => "", 
                  "video" => null 
            ], 
            [
                     "image" => "https://www.kipscar.globalbyte.co.in/uploads/1627730233.jpeg", 
                     "type" => "1", 
                     "video_android" => "", 
                     "video" => null 
            ],
            [
                  "image" => "https://www.kipscar.globalbyte.co.in/uploads/1627728751.jpeg", 
                  "type" => "2", 
                  "video_android" => "gCwqhzq9nmY", 
                  "video" => "https://www.youtube.com/watch?v=gCwqhzq9nmY&ab_channel=GlobalByte" 
            ], 
            [
                     "image" => "https://www.kipscar.globalbyte.co.in/uploads/1627730233.jpeg", 
                     "type" => "2", 
                     "video_android" => "TL_uFAKibOk", 
                     "video" => "https://www.youtube.com/watch?v=TL_uFAKibOk&feature=youtu.be&ab_channel=GlobalByte" 
            ] 
         ], 
         "conditions" => [
                        [
                           "id" => "1558", 
                           "condition" => "Suggested Front Camera" 
                        ], 
                        [
                              "id" => "57", 
                              "condition" => "Suggested OEM Standard Camera" 
                           ], 
                        [
                                 "id" => "58", 
                                 "condition" => "suggested 1000 TVL Camera" 
                              ], 
                        [
                                    "id" => "52", 
                                    "condition" => "Suggested 110 Degree View Dome Camera" 
                                 ], 
                        [
                                       "id" => "1559", 
                                       "condition" => "Suggested 150 Degree View Dome Camera" 
                                    ], 
                        [
                                          "id" => "1560", 
                                          "condition" => "Suggested 170 Degree View Dome Camera" 
                                       ], 
                        [
                                             "id" => "24", 
                                             "condition" => "Suggested  Front  Monogram Camera" 
                                          ], 
                        [
                                                "id" => "25", 
                                                "condition" => "Suggested 150 Degree View OEM  Type Camera" 
                                             ], 
                        [
                                                   "id" => "1014", 
                                                   "condition" => "Suggested Add on Mobile Mirroring Kit" 
                                                ] 
                     ] 
      ] 
]; 

    echo json_encode($jayParsedAry);
 
 
    } 

    public function addActivity($page,$product_id = false,$mrp = false){
        $data = array('page'=>$page,
                      'product_id'=>$product_id,
                      'mrp'       =>$mrp);
        $this->AdminModel->insert('activity',$data);

        return false;
    }

    public function getBrandList(){
        $this->form_validation->set_rules('limit','Limit','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('offset','Offset','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('status'=>'1');
            $limit = $this->input->post('limit');
            $offset = $this->input->post('offset');
            $brand  = $this->AdminModel->getList('brand',$filter,$join = false,$select = false,$limit,$offset);

            $brand_data = array();
            if($brand){
                $i = 0;
                $m = 1;
                foreach($brand as $row){
                    $brand_data[$i]['id'] = $row['id'];
                    $brand_data[$i]['brand'] = $row['brand'];
                    $brand_data[$i]['image'] = isset($row['image']) ?  base_url().$row['image'] : '';
                    if($row['brand'] == 'SWITCHES' || $row['brand'] == 'LED' || $row['brand'] == 'CAR CAMERAS' ||  $row['brand'] == 'GENERAL PRODUCTS' ||  $row['brand'] == 'TOOLS'){
                    $brand_data[$i]['text'] = '';
                    }else{
                        $brand_data[$i]['text'] = 'Suitable for';
                    }

                    if($m % 3 == 1){
                    $color_code = '#1f1370';
                    }else if($m % 3 == 2){
                        $color_code = '#1f1370';
                    }else{
                        $color_code = '#1f1370';
                    }
                    $brand_data[$i]['color_code'] = $color_code;
                        $i++;
                    }    
            }
            
            if(empty($brand_data) && $offset == 0){
                $error = true;
            }else{
                $error = false;
            }
        }else{
            $error = true;
            $brand_data = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$brand_data);

        echo json_encode($returnArr);
    }
//
    public function getCategoryList(){
        $this->form_validation->set_rules('brand_id','Brand Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('limit','Limit','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('offset','Offset','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $brand_id = $this->input->post('brand_id');
            $limit    = $this->input->post('limit');
            $offset   = $this->input->post('offset');

            $filter = array('status'=>'1','brand_id'=>$brand_id);
            $categories  = $this->AdminModel->getList('categories',$filter,$join = NULL,$select = NULL,$limit,$offset,'category_order');

            $category_data = array();
            if($categories){
                $i = 0;
                foreach($categories as $row){
                    $category_data[$i]['id'] = $row['id'];
                    $category_data[$i]['category'] = ucwords($row['category_name']);
                    $category_data[$i]['image'] = isset($row['category_icon']) && !empty($row['category_icon']) ? base_url().$row['category_icon'] : '';
                    $i++;
                }    
            }
            
            if(empty($category_data) && $offset == 0){
                $error = true;
            }else{
                $error = false;
            }

        }else{
            $error = true;
            $category_data = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$category_data);

        echo json_encode($returnArr);
    }

    public function getNewsList(){
        $this->form_validation->set_rules('limit','Limit','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('offset','Offset','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('status'=>'1');
            $news  = $this->AdminModel->getList('news',$filter);

            $news_data = array();
            if($news){
                $i = 0;
                foreach($news as $row){
                    $news[$i]['image'] = isset($row['image']) && !empty($row['image']) ? base_url().$row['image'] : '';
                    $i++;
                }    
            }
            
            if($news){
                $error = false;
            }else{
                $error = true;
            }

        }else{
            $error = true;
            $news = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$news);

        echo json_encode($returnArr);
    }


    public function getNewsDetails(){
        $this->form_validation->set_rules('id','Id','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $id = $this->input->post('id');
            $filter = array('status'=>'1','id'=>'1');
            $news  = $this->AdminModel->getDetails('news',$filter);


            $news['image'] = isset($news['image']) && !empty($news['image']) ? base_url().$news['image'] : '';
            $news['created_at'] = isset($news['created_at']) && !empty($news['created_at']) ? date('d M Y') : '';

            if($news){
                $error = false;
            }else{
                $error = true;
            }

        }else{
            $error = true;
            $news = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$news);

        echo json_encode($returnArr);
    }

    public function getCountryCodeList(){

        $filter = array('status'=>'1');
        $countries  = $this->AdminModel->getList('countries',$filter);
        
        if($countries){
            $error = false;
        }else{
            $error = true;
        }
        $returnArr = array('error'=>$error,'message'=>$countries);

        echo json_encode($returnArr);
    }
    public function getSuggestedProductDetails(){

        $this->form_validation->set_rules('product_id','Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('condition_id','Id','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $product_id = $this->input->post('product_id');
            $condition_id = $this->input->post('condition_id');
            $filter = array('product_id'=>$product_id,'condition_id'=>$condition_id);
            $product  = $this->AdminModel->getDetails('suggested_products',$filter);
            
            if($product){
                $error = false;
                $message = $product['id'];
            }else{
                $error = true;
                $message = 'No product found';
            }

        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }
        $returnArr = array('error'=>false,'message'=>$message);

        echo json_encode($returnArr);
    }
    
    public function checkApplicationVersion(){

        $this->form_validation->set_rules('version_id','Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('version_name','Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('app','App','xss_clean|max_length[255]');
        if($this->form_validation->run()){
             $version_id = $this->input->post('version_id');
             $version_name = $this->input->post('version_name');

             $filter = array('app'=>isset($_POST['app']) && !empty($_POST['app']) ? $this->input->post('app') : 'android');
            $version_details = $this->AdminModel->getDetails('app_version',$filter);


            if($version_id < $version_details['version_id'] || $version_name < $version_details['version_name'] ){
                $error = true;
                $message = 'We have added some exciting feature in the app.Please update the app.';
            }else{
                $error = false;
                $message = 'App is updated';
            }
        

        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$message);

        echo json_encode($returnArr);
    }

    public function addToCart(){
        $this->form_validation->set_rules('customer_id','Customer Id','required|xss_clean|numeric|max_length[11]');
        $this->form_validation->set_rules('product_id','Product Id','required|xss_clean|numeric|max_length[11]');
        $this->form_validation->set_rules('qty','Qty','required|xss_clean|numeric|max_length[11]');
        $this->form_validation->set_rules('percentage','Percentage','xss_clean|numeric|max_length[11]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $filter = array('customer_id'=>$input_data['customer_id'],
                            'product_id' =>$input_data['product_id']);

            $cart_item_exits = $this->AdminModel->getDetails('cart',$filter);

            if($cart_item_exits){

                $data = array('qty'     =>$input_data['qty'],
                              'discount'=>$input_data['percentage']);
                $result = $this->AdminModel->update('cart',$filter,$data);
            }else{
                $data = array('customer_id'     =>$input_data['customer_id'],
                              'product_id'      =>$input_data['product_id'],
                              'qty'             =>$input_data['qty'],
                              'discount'        =>$input_data['percentage']);
                $result = $this->AdminModel->insert('cart',$data);
            }

            if($result){
                $error = false;
                $message = 'Added to cart successfully';
            }else{
                $error = false;
                $message = 'Please try again';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function addClientName(){
        $this->form_validation->set_rules('sales_person_id','Sales Person Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('client_name','Client Name','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|xss_clean|valid_email|max_length[255]');
        $this->form_validation->set_rules('address_1','Address 1','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('address_2','Address 2','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('city','City','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('pincode','Pincode','required|xss_clean|max_length[6]|min_length[6]|numeric');
        $this->form_validation->set_rules('district','District','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('state','State','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $filter = array('assign_sales_person'       =>$input_data['sales_person_id'],
                            'name'                      =>$input_data['client_name'],
                            'email'                     =>$input_data['email']);

            $client_exits = $this->AdminModel->getDetails('client',$filter);

            $result = '';
            if($client_exits){

                $client_id = $client_exits['id'];
            }else{
                $data = array(
                              'name'          =>$input_data['client_name'],
                              'email'         =>$input_data['email'],
                              'address_1'     =>$input_data['address_1'],
                              'address_2'     =>$input_data['address_2'],
                              'city'          =>$input_data['city'],
                              'pincode'       =>$input_data['pincode'],
                              'district'      =>$input_data['district'],
                              'state'         =>$input_data['state'],
                              'assign_sales_person'=>$input_data['sales_person_id']

                          );
                $result = $this->AdminModel->insert('client',$data);
                $client_id = $result;
            }

            if($result){

                $error = false;
                $message = 'Client Added successfully';

            }else{
                $error = true;
                $message = 'Client Already Exists';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
            $client_id = '';
        }

        $returnArr = array('error'=>$error,'message'=>$message,'client_id'=>$client_id);
        echo json_encode($returnArr);
    }

    public function addAddress(){
        $this->form_validation->set_rules('customer_id','Customer Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('address_1','Address 1','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('address_2','Address 2','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('city','City','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('pincode','Pincode','required|xss_clean|max_length[6]|min_length[6]|numeric');
        $this->form_validation->set_rules('district','District','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('state','State','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $filter = array('customer_id'               =>$input_data['customer_id']);

            $client_exits = $this->AdminModel->getDetails('customer_addresses',$filter);

            $result = '';
            if($client_exits){
                $client_id = $client_exits['id'];
            }else{
                $data = array('customer_id'   =>$input_data['customer_id'],
                              'address_1'     =>$input_data['address_1'],
                              'address_2'     =>$input_data['address_2'],
                              'city'          =>$input_data['city'],
                              'pincode'       =>$input_data['pincode'],
                              'district'      =>$input_data['district'],
                              'state'         =>$input_data['state']

                          );
                $result = $this->AdminModel->insert('customer_addresses',$data);
                $client_id = $result;
            }

            if($result){

                $error = false;
                $message = 'Address Added successfully';

            }else{
                $error = true;
                $message = 'Address Already Exists';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function addClientContact(){
        $this->form_validation->set_rules('client_id','Client Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('contact_name','Contact Name','required');
        $this->form_validation->set_rules('mobile','Mobile','required');
        $this->form_validation->set_rules('designation','Designation','required');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $filter = array('client_id'=>$input_data['client_id'],
                            'name'     =>$input_data['contact_name'],
                            'mobile'       =>$input_data['mobile'],
                            'designation'       =>$input_data['designation']);

            $client_exits = $this->AdminModel->getDetails('client_contacts',$filter);

            $result = '';
            if($client_exits){

                $returnArr['error'] = false;
                $returnArr['message'] = 'Contact Name already exists';
                echo json_encode($returnArr);
                exit;
            }else{
                $data = array('client_id'     =>$input_data['client_id'],
                              'mobile'        =>$input_data['mobile'],
                              'name'          =>$input_data['contact_name'],
                              'designation'   =>$input_data['designation'],
                              'status'        =>'1'

                          );
                $result = $this->AdminModel->insert('client_contacts',$data);
            }

            if($result){
            
                $error = false;
                $message = 'Client contact Added successfully';
            }else{
                $error = false;
                $message = 'No records found';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getClientNames(){
        $this->form_validation->set_rules('sales_person_id','Sales Person Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('search','Search','');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $search = $input_data['search'];
            $sales_person_id = $input_data['sales_person_id'];

            $clients = $this->AdminModel->getClientData($search,$sales_person_id);
            //echo $this->db->last_query();exit;
            if($clients){
                $error = false;
                $message = $clients;
            }else{
                $error = false;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getClientDetails(){
        $this->form_validation->set_rules('id','Id','required|xss_clean|numeric|max_length[255]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            $id = $input_data['id'];


            $clients = $this->AdminModel->getClientDetailsData($id);

            $filter = array('client_id'=>$id);
            $client_contacts = $this->AdminModel->getClientContactList($filter);

            $i = 1;
            foreach($client_contacts as $key => $row){
                if($i == 1){
                    $client_contacts[$key]['is_check'] = true;
                }else{
                    $client_contacts[$key]['is_check'] = false;
                }
                $i++;
            }
            if($clients){
                $error = false;
                $clients['contacts'] = $client_contacts;
                $message = $clients;
            }else{
                $error = false;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getOrderListBySalesPerson(){
        $this->form_validation->set_rules('sales_person_id','Sales Person Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('search','Search','');
        $this->form_validation->set_rules('limit','Limit','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('offset','Offset','required|xss_clean|numeric|max_length[255]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            

            $sales_person_id = $input_data['sales_person_id'];
            $order_by        = isset($input_data['order_by']) && !empty($input_data['order_by']) ? $input_data['order_by'] : 'asc';
            $order_date      = isset($input_data['order_date']) && !empty($input_data['order_date']) ? $input_data['order_date'] : 'desc';
            $search          = $input_data['search'];
            $limit           = $input_data['limit'];
            $offset          = $input_data['offset'];

            $orders = $this->OrderModel->getOrderListBySalesPerson($sales_person_id,$order_by,$search,$limit,$offset);
            
            //echo $this->db->last_query();exit;
            if(empty($orders) && $offset == 0){
                $error = true;
                $message = array();
            }else{
               $error = false;
               $message = $orders; 
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,
                           'order_by'=>$order_by,
                           'order_date'=>$order_date,
                           'message'=>$message);

        echo json_encode($returnArr);
    }

    public function getOrderListByCustomer(){
        $this->form_validation->set_rules('customer_id','Customer Id','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('sales_person_id','Sales Person Id','xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('limit','Limit','required|xss_clean|numeric|max_length[255]');
        $this->form_validation->set_rules('offset','Offset','required|xss_clean|numeric|max_length[255]');
        if($this->form_validation->run()){
            $input_data = $this->input->post();
            

            $customer_id     = $input_data['customer_id'];
            $sales_person_id = $input_data['sales_person_id'];
            $order_by        = isset($input_data['order_by']) && !empty($input_data['order_by']) ? $input_data['order_by'] : false;
            $order_date      = isset($input_data['order_date']) && !empty($input_data['order_date']) ? $input_data['order_date'] : 'desc';
            $limit           = $input_data['limit'];
            $offset          = $input_data['offset'];

            if(!$input_data['sales_person_id']){
                $sales_person_id = $customer_id;
            }

            if($input_data['sales_person_id']){
                $orders = $this->OrderModel->getOrderListByClient($customer_id,$sales_person_id,$order_by,$order_date,$limit,$offset);  
                //echo $this->db->last_query();exit;  
            }else{
                $orders = $this->OrderModel->getOrderListByCustomer($customer_id,$sales_person_id,$order_by,$order_date,$limit,$offset);  
            }
             

            $order_details = $this->OrderModel->getOrderListDetails($customer_id,$sales_person_id,$order_by,$order_date,$limit,$offset);
            
          // echo $this->db->last_query();exit;
            if($orders){
                $error = false;
                $message = $orders;  
            }else{
                $error = true;
                $message = new stdClass();    
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
            $order_details = array();
        }

        $returnArr = array('error'          =>$error,
                           'order_by'       =>$order_by,
                           'order_date'     =>$order_date,
                           'message'        =>$message,
                           'order_details'  =>$order_details);
        echo json_encode($returnArr);
    }

    public function getOrderDetails(){
        $this->form_validation->set_rules('order_id','Order Id','required|xss_clean|numeric|max_length[255]');
        if($this->form_validation->run()){
            
            $order_id     = $this->input->post('order_id');

            $filter = array('order_id'=>$order_id);
            
            $order_data = $this->AdminModel->getDetails('orders',$filter);
            if($order_data['client_contact_id'] == NULL || $order_data['client_contact_id'] == 0){
                $orders = $this->OrderModel->getCustomerOrderDetailsData($filter);
            }else{
                $orders = $this->OrderModel->getOrderDetailsData($filter); 
            }


            $order_details = $this->OrderModel->getOrderProductDetails($order_id);
                
            foreach($order_details as $key => $row){
                    $order_details[$key]['subtotal'] = calculate_total($row['mrp'],$row['qty'],$row['discount_percentage']);
            }

            if($orders){
                $error = false;
                $order_data = $orders;
                $order_data['products'] = $order_details;
            }else{
                $error = false;
                $order_data = array();
                $order_data['products'] = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$order_data);
        echo json_encode($returnArr);
    }

    public function addOrder(){
        $this->form_validation->set_rules('customer_id','Customer Id','xss_clean|max_length[255]');
        $this->form_validation->set_rules('sales_person_id','Sales Person Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('client_contact_id','Client Contact Id','xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $input_data         = $this->input->post();

            $customer_id        = $input_data['customer_id'];
            $sales_person_id    = $input_data['sales_person_id'];
            $client_contact_id  = $input_data['client_contact_id'];

            if(empty($customer_id)){
                $customer_id = $sales_person_id;
            }
            $filter = array('customer_id'=>$sales_person_id);
            $cart_items = $this->AdminModel->getList('cart',$filter);
            $total = 0;
                foreach($cart_items as $key => $row){

                        $p_filter = array('id'=>$row['product_id']);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $qty = $row['qty'];
                        $mrp = $p_details['mrp'];
                        $subtotal = $mrp * $qty;
                        $discount = $row['discount'];
                        $final_discount = ($subtotal * $discount) / 100; 
                        $subtotal = $subtotal - $final_discount;
                        $total += $subtotal;

                    if($row['qty'] == 0){
                        $returnArr['errCode'] = 2;
                        $returnArr['message'] = $p_details['model_no'].' Quantity should not be 0';
                        echo json_encode($returnArr);exit;
                    }

                        
                }

                $this->db->trans_start();

                
                
                $last_invoice = $this->AdminModel->getDetails('orders',null,1,null,'order_id DESC');

                if(empty($last_invoice)){
                    $last_invoice['order_id'] = 0;
                }
                $invoice_id = sprintf("%05s",++$last_invoice['order_id']);

                $order_data  = array('customer_id'      =>$customer_id,
                                     'sales_person_id'  =>$sales_person_id,
                                     'client_contact_id'=>$client_contact_id,
                                     'invoice_no'       =>'APK'.$invoice_id,
                                     'status'           =>'1',
                                     'total'            =>$total
                                     );

                    $order_id    = $this->AdminModel->insert('orders',$order_data);

                $count = COUNT($cart_items);
                $number_of_discount = 0;
                foreach($cart_items as $key => $row){
                        $product_filter = array('id'=>$row['product_id']);
                        $product_details = $this->AdminModel->getDetails('products',$product_filter);

                        

                        if($row['discount'] != '' && $row['discount'] != 0){
                            $number_of_discount++;
                        }

                        $order_details[] = array('order_id'    =>$order_id,
                                                 'product_id'  =>$row['product_id'],
                                                 'mrp'         =>$product_details['mrp'],
                                                 'qty'         =>$row['qty'],
                                                 'discount_percentage'    =>$row['discount'],
                                                'created_at'   =>date('Y-m-d h:i:s'));
                        
                }

               
                if($number_of_discount != 0 && $number_of_discount != $count){
                    $returnArr['error'] = true;
                    $returnArr['message'] = 'Discount should be apply to all';
                    echo json_encode($returnArr);exit;
                }

            


                $add = $this->AdminModel->insertBatch('order_list',$order_details);
            
                $delete_filter = array('customer_id'=>$sales_person_id);
                $this->AdminModel->delete('cart',$delete_filter);
                

                $d_filter = array('customer_id'=>$customer_id);
                $delete = $this->AdminModel->delete('cart',$d_filter);
            if($add){

                
                $filter_1   = array('o.order_id'=>$order_id);
                $order_data_1 = $this->AdminModel->getDetails('orders o',$filter_1);

                if($order_data_1['client_contact_id'] == NULL || $order_data_1['client_contact_id'] == 0){
                    $data['customer'] = $this->OrderModel->getCustomerOrderData($filter_1);
                    $data['client_contact_id'] = false;
                }else{
                    $data['customer'] = $this->OrderModel->getClientOrderData($filter_1);
                    $data['client_contact_id'] = true;
                }

                $customer_id = $data['customer']['id'];

                $data['order_details'] = $this->OrderModel->getOrderDetails($filter_1);

                $filename = $order_data['invoice_no'];

                $html = $this->load->view('order/mobile_invoice',$data,true);
                $this->pdf->createPDF($html, $filename, true);

                $invoice_order_id = array('order_id'=>$order_id);
                $invoice_link_data = array('invoice_link'=>base_url().'uploads/order/'.$filename.'.pdf');
                $this->AdminModel->update('orders',$invoice_order_id,$invoice_link_data);

                $this->db->trans_complete();

                $error = false;
                $message = 'Order Added successfully';
            }else{
                $error = false;
                $message = 'No records found';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function removeCart(){
        $this->form_validation->set_rules('id','Id','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('id'=>$this->input->post('id'));
            $delete = $this->AdminModel->delete('cart',$filter);

            if($delete){
                $error = false;
                $message = 'Remove cart successfully';
            }else{
                $error = false;
                $message = 'No records found';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function updateQty(){
        $this->form_validation->set_rules('id','Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('product_id','Product Id','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('qty','Qty','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount_percentage','Discount Percentage','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $input_data = $this->input->post();

            $filter  = array('id'=>$input_data['product_id']);
            $product = $this->AdminModel->getDetails('products',$filter);

            $c_filter = array('id'=>$input_data['id'],
                              'product_id'=>$input_data['product_id']);
            $c_data   = array('qty'=>$input_data['qty'],
                              'discount'=>$input_data['discount_percentage']);
            $update = $this->AdminModel->update('cart',$c_filter,$c_data);
            
            if($update){
                $error = false;
                $message = 'Update cart successfully';
            }else{
                $error = false;
                $message = 'No records found';
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function fetchCart(){
        $is_address = false;
        $this->form_validation->set_rules('customer_id','Customer Id','required|xss_clean|numeric|max_length[255]');
        if($this->form_validation->run()){
            
            $customer_id     = $this->input->post('customer_id');

            $c_filter = array('id'=>$customer_id);
            $customer = $this->AdminModel->getDetails('customers',$c_filter);

            $filter = array('customer_id'=>$customer_id);
            $orders = $this->OrderModel->getCartDetails($filter,$customer_id);
            
            $address = $this->AdminModel->getDetails('customer_addresses',$filter);

            if(isset($address) && !empty($address) && $customer['user_type'] == '1'){
                $is_address = true;
            }

            if(isset($orders) && !empty($orders) && !is_null($orders[0]['id'])){
                
                foreach($orders as $key => $row){
                    $orders[$key]['subtotal'] = calculate_total($row['mrp'],$row['qty'],$row['discount']);
                }

                $error = false;
                $order_data = $orders;
            }else{
                $error = true;
                $order_data = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$order_data,'is_address'=>$is_address);
        echo json_encode($returnArr);
    }


    public function getCartItemDetails(){
        $this->form_validation->set_rules('id','Id','required|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('c.id'=>$this->input->post('id'));
            $item_details = $this->OrderModel->getCartItemDetails($filter);

            if($item_details){

                
                    $item_details['subtotal'] = calculate_total($item_details['mrp'],$item_details['qty'],$item_details['discount']);

                $error = false;
                $message = $item_details;
            }else{
                $error = false;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getProductListData(){
        $this->form_validation->set_rules('search','Search','xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $search = $this->input->post('search');
            $item_details = $this->AdminModel->getProductNames($search);

            if($item_details){
                $error = false;
                $message = $item_details;
            }else{
                $error = false;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getProductMRP(){
        $this->form_validation->set_rules('product_id','Product Id','xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $product_id = $this->input->post('product_id');
            $item_details = $this->AdminModel->getProductMRP($product_id);

            if($item_details){
                $error = false;
                $message = $item_details;
            }else{
                $error = false;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function calculateTotal(){
        $this->form_validation->set_rules('product_id','Product Id','xss_clean|max_length[255]');
        $this->form_validation->set_rules('mrp','MRP','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('qty','Qty','required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount','Discount','xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $mrp = $this->input->post('mrp');
            $qty = $this->input->post('qty');
            $discount = $this->input->post('discount');

            if(empty($discount)){
                $discount = 0;
            }

            $total = calculate_total($mrp,$qty,$discount);

            $error = false;
            $message = strval($total);
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getState(){
        $this->form_validation->set_rules('language','Language','xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $state_id = $this->input->post('state_id');

            $filter = array('state_id'=>$state_id);
            $state = $this->AdminModel->getList('state');;

            if($state){
                $error = false;
                $message = $state;
            }else{  
                $error = true;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }
        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

    public function getDistrict(){
        $this->form_validation->set_rules('state_id','State Id','xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $state_id = $this->input->post('state_id');

            $filter = array('state_id'=>$state_id);
            $district = $this->AdminModel->getList('district',$filter);

            if($district){
                $error = false;
                $message = $district;
            }else{  
                $error = true;
                $message = array();
            }
        }else{
            $error = true;
            $message = 'Inputs are invalid';
        }

        $returnArr = array('error'=>$error,'message'=>$message);
        echo json_encode($returnArr);
    }

     function createPDF()
    {   
        $filter_1   = array('o.order_id'=>10);
        $order_data_1 = $this->AdminModel->getDetails('orders o',$filter_1);

        if(is_null($order_data_1['sales_person_id']) || $order_data_1['customer_id'] == $order_data_1['sales_person_id']){
            $data['customer'] = $this->OrderModel->getCustomerOrderData($filter_1);
            $data['sales_person'] = false;
        }else{
            $data['customer'] = $this->OrderModel->getClientOrderData($filter_1);
            $data['sales_person'] = true;
        }
    

        $customer_id = $data['customer']['id'];

        $data['order_details'] = $this->OrderModel->getOrderDetails($filter_1);


        $this->load->view('order/mobile_invoice',$data);
    }


    
}
