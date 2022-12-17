<?php 
if(!defined('BASEPATH')) exit ('No direct script access allowed');

if(!function_exists('user_permission')){
	function user_permission($user_id){
		$ci =& get_instance(); 

		$filter = array('user_id'=>$user_id);
		$user_permission = $this->
	}
}
?>