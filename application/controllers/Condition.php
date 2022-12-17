<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Condition extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function conditionList(){
        $filter = array('status'=>'1');
        $data['condition'] = $this->AdminModel->getList('condition',$filter);
        $this->load->view('condition/condition',$data);
    }
    public function getConditionDetails(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter           = array('id'=>$this->input->post('id'));
            $data['condition'] = $this->AdminModel->getList('condition',$filter);
            
            if($data){
                $returnArr['error'] = false;
                $returnArr['message'] = $data;
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = array();
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
    public function addCondition(){
        $this->form_validation->set_rules('condition','Condition','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('condition'=>$this->input->post('condition'));

            $checkMenu = $this->AdminModel->getDetails('condition',$filter);
            if($checkMenu){
                    $returnArr['errCode']                   = 3;
                    $returnArr['messages']['condition']      = '<p class="error">Condition Already Exists</p>';
            }else{  

                    $data = array('condition'        =>$this->input->post('condition'),
                                  'status'          =>$this->input->post('status')
                              );

                    $addExperience = $this->AdminModel->insert('condition',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Condition Added Successfully';
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
    public function editCondition(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $category = $this->AdminModel->getDetails('condition',$filter);
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
    public function updateCondition(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('condition','Condition','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'condition'=>$this->input->post('condition'));

            $experience = $this->AdminModel->getDetails('condition',$filter);
            if($experience){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['product']      = '<p class="error">Condition Already Exists</p>';
            }else{


                $filter     = array('id'=>$this->input->post('id'));
                 $data = array('condition'       =>$this->input->post('condition'),
                               'status'          =>$this->input->post('status')
                              );
                $updateMenu = $this->AdminModel->update('condition',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'Condition Updated Successfully';
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


    public function deleteCondition(){
        $id = $this->uri->segment(3);
        if($id){


            $update = $this->AdminModel->deleteBatch('condition','id',$id);

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

}
