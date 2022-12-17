<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE; ?></title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/datatables_responsive.js"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <?php $this->load->view('common/navbar'); ?>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <?php $this->load->view('common/sidebar'); ?>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">


                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo base_url() ?>Admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li><a href="#.html">Order</a></li>
                            <li class="active">Order List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <div class="row">
                            <?php if($order['order_status'] == 0){?>
                            <a class="btn btn-sm btn-warning cancel-order" href="#"><i class="icon-home4"></i> Cancel Order</a>
                            <a class="btn btn-sm btn-danger damage-order"><i class="icon-home4"></i> Damage Order</a>
                            </div>
                            <?php } ?>
                            <div class="col-sm-5">
                            <h6 class="card-title">Name :<code><?php echo $order['name'] ?></code></h6>
                            <h6 class="card-title">Mobile :<code><?php echo $order['mobile'] ?></code></h6>
                            </div>
                            <div class="col-sm-5">
                            <h6 class="card-title">Email :<code><?php echo $order['email'] ?></code></h6>
                            <h6 class="card-title">Address :<code><?php echo $order['address'] ?></code></h6>
                            </div>
                        </div>


                        <table class="table datatable-responsive" >
                            <thead>
                                <tr>
                                    <?php if($order['order_status'] == 0){?>
                                    <th><input type='checkbox' id='checkallusers' class="checkallusers"></th>
                                    <?php } ?>
                                    <th>Sr. No.</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($order_details)) {
                                    $i = 1;
                                      foreach($order_details as $row){
                                      
                                ?>
                                    <tr>
                                    <?php if($order['order_status'] == 0){?>
                                    <td><input type='checkbox' class="sel_users" value="<?php echo $row['id'] ?>" name="order_details_id"></td>
                                    <?php } ?>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['rate']; ?></td>
                                    <td><?php echo $row['qty']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php if($row['product_status'] == '1'){
                                        echo '<button class="btn btn-sm btn-success">confirm</button>';
                                    }else if($row['product_status'] == '2'){ 
                                        echo '<button class="btn btn-sm btn-warning">cancel</button>';
                                    }else if($row['product_status'] == '3'){ 
                                        echo '<button class="btn btn-sm btn-danger">damage</button>';
                                    }?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row['created_at']));?></td>

                                    
                                </tr>
                                <?php 
                                    $i++;
                                    } }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /basic responsive configuration -->


                    <!-- Footer -->
                    <?php $this->load->view('common/footer'); ?>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

</body>
</html>
<script type="text/javascript">
    $("#checkallusers").change(function(){
    var checked = $(this).is(':checked'); 

    // Select all
    if(checked){
       $('.sel_users').each(function() {
          $(this).prop('checked',true);
       });
    }else{
       // Deselect All
       $('.sel_users').each(function() {
         $(this).prop('checked',false);
       });
    }

});

$('.cancel-order').on('click',function(){
    var favorite = [];
    $.each($("input[name='order_details_id']:checked"), function(){
        favorite.push($(this).val());
    });

    if(favorite.length > 0){
            if(confirm('Are you sure want to cancel?')){

                var base_url = $('#base_url').val();
                $.ajax({
                        type: 'post',
                        data: {id: favorite},
                        url: base_url + 'Order/cancelOrder',
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            if (obj.errCode == -1) {
                                window.location.reload();
                            } else if (obj.errCode == 2) {
                                alert(obj.message);
                            } else if (obj.errCode == 3) {
                                alert('Inputs are not valid');
                            }

                        }

                    });
            }
    }else{
        alert('Please Select Atleast one product');
    }
    
    
    
});

$('.damage-order').on('click',function(){
    var favorite = [];
    $.each($("input[name='order_details_id']:checked"), function(){
        favorite.push($(this).val());
    });

    if(favorite.length > 0){
        if(confirm('Are you sure want to cancel?')){
            

            var base_url = $('#base_url').val();

            if(favorite.length > 0){
                var base_url = $('#base_url').val();
                $.ajax({
                        type: 'post',
                        data: {id: favorite},
                        url: base_url + 'Order/damageOrder',
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            if (obj.errCode == -1) {
                                window.location.reload();
                            } else if (obj.errCode == 2) {
                                alert(obj.data);
                            } else if (obj.errCode == 3) {
                                alert('Inputs are not valid');
                            }

                        }

                    });
            }else{
                alert('Select Atleast one product');
            }
            
        }
    }else{
        alert('Please Select Atleast one product');
    }
});

</script>
