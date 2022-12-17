<?php

class AdminModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('image_lib');
    }



    public function getDetails($table_name = NULL,$filter = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($limit || $offset){
            $this->db->limit($limit,$offset);
        }
        if($order_by){
            $this->db->order_by($order_by);
        }

        return $this->db->get($table_name)->row_array();
    }

    public function getList($table_name = NULL,$filter = NULL,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){

        if($select){
            $this->db->select($select,false);
        }
        if($filter){
            $this->db->where($filter);
        }
        if($limit && $offset && $limit != 0){
            $this->db->limit($limit,$offset);
        }
        // $this->db->limit(50);
        if($order_by){
            $this->db->order_by($order_by);
        }
        if($join){
            $joins = explode(',',$join);

            $this->db->join($joins[0],$joins[1]);
        }
        return $this->db->get($table_name)->result_array();
    }

    public function getMulitple($table_name,$ids,$filter = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($ids){   
           $this->db->where_in('id',$ids); 
        }
        if($data){
            return $this->db->get($table_name)->result_array();
        }else{
            return false;
        }
    }
    public function insert($table_name,$data){
        // $data['created_at'] = date('Y-m-d h:i:s');
        $this->db->insert($table_name,$data);
        return $this->db->insert_id();
    }
    public function insertBatch($table_name,$data){
        return $this->db->insert_batch($table_name,$data);
    }
    public function updateBatch($table_name,$data,$column_name){
        return $this->db->update_batch($table_name,$data,$column_name);
    }
    public function deleteBatch($table,$column_name,$ids){
        $this->db->where_in($column_name,$ids);
        return $this->db->delete($table);
    }
    public function delete($table_name,$filter){
        $this->db->where($filter);
        return $this->db->delete($table_name);
    }

    public function update($table_name,$filter = NULL,$data = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($data){
            return $this->db->update($table_name,$data);
        }else{
            return false;
        }
    }
    public function updateMulitple($table_name,$ids,$data = NULL){

        if($ids){
           $this->db->where_in('id',$ids); 
        }
        if($data){
            return $this->db->update($table_name,$data);
        }else{
            return false;
        }
    }
    public function getProductList(){
        $this->db->select('p.id as product_id,p.*,c.*,p.status as product_status');
        $this->db->join('categories c','c.id = p.category_id');
        return $this->db->get('products p')->result_array();
    }


    public function getCustomerNumber($mobile){
        $this->db->select('mobile');
        $this->db->like('mobile',$mobile);
        $this->db->order_by('name','ASC');
        return $this->db->get('customers')->result_array();
    }
    public function getProductData($filter){
        $this->db->where($filter);
        return $this->db->get('products p')->row_array();
    }


  

    public function getDashboardData(){
            $query = "SELECT 
              ( SELECT COUNT(id) FROM customers)  AS total_customer";

            $query_result = $this->db->query($query);
            return $query_result->row_array();  
    }
    public function getCustomerList(){
        $this->db->select('c.*,em.id as enquiry_id,em.*');
        $this->db->join('customer_1 c','c.unique_id = em.customer_unique_id');
        return $this->db->get('enquiry_master em')->result_array();
    }
    public function getCustomerListDetails($filter){
        $this->db->select('c.id as customer_id,c.*,ca.*,c.status as customer_status');
        if($filter){
            $this->db->where($filter);
        }
        $this->db->join('customer_addresses ca','ca.customer_unique_id = c.unique_id','left');
        $this->db->group_by('mobile');
        return $this->db->get('customers c')->result_array();
    }


    //get Customer details 
    public function getCustomerDetailsRows($postData){
        $this->_get_customer_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllCustomerDetails(){
        $this->db->from('customers');
        return $this->db->count_all_results();
    }
    public function countFilteredCustomerDetails($postData){
        $this->_get_customer_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_customer_details_datatables_query($postData){



        $this->db->select('id,c.name,c.mobile,c.email,c.status,c.created_at as created');
        $this->db->group_by('c.mobile');
        $this->db->from('customers c');
        // Set orderable column fields
        $this->column_order = array('name','mobile','email','c.status','c.created_at');

        // Set searchable column fields
        $this->column_search = array('name','mobile','email','c.status','c.created_at');
        // Set default order
        $this->order = array('c.created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){



                    if($value['name'] == 'name' || $value['name'] == 'mobile' || $value['name'] == 'email' || $value['name'] == 'c.status'){

                            
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'c.created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') <=", $end_date);
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

    //product
    public function getProductDetailsRows($postData){
        $this->_get_product_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllProductDetails(){
        $this->db->from('products');
        return $this->db->count_all_results();
    }
    public function countFilteredProductDetails($postData){
        $this->_get_product_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_product_details_datatables_query($postData){



        $this->db->select('p.id as product_id,p.image,model_no,vehicale_name,brand,category_name as category,mrp,p.status,p.new_products,p.top_selling_products,p.created_at as created');
        $this->db->join('categories c','c.id = p.category_id');
        $this->db->join('brand b','b.id = p.brand_id');
        $this->db->from('products p');
        // Set orderable column fields
        $this->column_order = array(false,false,false,'model_no','vehicale_name','brand','category_name','mrp','new_products','top_selling_products','p.status','p.created_at');

        // Set searchable column fields
        $this->column_search = array(false,false,false,'model_no','vehicale_name','brand','category_name','mrp','new_products','top_selling_products','p.status','p.created_at');
        // Set default order
        $this->order = array('c.created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){



                    if($value['name'] == 'model_no' || $value['name'] == 'vehicale_name' || $value['name'] == 'brand' || $value['name'] == 'category_name' || $value['name'] == 'mrp' || $value['name'] == 'p.status'){

                            
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'p.created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') <=", $end_date);
                     }else if($value['name'] == 'new_products' || $value['name'] == 'top_selling_products'){
                            $this->db->or_like($value['name'],$value['search']['value']);

                            if ($value['search']['value'] == '2') {
                                $this->db->or_where($value['name'],NULL);
                            }
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


    public function getSectionProductList($filter,$search,$brand,$category,$limit,$offset){
        $this->db->select('p.id as id,model_no,vehicale_name,p.image,mrp,description,color_code,background_color,p.status as product_status,new_products,top_selling_products');
        // $this->db->where('p.status','1');
        if($search){
            $this->db->like('model_no',$search,'both');
            $this->db->or_like('description',$search,'both');
            $this->db->or_like('vehical_application',$search,'both');
            $this->db->or_like('category_name',$search,'both');
            $this->db->or_like('brand',$search,'both');
            $this->db->or_like('vehicale_name',$search,'both');
            $this->db->or_like('p.tags',str_replace(['-', ':', '/',' '], '',$search),'both');
        }
        if($brand){
            $this->db->where('p.brand_id',$brand);
        }
        if($category){
            $this->db->where('category_id',$category);
        }
        $this->db->limit($limit, $offset);
        if($filter){
            $this->db->where($filter);    
        }
        
        
        $this->db->join('brand b','b.id = p.brand_id');
        $this->db->join('categories c','c.id = p.category_id');
        // $this->db->join('home_section_products hsp','hsp.product_id = p.id','left');
        $this->db->group_by('model_no');
        $this->db->having('product_status','1');
        if($filter){
            if(array_key_first($filter) == 'new_products'){
                $this->db->having('new_products','1');
            }else{
                $this->db->having('top_selling_products','1');
            }
        }
        $this->db->order_by('vehicale_name');
        return $this->db->get('products p')->result_array();
    }
    public function getCategoryList(){
        $this->db->select('categories.*,brand');
        $this->db->join('brand','brand.id = categories.brand_id');
        return $this->db->get('categories')->result_array();    
    }

    public function getSuggestionList($filter){
        $this->db->where($filter);
        $this->db->join('products p','p.id = sp.product_id');
        $this->db->join('products pr','pr.id = sp.suggested_product_id');
        $this->db->join('condition c','c.id = sp.condition_id');
        $this->db->get('suggested_products sp')->result_array();
    }
    
    //suggestion product
    //product
    public function getSuggestionProductDetailsRows($postData){
        $this->_get_suggestion_product_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllSuggestionProductDetails(){
        $this->db->from('suggested_products');
        return $this->db->count_all_results();
    }
    public function countFilteredSuggestionProductDetails($postData){
        $this->_get_suggestion_product_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_suggestion_product_details_datatables_query($postData){



        $this->db->select('sp.id,sp.product_id as product_id,p.model_no as product_name,condition,pr.model_no as suggested_product,sp.status as status,sp.created_at as created_at');
        $this->db->join('products p','p.id = sp.product_id');
        $this->db->join('products pr','pr.id = sp.suggested_product_id');
        $this->db->join('condition c','c.id = sp.condition_id');
        $this->db->from('suggested_products sp');
        // Set orderable column fields
        $this->column_order = array(false,'p.model_no','condition','pr.model_no','sp.status','sp.created_at');

        // Set searchable column fields
        $this->column_search = array('p.model_no','condition','pr.model_no','sp.status','sp.created_at');
        // Set default order
        $this->order = array('sp.created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){



                    if($value['name'] == 'p.model_no' || $value['name'] == 'condition' || $value['name'] == 'pr.model_no' || $value['name'] == 'sp.status'){

                            
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'sp.created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(sp.created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(sp.created_at,'%m%d') <=", $end_date);
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

    public function getProducts($filter){
        $this->db->where($filter);
        $this->db->select('id,model_no');
        return $this->db->get('products')->result_array();
    }

    public function getConditions($filter){
        $this->db->where($filter);
        $this->db->select('id,condition');
        return $this->db->get('condition')->result_array();
    }
    public function getSuggestedProducts($filter){
        $this->db->select('condition,product_id,suggested_product_id');
        $this->db->where($filter);
        $this->db->join('condition c','c.id = sp.condition_id');
        return $this->db->get('suggested_products sp')->result_array();
    }
    public function getClientDetails($search,$customer_id,$sales_person_id){
        $this->db->select('c.id,c.name as client_name,email,mobile,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address');
        $this->db->where('c.id',$customer_id);
        $this->db->join('client_contacts cc','cc.client_id = c.id');
        $this->db->where('assign_sales_person',$sales_person_id);
        return $this->db->get('client c')->result_array();
    }
    public function getClientData($search,$sales_person_id){
        $this->db->select('c.id,c.name as client_name,assign_sales_person');
        if($search){
            $this->db->like('c.name',$search);
            $this->db->or_like('mobile',$search);    
        }
        $this->db->join('client_contacts cc','cc.client_id = c.id');
        if($sales_person_id){
            $this->db->having('assign_sales_person',$sales_person_id);    
        }
        $this->db->group_by('cc.client_id');
        return $this->db->get('client c')->result_array();
    }
    public function getClientDetailsData($client_id){
        $this->db->select('c.id,c.name as client_name,CONCAT(address_1,",",address_2,",",city,",",district,",",state,",",pincode) as address,email');
        $this->db->join('client_contacts cc','cc.client_id = c.id');
        $this->db->where('c.id',$client_id);
        return $this->db->get('client c')->row_array();
    }
    public function getModelNames(){
        $this->db->where('status','1');
        $this->db->select('id,model_no,mrp');
        return $this->db->get('products')->result_array();
    }
    public function getClientContactList($filter){
        $this->db->select("id,name,mobile,designation,CASE WHEN status = 1 THEN 'true' ELSE 'false' END as status");
        $this->db->where($filter);
        return $this->db->get('client_contacts')->result_array();
    }

    public function getProductNames($search){
        $this->db->select('p.id as id,model_no,p.status as product_status');
        if($search){
            $this->db->like('model_no',$search,'both');
            $this->db->or_like('description',$search,'both');
            $this->db->or_like('vehical_application',$search,'both');
            $this->db->or_like('category_name',$search,'both');
            $this->db->or_like('brand',$search,'both');
            $this->db->or_like('vehicale_name',$search,'both');
            $this->db->or_like('p.tags',str_replace(' ','',$search),'both');
        }
        $this->db->join('brand b','b.id = p.brand_id');
        $this->db->join('categories c','c.id = p.category_id');
        $this->db->join('home_section_products hsp','hsp.product_id = p.id','left');
        $this->db->group_by('model_no');
        $this->db->having('product_status','1');
        $this->db->order_by('vehicale_name');
        return $this->db->get('products p')->result_array();
    }

    public function getProductMRP($product_id){
        $this->db->select('p.id as id,model_no,mrp,p.status as product_status');
        $this->db->where('id',$product_id);
        $this->db->having('product_status','1');
        return $this->db->get('products p')->row_array();
    }

    



}

?>