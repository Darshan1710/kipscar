<?php 
if(!defined('BASEPATH')) exit ('No direct script access allowed');



if(!function_exists('sendEmail_helper')){
	function sendEmail_helper($to,$from,$subject,$message){

	    $ci =& get_instance();
        $ci->email->set_newline("\r\n");
        $ci->email->from($from); // change it to yours
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($message);
        if ($ci->email->send()) {
            return true;
        } else {
            return false;
        }
	}
}

if(!function_exists('calculate_total')){
    function calculate_total($mrp,$qty,$discount){


        $subtotal = $mrp * $qty;
        $final_discount = ($subtotal * $discount) / 100; 
        $final_subtotal = $subtotal - $final_discount;
        $final_discount_1 = strval(number_format($final_subtotal,2)); 
        return $final_discount_1;
    }
}

if(!function_exists('getRandomString')){
    function getRandomString() { 
        $characters = '0123456789'; 
        $randomString = ''; 
      
        for ($i = 0; $i < 10; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    }
}



if(!function_exists('sendSMS')){
    function sendSMS($mobile,$msg){
        $username = urlencode("u_alphacore"); 
        $msg_token = urlencode("EEYN6t"); 
        $sender_id = urlencode("612324"); // optional (compulsory in transactional sms) 
        $message = urlencode($msg); 
        $mobile = urlencode($mobile); 

        $api = "http://la-suit.vispl.in/api/send_promotional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

        $response = file_get_contents($api);


        $json = json_decode($response, TRUE);

        if($json['status'] == 'success'){
            return true;
        }else{
            return false;
        }
    }

}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if(!function_exists('upload_image')){
    function upload_image($files,$name){

        $_FILES = $files;


        $ci =& get_instance();

        $config1['upload_path']   = 'uploads/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg|gif|svg|pdf';
        $config1['max_size']      = '*';
        $config1['max_width']     = '*';
        $config1['max_height']    = '*';
        $config1['file_name']     = time().$_FILES[$name]['name'];
        $ci->load->library('upload', $config1);
        $ci->upload->initialize($config1);
        if (!$ci->upload->do_upload($name)){
            $error = $ci->upload->display_errors();
            $data['errCode'] = 2;
            $data['image']   = $error;
            return $data;
        }else {


            $upload_data = $ci->upload->data();

            // $config2['image_library']   = 'gd2';
            // $config2['source_image']    = $upload_data['full_path'];
            // $config2['create_thumb']    = TRUE;
            // $config2['maintain_ratio']  = TRUE;
            // $config2['width']           = 200;
            // $config2['height']          = 200;

            // $ci->image_lib->clear();
            // $ci->image_lib->initialize($config2);
            // if($ci->image_lib->resize()){

                $path_parts = pathinfo($upload_data['file_name']);

                $image_path =  'uploads/'.$path_parts['filename'].'.'.$path_parts['extension'];
                $data['errCode'] = -1;
                $data['image']   = $image_path;
                return $data;
            // }else{
            //      $errors =  $this->image_lib->display_errors();

            //      $data['errCode'] = 2;
            //      $data['image']   = $errors;
            //      return $data;
            // }


        }
    }
}

if(!function_exists('upload_product_image')){
    function upload_product_image($files,$name){

        $_FILES = $files;


        $ci =& get_instance();

        $config1['upload_path']   = 'uploads/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg|gif|svg';
        $config1['max_size']      = '*';
        $config1['max_width']     = '*';
        $config1['max_height']    = '*';
        $config1['file_name']     = time().$_FILES[$name]['name'];
        $ci->load->library('upload', $config1);
        $ci->upload->initialize($config1);
        if (!$ci->upload->do_upload($name)){
            $error = $ci->upload->display_errors();
            $data['errCode'] = 2;
            $data['image']   = $error;
            return $data;
        }else {


            $upload_data = $ci->upload->data();


            $config['source_image'] = $upload_data['full_path'];
            //The image path,which you would like to watermarking
            $config['image_library'] = 'gd2';
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = './uploads/1.png';     //the overlay image
            $config['wm_opacity'] = 50;
            $config['wm_vrt_alignment'] = 'middle';
            $config['wm_hor_alignment'] = 'center';
            $ci->image_lib->initialize($config);
            if (!$ci->image_lib->watermark()) {
                return $ci->image_lib->display_errors();
            }
            
            
            if($ci->image_lib->watermark()){
                $path_parts = pathinfo($upload_data['file_name']);
                $image_path =  'uploads/'.$path_parts['filename'].'.'.$path_parts['extension'];
                $data['errCode'] = -1;
                $data['image']   = $image_path;
                $data['path'] = base_url().$image_path;
                return $data;
            }else{
                 $errors =  $ci->image_lib->display_errors();
                 
                 $data['errCode'] = 2;
                 $data['image']   = $errors;
                 return $data;
            }


        }
    }
}

if (!function_exists('display_gallery_image')) {
    
    function display_gallery_image($photo_name) {

        $url = base_url();
        $filename = $url.$photo_name;
        $defult_filename = $url."uploads/No_Image_Available.jpg";
        if ((!empty($photo_name)) && (file_exists("./$photo_name"))) {
            $filename = $url.$photo_name;
            echo '<span><img class="img-rounded" src="' . $filename . '" height="120" width="160"></span>';
        } else {            
             echo '<span><img class="img-rounded" src="' . $defult_filename. '" height="120" width="160"></span>';
        }        

    }
    
}

if(!function_exists('aes_encryption')){
    function aes_encryption($plainText){
        $iv = '1234567891011121';

        // Encrypt the data
        $cipherText = openssl_encrypt($plainText, 'aes-256-cbc', '7W9JdoGEuWiV5EFdQxdyE+PYnj7Wnkfe', OPENSSL_RAW_DATA, $iv);
        
        // Encode the encrypted data as base64
        return base64_encode($cipherText);
        
    }
}

if(!function_exists('aes_decryption')){
    function aes_decryption($encryptedData){
        $encryptedData = base64_decode($encryptedData);

        // Extract the initialization vector and encrypted data
        $iv = '1234567891011121';

        // Decrypt the data
        return openssl_decrypt($encryptedData, 'aes-256-cbc', '7W9JdoGEuWiV5EFdQxdyE+PYnj7Wnkfe', OPENSSL_RAW_DATA, $iv);
        
    }
}


?>
