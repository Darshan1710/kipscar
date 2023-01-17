<?php
class OrderModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getOrderDetailsRows($postData){
        $this->_get_order_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllOrderDetails(){
        $this->db->from('orders');
        $this->db->where('client_contact_id','0');
        return $this->db->count_all_results();
    }
    public function countFilteredOrderDetails($postData){
        $this->_get_order_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_order_details_datatables_query($postData){
        
        $this->db->select('order_id,c.name as customer_name,s.name as sales_person,invoice_no,total,o.status as order_status,o.created_at as order_created_at');
        $this->db->join('customers c','c.id = o.customer_id');
        $this->db->join('customers s','s.id = o.sales_person_id');
        $this->db->where('client_contact_id','0');
        $this->db->order_by('order_id','desc');
        $this->db->from('orders o');
        // Set orderable column fields
        $this->column_order = array(null,'sales_person','customer_name','invoice_no','total','order_status','order_created_at');

        // Set searchable column fields
        $this->column_search = array(false,'sales_person','customer_name','invoice_no','total','order_status','order_created_at');
        // Set default order
        $this->order = array('o.created_at' => 'desc');  



        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    
                    if($value['name'] != ''){
                        if($value['name'] == 'order_created_at'){
                                $dates            = explode('-',$value['search']['value']);
                                $start_date       = date('md',strtotime($dates['0']));
                                $end_date         = date('md',strtotime($dates['1']));
                                $this->db->where("DATE_FORMAT(o.created_at,'%m%d') >=", $start_date);
                                $this->db->where("DATE_FORMAT(o.created_at,'%m%d') <=", $end_date);
                         }else if($value['name'] == 'sales_person'){
                                $this->db->like('s.name',$value['search']['value']);
                         }else if($value['name'] == 'customer_name'){
                                $this->db->like('c.name',$value['search']['value']);
                         }else if($value['name'] == 'order_status'){
                                $this->db->like('o.status',$value['search']['value']);
                         }
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else if($item == 'sales_person'){
                        $this->db->or_like('s.name',$postData['search']['value']);
                 }else if($item == 'customer_name'){
                        $this->db->or_like('c.name',$postData['search']['value']);
                 }else if($item == 'order_status'){
                        $this->db->or_like('o.status',$postData['search']['value']);
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

    public function getSalesOrderDetailsRows($postData){
        $this->_get_sales_order_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countSalesAllOrderDetails(){
        $this->db->from('orders');
        $this->db->where('client_contact_id !=','0');
        return $this->db->count_all_results();
    }
    public function countFilteredSalesOrderDetails($postData){
        $this->_get_sales_order_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_sales_order_details_datatables_query($postData){
        
        $this->db->select('order_id,cu.name as customer_name,s.name as sales_person,invoice_no,total,o.status as order_status,o.created_at as order_created_at');
        $this->db->join('client c','c.id = o.client_contact_id');
        $this->db->join('customers s','s.id = o.sales_person_id');
        $this->db->join('client cu','cu.id = o.customer_id');
        $this->db->order_by('order_id','desc');
        $this->db->from('orders o');
        // Set orderable column fields
        $this->column_order = array(null,'sales_person','customer_name','invoice_no','total','order_status','order_created_at');

        // Set searchable column fields
        $this->column_search = array(false,'sales_person','customer_name','invoice_no','total','order_status','order_created_at');
        // Set default order
        $this->order = array('o.created_at' => 'desc');  



        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    
                    if($value['name'] != ''){
                        if($value['name'] == 'order_created_at'){
                                $dates            = explode('-',$value['search']['value']);
                                $start_date       = date('md',strtotime($dates['0']));
                                $end_date         = date('md',strtotime($dates['1']));
                                $this->db->where("DATE_FORMAT(o.created_at,'%m%d') >=", $start_date);
                                $this->db->where("DATE_FORMAT(o.created_at,'%m%d') <=", $end_date);
                         }else if($value['name'] == 'sales_person'){
                                $this->db->like('s.name',$value['search']['value']);
                         }else if($value['name'] == 'customer_name'){
                                $this->db->like('c.name',$value['search']['value']);
                         }else if($value['name'] == 'order_status'){
                                $this->db->like('o.status',$value['search']['value']);
                         }
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else if($item == 'sales_person'){
                        $this->db->or_like('s.name',$postData['search']['value']);
                 }else if($item == 'customer_name'){
                        $this->db->or_like('c.name',$postData['search']['value']);
                 }else if($item == 'order_status'){
                        $this->db->or_like('o.status',$postData['search']['value']);
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

    public function getCustomerOrderData($filter){
        $this->db->where($filter);
        $this->db->select('c.name as customer_name,c.id as id,mobile,total,invoice_no,c.name as name,c.name as contact_person,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address');    
        $this->db->join('customers c','c.id = o.customer_id');
        $this->db->join('customer_addresses ca','ca.customer_id = c.id');
        return $this->db->get('orders o')->row_array();
    }

    public function getClientOrderData($filter){
        $this->db->where($filter);
        $this->db->select('c.id as id,c.name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,cc.mobile,total,cu.name as sales_person_name,cu.id as sales_person_id,cc.id as client_contact_id,invoice_no,cc.name as contact_person');
        $this->db->join('client c','c.id = o.customer_id');
        $this->db->join('client_contacts cc','cc.id = o.client_contact_id');
        $this->db->join('customers cu','cu.id = o.sales_person_id');
        return $this->db->get('orders o')->row_array();
    }

    public function getOrderDetails($filter){
        if($filter){
         $this->db->where($filter);   
        }
        $this->db->select('od.product_id,qty,discount_percentage as discount,model_no,od.mrp as mrp,description');
        $this->db->join('products p','p.id = od.product_id');
        $this->db->join('orders o','o.order_id = od.order_id');
        $this->db->group_by('od.id');
        return $this->db->get('order_list od')->result_array();
    }

    public function getOrderByDetails($filter){
        $this->db->where($filter);
        $this->db->select('c.name as customer_name,s.name as sales_person_name,s.id as sales_person_id,c.id as customer_id,');
        $this->db->join('customers c','c.id = o.customer_id');
        $this->db->join('customers s','s.id = o.sales_person_id');
        return $this->db->get('orders o')->row_array();
    }

    public function getOrderListBySalesPerson($sales_person_id,$order_by,$search,$limit,$offset){
        $this->db->select('c.id as customer_id,c.name as client_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,cc.mobile,COUNT(order_id) as number_of_order,ROUND(SUM(total),2) as order_value');
        if($search){
            $this->db->where('customer_id',$search);
        }

        $this->db->where('sales_person_id',$sales_person_id);
        $this->db->join('client c','c.id = o.customer_id');
        $this->db->join('client_contacts cc','cc.id = o.client_contact_id');
        $this->db->limit($limit,$offset);
        $this->db->order_by('o.created_at',$order_by);
        $this->db->group_by('customer_id');
        return $this->db->get('orders o')->result_array();
    }

    public function getOrderListByClient($customer_id,$sales_person_id,$order_by = false,$order_date = false,$limit = false,$offset = false){
        $this->db->select('c.name as client_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,cc.mobile');
        $this->db->where('sales_person_id',$sales_person_id);
        $this->db->where('customer_id',$customer_id);
        $this->db->join('client c','c.id = o.customer_id');
        $this->db->join('client_contacts cc','cc.id = o.client_contact_id');
        $this->db->limit($limit,$offset);
        if($order_date){
            $this->db->order_by('o.created_at',$order_date);
        }else if($order_by){
            $this->db->order_by('total',$order_by);
        }
        $this->db->group_by('customer_id');
        return $this->db->get('orders o')->row_array();
    }
    public function getOrderListByCustomer($customer_id,$sales_person_id,$order_by = false,$order_date = false,$limit = false,$offset = false){
        $this->db->select('c.name as client_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,c.mobile');
        $this->db->where('sales_person_id',$sales_person_id);
        $this->db->where('o.customer_id',$customer_id);
        $this->db->join('customers c','c.id = o.customer_id');
        $this->db->join('customer_addresses ca','ca.customer_id = c.id','');
        $this->db->limit($limit,$offset);
        if($order_by){
            $this->db->order_by('total',$order_by);
        }else if($order_date){
            $this->db->order_by('o.created_at',$order_date);
        }
        $this->db->group_by('o.customer_id');
        return $this->db->get('orders o')->row_array();
    }

    public function getOrderListDetails($customer_id,$sales_person_id,$order_by = false,$order_date = false,$limit = false,$offset = false){
        $this->db->select("o.order_id as order_id,invoice_no,COUNT(ol.id) as number_of_items,total,DATE_FORMAT(o.created_at,'%d-%m-%Y %h:%i %p') as order_date,CASE WHEN o.status = 1 THEN 'Complete' ELSE 'Pending' END as status",false);
        $this->db->where('sales_person_id',$sales_person_id);
        $this->db->where('customer_id',$customer_id);
        $this->db->join('order_list ol','ol.order_id = o.order_id');
        $this->db->join('products p','p.id = ol.product_id');
        $this->db->limit($limit,$offset);
        if($order_date){
            $this->db->order_by('o.created_at',$order_date);
        }else if($order_by){
            $this->db->order_by('total',$order_by);
        }
        $this->db->group_by('o.order_id');
        return $this->db->get('orders o')->result_array();
    }

    public function getOrderDetailsData($filter = false){
        $this->db->select('invoice_no as invoice_number,invoice_no,invoice_link,c.name as customer_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,cc.mobile as mobile,total,DATE_FORMAT(o.created_at,"%d-%m-%Y %h:%i %p") as order_date,CASE WHEN o.status = 1 THEN "Complete" ELSE "Pending" END as status',false);
        if($filter){
            $this->db->where($filter);    
        }
        $this->db->join('client c','o.customer_id = c.id');
        $this->db->join('client_contacts cc','cc.id = o.client_contact_id');
        return $this->db->get('orders o')->row_array();
    }

    public function getCustomerOrderDetailsData($filter = false){
        $this->db->select('invoice_no as invoice_number,invoice_no,invoice_link,c.name as customer_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,c.mobile as mobile,total,DATE_FORMAT(o.created_at,"%d-%m-%Y %h:%i %p") as order_date,CASE WHEN o.status = 1 THEN "Complete" ELSE "Pending" END as status',false);
        if($filter){
            $this->db->where($filter);    
        }
        $this->db->join('customers c','o.customer_id = c.id');
        $this->db->join('customer_addresses ca','ca.customer_id = c.id','right');
        return $this->db->get('orders o')->row_array();
    }

    public function getOrderProductDetails($order_id){
        $this->db->select("CONCAT('https://kipscar.globalbyte.co.in/',product_images) as image,model_no,ol.mrp as mrp,description,discount_percentage,qty");
        $this->db->where('ol.order_id',$order_id);
        $this->db->join('order_list ol','ol.order_id = o.order_id');
        $this->db->join('products p','p.id = ol.product_id');
        $this->db->join('product_images pi','pi.product_id = p.id');
        $this->db->order_by('img_order','asc');
        $this->db->group_by('ol.product_id');
        return $this->db->get('orders o')->result_array();
    }

    public function getCartDetails($filter,$customer_id){
        $this->db->select("c.id,CONCAT('https://kipscar.globalbyte.co.in/',product_images) as image,model_no,p.mrp as mrp,description,discount,qty");
        if($filter){
            $this->db->where($filter);    
        }
        $this->db->join('products p','p.id = c.product_id');
        $this->db->join('product_images pi','pi.product_id = p.id');
        $this->db->order_by('img_order','asc');
        $this->db->order_by('c.created_at','desc');
        $this->db->group_by('pi.product_id');
        return $this->db->get('cart c')->result_array();
    }

    public function getCartItemDetails($filter){
        $this->db->select('c.id as id,p.id as product_id,mrp,p.status as product_status,qty,discount');
        $this->db->where($filter);
        $this->db->having('product_status','1');
        $this->db->join('cart c','c.product_id = p.id');
        return $this->db->get('products p')->row_array();
    }
 
}

?>
