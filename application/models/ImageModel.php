
<?php

class ImageModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    
    function getAlbumList() {
        return $this->db->get('album_name')->result_array();
    }
    function getAlbumDetails($filter){
        $this->db->where($filter);
        return $this->db->get('album_name')->row_array();
    }
    
    function check_album_exist($filter = NULL, $order_by = NULL, $limit = NULL, $start = NULL) {

        if ($filter) {
            $this->db->where($filter);
        }
        if ($limit || $start) {
            $this->db->limit($limit, $start);
        }
        if ($order_by) {
            $this->db->order_by($order_by);
        }
        $sql = $this->db->get('album_name');
        return $sql->result_array();
    }
    
    public function insert_album_data($album_data) {
        $album_exist = $this->check_album_exist($album_data);

        if ($album_exist == TRUE) {
            echo '<script>alert("ALbum Name Already Exists");
                  window.location.href = "Product/gallery";</script>';
        } else {
            $this->db->insert('album_name', $album_data);
            return $this->db->insert_id();
        }
    }
    
    function getPhotoList($filter) {
        $this->db->where($filter);  
        return $this->db->get('gallery')->result_array();
    }
    function getPhotoDetails($filter){
        $this->db->where($filter);
        return $this->db->get('gallery')->row_array();
    }
     function insertPhotoData($data) {
        $this->db->insert('gallery', $data);
        return $this->db->insert_id();
    } 
    function updatePhotoData($filter,$data){
        $this->db->where($filter);
        return $this->db->update('gallery',$data);
    }
    function addAlbum() {
        $input = $this->input->post();
        $id = $this->input->post('id');
        $data = array(
            'album_name' => $input['album_name']
        );

        if ($id == "new") {
            $this->db->insert('album_name', $data);
        } else {
            $this->db->where('id', $id);
            $this->db->update('album_name', $data);
        }
        redirect('ImageController/gallery');
    }

    public function deleteMeta($id) {
        $this->db->where('id', $id);
        $this->db->delete('meta');
        redirect('MetaController/metaListView');
    }
    public function getImageList($filter){
        $this->db->where($filter);
        return $this->db->get('gallery')->result_array();
    }
    public function deletePhoto($filter){
        $this->db->where($filter);
        return $this->db->delete('gallery');
    }
    public function deleteAlbum($filter){
        $this->db->where($filter);
        return $this->db->delete('album_name');
    }
    public function getVideos(){
        return $this->db->get('video')->result_array();
    }
    function addVideo($data){
        return $this->db->insert('video',$data);
    }

 
}

?>
