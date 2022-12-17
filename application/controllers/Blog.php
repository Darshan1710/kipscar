<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function fileCheck($image){
        return file_check($image,'image');
    }
    public function blogList() {
        $filter            = array('status'=>'1');
        $data['blog']      = $this->AdminModel->getList('blogs',$filter);
        $data['main_view'] = 'blogList';
        $this->load->view('blog/blogList', $data);
    }

    public function blogForm() {
        if($this->session->userdata('logged_in')){
            $filter    = array('status'=>'1');
            $data['main_view'] = 'blogForm';
            $this->load->view('blog/blogForm',$data);
        }else{
            redirect(base_url());
        }
    }

    
    public function addBlog() {
        if($this->session->userdata('logged_in')){
            $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('content','Content','required');
            $this->form_validation->set_rules('image','','callback_fileCheck');
            if($this->form_validation->run()){
                $title    = $this->input->post('title');
                $content  = $this->input->post('content');
                $status  = $this->input->post('status');

                if($_FILES){
                    $config = array(
                        'upload_path'   => './resources/assets/frontend/images/blog/',
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite'     => TRUE,
                        'max_size'      => "*", 
                        'max_height'    => "*",
                        'max_width'     => "*"
                        );

                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('image')){ 
                            $data['imageError'] =  $this->upload->display_errors();
                            print_r($data);exit;
                            die();
                        }
                        else{
                            $imageDetailArray = $this->upload->data();
                            $image =  $config['upload_path'].$imageDetailArray['file_name'];
                        }
                }



                $blog = array(
                              'title'   =>$title,
                              'content' =>$content,
                              'image'   =>$image,
                              'status'  =>$status
                          );

                $addBlog = $this->AdminModel->insert('blogs',$blog);

                if($addBlog){
                    redirect(base_url('Blog/blogList'));
                }else{
                    $data['msg']       = 'Please Try again';
                    $this->load->view('blogForm',$data);    
                }
            }else{
                $this->load->view('blog/blogForm');
            }
        }else{
            redirect(base_url());
        }
    }

    public function editBlog(){
        if($this->session->userdata('logged_in')){
            $data['id'] = $this->uri->segment(3);
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[11]|numeric');
            if($this->form_validation->run()){
                $id     = $this->uri->segment(3);
                $filter = array('id'=>$id);
                $blog = $this->AdminModel->getDetails('blogs',$filter);
                if($blog){
                    $c_filter           = array('status'=>'1');
                    $data['blog']       = $blog;
                    $data['main_view']  = 'editBlog';
                    $this->load->view('editBlog',$data);
                }else{
                    redirect(base_url('Blog/blogList'));
                }
            }else{
                redirect(base_url('Blog/blogList'));
            }
        }else{
            redirect(base_url());
        }
    }

    public function updateBlog() {
        if($this->session->userdata('logged_in')){
            $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]|numeric');
            $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('content','Content','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('image','','callback_fileCheck');
            if($this->form_validation->run()){
                $blog_id  = $this->input->post('id');
                $title    = $this->input->post('title');
                $content  = $this->input->post('content');
                $status  = $this->input->post('status');

                if($_FILES){
                    $config = array(
                        'upload_path'   => './resources/assets/images/blog/',
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite'     => TRUE,
                        'max_size'      => "2048000", 
                        'max_height'    => "264",
                        'max_width'     => "370"
                        );

                    
                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('image')){ 
                            $data['imageError'] =  $this->upload->display_errors();
                        }
                        else{
                            $imageDetailArray = $this->upload->data();
                            $image =  $config['upload_path'].$imageDetailArray['file_name'];
                        }
                }else{
                    $image = $this->input->post('previous_image');
                }

                $blog = array(
                              'title'   =>$title,
                              'content' =>$content,
                              'image'   =>$image,
                              'status' =>$status
                          );

                $filter     = array('id'=>$blog_id);
                $updateBlog = $this->AdminModel->updateBlog('blogs',$blog);

                if($updateBlog){
                    redirect(base_url('Blog/blogList'));
                }else{
                    $data['msg']       = 'Please Try again';
                   
                    $this->load->view('editBlog',$data);    
                }
            }else{
               
                $this->load->view('view/editBlog');
            }
        }else{
            redirect(base_url());
        }
    }



    public function deleteBlog($id) {
        $deleteblog=$this->AdminModel->deleteBlog($id);
        if($deleteblog){
            redirect(base_url('Blog/blogList'));
        }else{
            $this->load->view('base_template_admin',$data); 
        }
    }

}
