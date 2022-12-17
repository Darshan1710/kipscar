<?php
class CustomerModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getClientNumber($mobile){
        $this->db->select('mobile');
        $this->db->like('mobile',$mobile);
        return $this->db->get('client_contacts')->result_array();
    }

    public function getClientDetails($filter){
        $this->db->select('c.id as client_id,c.name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,mobile');
        $this->db->where($filter);
        $this->db->where('c.status','1');
        $this->db->join('client_contacts cc','cc.client_id = c.id');
        return $this->db->get('client c')->row_array();
    }

}

?>
