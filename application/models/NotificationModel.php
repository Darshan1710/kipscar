<?php

class NotificationModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get Customer details 
    public function getNotificationDetailsRows($postData){
        $this->_get_notification_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllNotificationDetails(){
        $this->db->from('notification');
        return $this->db->count_all_results();
    }
    public function countFilteredCustomerDetails($postData){
        $this->_get_notification_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_notification_details_datatables_query($postData){



        $this->db->select('id,title,image,activity,value_code,status,created_at');
        $this->db->from('notification');
        // Set orderable column fields
        $this->column_order = array('title','activity','value_code','created_at');

        // Set searchable column fields
        $this->column_search = array('title','activity','value_code','created_at');
        // Set default order
        $this->order = array('created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){



                    if($value['name'] == 'title' || $value['name'] == 'activity' || $value['name'] == 'value_code' || $value['name'] == 'created_at'){

                            
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(created_at,'%m%d') <=", $end_date);
                     }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                
                if($i===0){
                        
                        $this->db->like($item, $postData['search']['value']);
                }else{
                    
                        
                        $this->db->or_like($item, $postData['search']['value']);
                                        
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
    public function getAllAppId(){
        $this->db->select('id,mobile,fcm_token');
        return $this->db->get('customers')->result_array();

    }


 
}

?>
