<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salesorder extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function getOrderList(){
        $data = $row = array();
    

        // Fetch member's records
        $memData = $this->OrderModel->getSalesOrderDetailsRows($_POST);

        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $status = '';
            if($member->order_status == 1){
                $status =  '<button class="btn btn-success btn-sm">Complete</button>';
            }else if($member->order_status == 2){
                $status = '<button class="btn btn-warning btn-sm">Pending</button>';
            }



            // $view_ordrer = '<a href="'.base_url().'Order/orderDetails/'.$member->order_id.'/'.$member->unique_id.'" class="btn btn-sm btn-success">View Order</a>';

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Order/invoice/'.$member->order_id.'"><i class="icon-file-excel"></i> Invoice</a></li>
                                    <li><a href="'.base_url().'Order/editOrder/'.$member->order_id.'"><i class="icon-pencil"></i> Edit</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';

            
            $data[] = array($member->order_id,
                            $i,
                            $member->sales_person, 
                            $member->customer_name,
                            $member->invoice_no,
                            $member->total,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->order_created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->OrderModel->countSalesAllOrderDetails(),
            "recordsFiltered" => $this->OrderModel->countFilteredSalesOrderDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function orderList(){
        $this->load->view('order/salesorderList');
    }

}
