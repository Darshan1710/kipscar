<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
    //user role
    public function getUserRoleList(){
        $filter = array('status'=>'1');
        $data['users_roles']  = $this->User_model->getUserRoleList($filter);

        $this->load->view('user/userRoleList',$data);
    }
    public function addUserRole(){ 
        $this->form_validation->set_rules('user_role','User Role','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();



            $data = array(  'role'          => $input_data['user_role'],
                            'status'        => $input_data['status'],
                            'created_by'    => $this->session->userdata('user_id')    
                            );

            $result = $this->User_model->insert($data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Added Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function editUserRole(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->User_model->getUserRoleDetails($filter);

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
    public function updateUserRole(){ 
        $this->form_validation->set_rules('user_role','User Role','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            $filter = array('id'=>$input_data['id']);
            $data = array(  'role'              => $input_data['user_role'],
                            'status'           => $input_data['status'],
                            'updated_by'       => $this->session->userdata('user_id')
                            );
            
            $result = $this->User_model->update('admin',$filter,$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Updated Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }

    //user
    public function userList(){
        $r_filter = array('status'=>'1');
        $data['user'] = $this->AdminModel->getList('admin',$r_filter);

        $this->load->view('userList',$data);
    }

    public function addUser(){ 
        $this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|numeric|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('username','Username','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('password','Password','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean|matches[password]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            $data = array(  'first_name'    => $input_data['first_name'],
                            'last_name'    => $input_data['last_name'],
                            'mobile'        => $input_data['mobile'],
                            'email'         => $input_data['email'],
                            'username'      => $input_data['username'],
                            'password'      => md5($input_data['password']),
                            'status'        => $input_data['status'] 
                            );

            $result = $this->AdminModel->insert('admin',$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Added Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function editUser(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->AdminModel->getDetails('admin',$filter);

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
    public function updateUser(){ 
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|numeric|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('username','Username','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            $filter = array('id'=>$input_data['id']);
             $data = array( 'first_name'    => $input_data['first_name'],
                            'last_name'    => $input_data['last_name'],
                            'mobile'        => $input_data['mobile'],
                            'email'         => $input_data['email'],
                            'username'      => $input_data['username'],
                            'status'        => $input_data['status'] 
                            );
            
            $result = $this->AdminModel->update('admin',$filter,$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Updated Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }

    //menu
    public function menuList(){
        $data['menu'] = $this->User_model->getMenuList();
        $this->load->view('menu/menuList',$data);
    }
    public function addMenu(){
        $this->form_validation->set_rules('menu','Menu','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $data = array('menu'=>$this->input->post('menu'));

            $checkMenu = $this->User_model->getMenuDetails($data);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['menu']      = '<p class="error">Menu Already Exists</p>';
            }else{
                    $addMenu = $this->User_model->addMenu($data);

                    if($addMenu){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Menu Added Successfully';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function editMenu(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]|numeric');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $menu = $this->User_model->getMenuDetails($filter);
            if($menu){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $menu;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function updateMenu(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]}numeric');
        $this->form_validation->set_rules('menu','Menu','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'));
            $data = array('menu'=>$this->input->post('menu'));

            $checkMenu = $this->User_model->getMenuDetails($data);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['menu']      = '<p class="error">Menu Already Exists</p>';
            }else{
                $filter     = array('id'=>$this->input->post('id'));
                $updateMenu = $this->User_model->updateMenu($filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Menu Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }
            
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    //submenu
    //menu
    public function submenuList(){
        $data['menu'] = $this->User_model->getMenuList();
        $data['submenu'] = $this->User_model->getSubmenuList();

        $this->load->view('menu/submenuList',$data);
    }
    public function addSubmenu(){

        $this->form_validation->set_rules('menu','Menu','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('submenu','Sub Menu','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $data = array('menu_id'    =>$this->input->post('menu'),
                          'submenu'    =>$this->input->post('submenu')
                        );

            $checkSubmenu = $this->User_model->getSubmenuDetails($data);
            if($checkSubmenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['submenu']      = '<p class="error">Submenu Already Exists</p>';
            }else{
                    $addSubmenu = $this->User_model->addSubmenu($data);

                    if($addSubmenu){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']     = 'Submenu Added Successfully';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']     = 'Please try again';
                    }
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function editSubmenu(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]|numeric');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $submenu = $this->User_model->getSubmenuDetails($filter);
            if($submenu){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $submenu;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function updateSubmenu(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]}numeric');
        $this->form_validation->set_rules('menu','Menu','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('submenu','Submenu','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'));
            $data = array('menu_id'    =>$this->input->post('menu'),
                          'submenu'    =>$this->input->post('submenu')
                        );

            $checkSubmenu = $this->User_model->getSubmenuDetails($data);
            if($checkSubmenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['submenu']      = '<p class="error">Menu Already Exists</p>';
            }else{
                $filter     = array('id'=>$this->input->post('id'));
                $updateSubmenu = $this->User_model->updateSubmenu($filter,$data);
                if($updateSubmenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Menu Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }
            
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function userPermissionView(){
        $filter = array('u.id'=>$this->session->userdata('permission'));
        $data['userdata'] = $this->User_model->getUserDetails($filter);
        $data['menu'] = $this->User_model->getMenuList();
        $this->load->view('user_permission',$data);
    }
    public function updatePermission(){

        $permission = $this->input->post('permission');

        $permission = implode(',', $permission);


        $filter = array('id'=>$this->session->userdata('user_id'));
        $data   = array('permission'=>$permission);

        $updatePermission = $this->User_model->updatePermission($filter,$data);

        redirect(base_url().'User/userPermissionView');
    }

}
