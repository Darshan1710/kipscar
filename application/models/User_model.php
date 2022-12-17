<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class User_model extends CI_Model{

	public function construct(){
		parent::__construct();
	}

	
	public function getUserRoleList(){
		return $this->db->get('user_role')->result_array();
	}
	public function getUserRoleDetails($filter){
		$this->db->where($filter);
		return $this->db->get('user_role')->row_array();
	}
	public function addUserRole($data){
		return $this->db->insert('user_role',$data);
	}
	public function updateUserRole($filter,$data){
		$this->db->where($filter);
		return $this->db->update('user_role',$data);
	}
	public function getUserList(){
		$this->db->select('u.*,ur.role');
		$this->db->join('user_role ur','ur.id = u.role_id');
		return $this->db->get('user u')->result_array();
	}
	public function getUserDetails($filter){
		$this->db->where($filter);
		$this->db->select('u.*,u.status as user_status,ur.role');
		$this->db->join('user_role ur','ur.id = u.role_id');
		return $this->db->get('user u')->row_array();
	}
	public function addUser($data){
		return $this->db->insert('user',$data);
	}
	public function updateUser($filter,$data){
		$this->db->where($filter);
		return $this->db->update('user',$data);
	}
	 //get Customer details 
    public function getUserListRows($postData){
        $this->_get_user_list_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllUserList(){
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    public function countFilteredUserList($postData){
        $this->_get_user_list_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_user_list_datatables_query($postData){

        $this->db->select('u.*,role');
        $this->db->join('user_role ur','ur.id = u.role_id');
        $this->db->from('user u');
        // Set orderable column fields
        $this->column_order = array(null,'name','mobile','email','username','role','u.created_at','u.status');

        // Set searchable column fields
        $this->column_search = array('name','mobile','email','username','role','u.created_at','u.status');
        // Set default order
        $this->order = array('u.created_at' => 'desc');  



        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){
                            $this->db->or_like($value['name'],$value['search']['value']);
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                        $this->db->or_like($item, $postData['search']['value']);  
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	

    //menu
    public function getMenuList(){
    	return $this->db->get('menu')->result_array();
    }
    public function getMenuDetails($filter){
    	$this->db->where($filter);
    	return $this->db->get('menu')->row_array();
    }
    public function addMenu($data){
    	return $this->db->insert('menu',$data);
    }
    public function updateMenu($filter,$data){
    	$this->db->where($filter);
    	return $this->db->update('menu',$data);
    }

    //menu
    public function getSubmenuList(){
    	$this->db->select('sm.*,menu');
    	$this->db->join('menu m','m.id = sm.menu_id');
    	return $this->db->get('submenu sm')->result_array();
    }
    public function getSubmenuDetails($filter){
    	$this->db->where($filter);
    	return $this->db->get('submenu')->row_array();
    }
    public function addSubmenu($data){
    	return $this->db->insert('submenu',$data);
    }
    public function updateSubmenu($filter,$data){
    	$this->db->where($filter);
    	return $this->db->update('submenu',$data);
    }
    public function getSubmenuListData($ids){
        $this->db->where_in('menu_id',$ids);        
        $this->db->select('sm.*,menu');
        $this->db->join('menu m','m.id = sm.menu_id');
        return $this->db->get('submenu sm')->result_array();
    }
    public function updatePermission($filter,$data){
        $this->db->where($filter);
        return $this->db->update('user',$data);
    }

}


?>