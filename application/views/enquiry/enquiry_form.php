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
  <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->

  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>

  <!-- /core JS files -->

  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>

   <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

  <script src="<?php echo base_url() ?>js/app.js"></script>
  <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
  <script src="<?php echo base_url() ?>js/custom.js"></script>


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
              <li><a href="#">Enquiry</a></li>
              <li class="active">Add Enquiry</li>
            </ul>

          </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-flat">

                <div class="panel-body">
         
                   <a class="btn btn-sm btn-success" href="#" data-target="#customer" data-toggle="modal" id="customer_modal"><i class="icon-plus2"></i> Add Customer</a>
                   <a class="btn btn-sm btn-success" href="#" id="add_address_button"><i class="icon-plus2"></i> Add Address</a>
                  <hr>
                  <form method="post" action="#" id="addEnquiry">
                    <input type="hidden" name="customer_unique_id" id="customer_unique_id" value="new">
                   <div class="row">
                    
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Name:</label>
                          <input type="text" class="form-control name" name="name">
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Mobile:</label>
                          <input type="number" minlength="10"  maxlength="10" class="form-control mobile customer_mobile"  name="mobile" id="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Email:</label>
                          <input type="text" class="form-control email"  name="email" >
                        </div>
                    </div>
                  </div>

                  <div class="row address_section" >
                    
                    
                  </div>


                  <legend class="text-semibold">Order Information</legend>
                  <div class="error-div">
                    </div>
                  <?php 

                  if(isset($enquiry_details)){
                    $count = COUNT($enquiry_details);
                  }else{
                    $count = 0;
                  } ?>
                  <input class="hidden_count"  name="hidden_count" value="<?php echo $count; ?>" id="hidden_count" type="hidden">
                  <input type="hidden" name="enquiry_id" value="<?php if($this->uri->segment(3) != ''){ echo $this->uri->segment(3); }else{ echo 'new'; } ?>">
                  <?php if(isset($enquiry_details)){
                  $i = 1;
                  foreach($enquiry_details as $row){ ?>
                  <div class="row clone-div">
                    
                    <div class="<?php echo $i; ?>">
                    
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Product Name</label>
                          

                          <select class="select-search form-control" name="product_id" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" disabled>
                            <optgroup label="Products">
                              <option>Please Select Product</option>
                              <?php foreach($products as $p){ ?>
                              <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $row['product_id'] == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['product_name'] ?></option>
                              <?php } ?> 
                            </optgroup>
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                          <input type="hidden" name="product_name[]" value="<?php echo $row['product_id'] ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Unit Price:</label>
                          <input type="text" class="form-control" placeholder="Unit Price" name="offline_price[]" value="<?php echo set_value('id',isset($row['sell_price']) ? $row['sell_price'] : '')?>" readonly id="offline_price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('offline_price[]') ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Qty:</label>
                          <input type="text" class="form-control qty" placeholder="Qty" name="qty[]" min="1" value="<?php echo set_value('id',isset($row['qty']) ? $row['qty'] : '0')?>" id="qty_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('qty[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Price:</label>
                          <input type="text" class="form-control price price_<?php echo $i; ?>" placeholder="Price" name="price[]" value="<?php echo set_value('id',isset($row['price']) ? $row['price'] : '0')?>" id="price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('price[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                          <label>&nbsp;</label>
                          <button class="btn btn-primary form-control remove" data-remove="<?php echo $i; ?>" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                  <?php $i++; } }else{
                    $i = 0;
                   ?>
                    <div class="row clone-div" >
                    

                    </div>
                  <?php } ?>
                  <div class="row">
                  <div class="col-md-1">
                    <button class="btn btn-primary" type="button" id="add_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                  </div>
                  <div class="col-md-offset-6 col-md-1"><label style="margin-top: 10%">Sub Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text"  readonly="" class="form-control" id="total" value="<?php echo set_value('total',isset($enquiry['total']) ? $enquiry['total'] : '')?>">
                    </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-offset-4 col-md-2"><label>Discount Type</label>
                  <select class="select form-control discount_type" name="discount_type"  data-count="<?php echo $i ?>">
                      <option value="">Please Select Option</option>
                      <option value="1">Percentage</option>
                      <option value="2">Normal</option>
                    </select>
                  </div>
                  <div class=" col-md-2">
                    <div class="form-group">
                      <label>Discount</label>
                    <input type="number" class="form-control discount" id="discount" name="discount">
                    </div>
                  </div>
                  <div class=" col-md-4">
                    <div class="form-group">
                      <label>Final Discount</label>
                    <input type="number" class="form-control" id="final_discount" step="0.01" value="0">
                    </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-offset-7 col-md-1"><label style="margin-top: 10%">Delivery </label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="number"  name="delivery_charge" class="form-control" id="delivery_charge" value="">
                    </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-offset-7 col-md-1"><label style="margin-top: 10%">Final Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text"  readonly="" class="form-control"  id="final_total" value="<?php echo set_value('final_total',isset($enquiry['total']) ? $enquiry['total'] : '')?>">
                    </div>
                  </div>
                  </div>

                  <div class="row">
                    <button class="btn btn-primary pull-right submit-button" id="order_submit">Submit</button>
                  </div>
                  </form>
              </div>
            </div>
          </div>
          <!-- /select2 selects -->

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
<div id="customer" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Customer</h5>
            </div>

            <form action="#" method="post" id="customerform" enctype="multipart/form-data">
                <div class="modal-body" id="customer-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Mobile</label>
                                <input type="number" minlength="10"  maxlength="10" class="form-control customer_mobile" id="customer_mobile" name="customer_mobile" value="" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            <div class="col-sm-4">
                                <label>Name</label>
                                <input type="text" placeholder="Name" class="form-control name" name="customer_name" id="customer_name">
                            </div>
                            <div class="col-sm-4">
                                <label>Email</label>
                                <input type="text" placeholder="Email" class="form-control email" name="customer_email" id="customer_email">
                            </div>
                        </div>
                    </div>


                    <div class="form-group" id="password_section">
                        <div class="row">
                          
                            <div class="col-sm-4">
                                <label>Password</label>
                                <input type="text" placeholder="Password" class="form-control password" name="password" id="password">
                            </div>
                            <div class="col-sm-4">
                                <label>Confirm Password</label>
                                <input type="text" placeholder="Confirm Password" class="form-control confirm_password" name="confirm_password" id="confirm_password">
                            </div>
                            <div class="col-sm-4">
                                <label>&nbsp;</label><br>
                                <button class="btn btn-primary auto_generate" type="button">Auto generate Password</button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                                <label>Type</label>
                                <select class="form-control type" name="customer_type" id="customer_type">
                                    <option value="home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                          <div class="col-sm-4">
                                <label>Flat House</label>
                                <input type="text" placeholder="Flat House" class="form-control flat_house" name="customer_flat_house" id="customer_flat_house">
                            </div>
                            <div class="col-sm-4">
                                <label>Street Society</label>
                                <input type="text" placeholder="Street Society" class="form-control street_society" name="customer_street_society" id="customer_street_society">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          
                          <div class="col-sm-4">
                                <label>Pincode</label>
                                <input type="number" placeholder="Pincode" minlength="6"  maxlength="6" class="form-control pincode" name="customer_pincode" id="customer_pincode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            <div class="col-sm-4">
                                <label>City</label>
                                <input type="text" placeholder="City" class="form-control city" name="customer_city" id="customer_city">
                            </div>
                            <div class="col-sm-4">
                                <label>Is Default</label>
                                <select class="form-control select" name="customer_is_default" id="customer_is_default"> 
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_customer">Add Customer</button>
  
                </div>
            </form>
        </div>
    </div>
</div>

<div id="address" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Customer Address</h5>
            </div>

            <form action="#" method="post" id="address_form">
                <input type="hidden" name="add_address_customer_id" id="add_address_customer_id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                                <label>Type</label>
                                <select class="form-control type" name="type" id="type">
                                    <option value="home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                          <div class="col-sm-4">
                                <label>Flat House</label>
                                <input type="text" placeholder="Flat House" class="form-control flat_house" name="flat_house" id="flat_house">
                            </div>
                            <div class="col-sm-4">
                                <label>Street Society</label>
                                <input type="text" placeholder="Street Society" class="form-control street_society" name="street_society" id="street_society">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          
                          <div class="col-sm-4">
                                <label>Pincode</label>
                                <input type="number" placeholder="Pincode" minlength="6"  maxlength="6" class="form-control pincode" name="pincode" id="pincode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            <div class="col-sm-4">
                                <label>City</label>
                                <input type="text" placeholder="City" class="form-control city" name="city" id="city">
                            </div>
                            <div class="col-sm-4">
                                <label>Is Default</label>
                                <select class="form-control select" name="is_default" id="is_default"> 
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_address" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Customer Address</h5>
            </div>

            <form action="#" method="post" id="edit_address_form">
              <input type="hidden" name="edit_address_id" id="edit_address_id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                                <label>Type</label>
                                <select class="form-control type" name="edit_type" id="edit_type">
                                    <option value="home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                          <div class="col-sm-4">
                                <label>Flat House</label>
                                <input type="text" placeholder="Flat House" class="form-control flat_house" name="edit_flat_house" id="edit_flat_house">
                            </div>
                            <div class="col-sm-4">
                                <label>Street Society</label>
                                <input type="text" placeholder="Street Society" class="form-control street_society" name="edit_street_society" id="edit_street_society">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          
                          <div class="col-sm-4">
                                <label>Pincode</label>
                                <input type="number" placeholder="Pincode" minlength="6"  maxlength="6" class="form-control pincode" name="edit_pincode" id="edit_pincode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            <div class="col-sm-4">
                                <label>City</label>
                                <input type="text" placeholder="City" class="form-control city" name="edit_city" id="edit_city">
                            </div>
                            <div class="col-sm-4">
                                <label>Is Default</label>
                                <select class="form-control select" name="edit_is_default" id="edit_is_default"> 
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="loader">
<center>
 <img class="loading-image" src="<?php echo base_url()?>images/loader.gif" alt="loading..">
</center>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">
<script type="text/javascript">
      $(document).ajaxStart(function(){
          $('.loader').show();
          $('.submit-button').prop('disabled', true);
        });

        $(document).ajaxComplete(function(){
          $('.loader').hide();
          $('.submit-button').prop('disabled', false);
        });
        
       $( ".customer_mobile" ).autocomplete({
            source: function(request, response) {
                 $.ajax({  
                 url : "<?php echo site_url('Customer/getCustomerNumber?');?>",
                 data: { mobile : request.term},
                 dataType: "json",
                 type: "POST",
                 success: function(data){
                  response(data.items);
                 } 

                 });
             },
             minLength: 3
          });

      $(document).on('focusout','.qty',function(){
            var qty = $(this).val();
            var count = $(this).data('count');
            var final_count = $('#hidden_count').val();
            var offline_price = $('#offline_price_'+count).val();
            var total = qty * offline_price;
            $('#price_'+count).val(total);
            var delivery_charge = $('#delivery_charge').val();

            if(!delivery_charge){
                delivery_charge = 0;
              }

            var final_total = 0;
            for(var i = 1; i <= final_count; i++){
                var price = $('.price_'+i).val();
                if(price){
                  final_total = parseInt(final_total)+parseInt(price);
                }
            }
            final_total = final_total + parseInt(delivery_charge);
            $('#total').val(final_total);
            $('#final_total').val(final_total);
        });

        $(document).on('focusout','.discount',function(){
              var total = $('#total').val();
              var discount = $('#discount').val();
              var discount_type = $('.discount_type').val();
              var delivery_charge = $('#delivery_charge').val();
              var final_total = 0;

              if(!delivery_charge){
                delivery_charge = 0;
              }

              if(discount_type == '1'){
                discount_data = ((discount / 100) * total);
                final_total = total - discount_data;
              }else{
                final_total = total - discount;
                discount_data = discount;
              }
              final_total = final_total + parseInt(delivery_charge);
              $('#final_discount').val(discount_data);
              $('#final_total').val(final_total);
          });

        $(document).on('change','.discount_type',function(){
              var total = $('#total').val();
              var discount = $('#discount').val();
              var discount_type = $('.discount_type').val();
              var delivery_charge = $('#delivery_charge').val();
              var final_total = 0;

              if(!delivery_charge){
                delivery_charge = 0;
              }

              if(discount_type == '1'){
                discount_data = ((discount / 100) * total);
                final_total = total - discount_data;
              }else{

                final_total = total - discount;
                discount_data = discount;
              }
              final_total = final_total + parseInt(delivery_charge);
              $('#final_discount').val(discount_data);
              $('#final_total').val(final_total);
          });

         $(document).on('focusout','#delivery_charge',function(){
              var total = $('#total').val();
              var final_discount = $('#final_discount').val();
              var delivery_charge = $('#delivery_charge').val();
              

              if(!delivery_charge){
                delivery_charge = 0;
              }

              if(!total){
                total = 0;
              }

              var final_total = (parseInt(total) + parseInt(delivery_charge));
              final_total = final_total - parseFloat(final_discount);
              $('#final_total').val(final_total);
          });

         $(document).on('focusout','.price',function(){
              var total = $('#total').val();
              var final_discount = $('#final_discount').val();
              var delivery_charge = $('#delivery_charge').val();
              
              if(!delivery_charge){
                delivery_charge = 0;
              }

              var final_total = (parseInt(total) + parseInt(delivery_charge));
              final_total = final_total - parseFloat(final_discount);
              $('#final_total').val(final_total);
          });

        

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            var final_count = $('#hidden_count').val();
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var final_total = 0;
            // var inputs = $(".price");
            for(var i = 1; i <= final_count; i++){
                var price = $('.price_'+i).val();
                if(price){
                  final_total = parseInt(final_total)+parseInt(price);
                }
            }
            $('#total').val(final_total);
        });


        $(document).on('change','.pro', function() {
            var base_url = $('#base_url').val();
            var id = $(this).val();
            var data_count = $(this).data('count');
            var hidden_id = $('#hidden_count').val();
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Product/getProductDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        $('#offline_price_'+data_count).val(obj.message.offline_price);
                        $('#stock_in_'+data_count).val(obj.message.stock);
                    }else{
                       // alert('No products found');
                    }
                }
            });
        });

        $(document).on('click','#applyButton', function() {
            var base_url = $('#base_url').val();
            var final_total = $('#final_total').val();
            var coupen = $('.coupen').val();
            $.ajax({
                type : 'post',
                data : {final_total:final_total,coupen:coupen},
                url : base_url+'Coupon/applyCoupen',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        alert(obj.message);

                        $('#final_total').val(obj.final_total);
                    }else{
                        alert('Please Apply Coupen');
                    }
                }
            });
        });

        $(document).on('change','#mobile', function() {
            var base_url = $('#base_url').val();
            var mobile = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {mobile:mobile},
                url : base_url+'Customer/getCustomerDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){

                        $('#name').val(obj.data.name);
                        $('#email').val(obj.data.email);
                        $('#mobile').val(obj.data.mobile);
                        $('#type').val(obj.data.type);
                        $('#flat_house').val(obj.data.flat_house);
                        $('#street_society').val(obj.data.street_society);
                        $('#pincode').val(obj.data.pincode);
                        $('#city').val(obj.data.city);
                        $('#is_default').val(obj.data.is_default);
                        $('#password_section').remove();
                    }else{
                        //alert('No Customer found');
                    }
                }
            });
        });

        $(document).on('change','.customer_mobile', function() {
            var base_url = $('#base_url').val();
            var mobile = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {mobile:mobile},
                url : base_url+'Customer/getCustomerDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){

                        $('.name').val(obj.data.name);
                        $('.email').val(obj.data.email);
                        $('.mobile').val(obj.data.mobile);
                        $('.type').val(obj.data.type);
                        $('.flat_house').val(obj.data.flat_house);
                        $('.street_society').val(obj.data.street_society);
                        $('.pincode').val(obj.data.pincode);
                        $('.city').val(obj.data.city);
                        $('.is_default').val(obj.data.is_default);
                        $('#password_section').remove();
                    }else{
                       // alert('No Customer found');
                    }
                }
            });
        });

        $('.auto_generate').on('click',function(){
               var length           = 10;
               var result           = '';
               var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               var charactersLength = characters.length;
               for ( var i = 0; i < length; i++ ) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
               }
               $('.password').val(result);
               $('.confirm_password').val(result);
        })


        $(document).on('click','#add_address_button', function() {
          var unique_id = $('#add_address_customer_id').val();
          if(!unique_id){
            alert('Please Select Customer');
          }else{
            $('#address').modal('show');
          }
        });

        $(document).on('click','.edit_address', function() {
            var base_url = $('#base_url').val();
            var id = $(this).data('id');
   
            $('#edit_address_id').val(id);
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Customer/getAddressDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){

                        $('#edit_type').val(obj.data.type);
                        $('#edit_flat_house').val(obj.data.flat_house);
                        $('#edit_street_society').val(obj.data.street_society);
                        $('#edit_pincode').val(obj.data.pincode);
                        $('#edit_city').val(obj.data.city);
                        $('#edit_is_default').val(obj.data.is_default);

                    }else{
                      //  alert('No Customer found');
                    }
                }
            });
        });

        $('#edit_address_form').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Customer/updateAddress',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'delivery_boy_id' || key == 'delivery_zone_id'){
                              element.closest('.select').next('.select2').after(value);
                            }else{
                              element.closest('.form-control').after(value);
                            }
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });

        $(document).on('change','.mobile', function() {
            var base_url = $('#base_url').val();
            var mobile = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {mobile:mobile},
                url : base_url+'Customer/getCustomerAddressDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                      $('.address_section').empty();

                      $('#customer_unique_id').val(obj.data.unique_id);
                        $('.name').val(obj.data.name);
                        $('.email').val(obj.data.email);
                        $('#add_address_customer_id').val(obj.data.unique_id);
                            
                            var div = '';
                            var i = 0;
                            $.each(obj.data.address,function(index,value){
                            var c = '';
                            if(i == 0){
                              c = 'checked';
                            }
                            div += '<div class="col-sm-4" style="padding:5px">'+
                                  '<div class="panel-body" style="border: 1px dashed;padding:10px">'+
                                    '<label><strong>'+value.type+'</strong></label><br>'+
                                    
                                    '<label for="address"><address style="margin-bottom:0px;"><input type="radio" id="address_id" name="address_id" value="'+value.id+'" '+c+'> &nbsp;&nbsp;'+value.flat_house+','+value.street_society+','+value.city+','+value.pincode+'&nbsp;&nbsp;<a data-target="#edit_address" data-toggle="modal" class="btn btn-primary btn-sm edit_address" data-id="'+value.id+'">Edit</a></address></label>'+
                                  '</div>'+
                                '</div>';
                                
                              });
                            
  
                            $('.address_section').append(div);
                            
     
                        
                    }else{
                      //  alert('No Customer found');
                    }
                }
            });
        });

        $(document).on('click','#add_button',function(){
            // $('.clone-row').first().clone().last().appendTo('#clone-div');
            var base_url = $('#base_url').val();
            $.ajax({
                url : base_url+'Product/getProductList',
                success:function(data){
                    var obj = $.parseJSON(data);
                    var id  = $('#hidden_count').val();

                    var j  = parseInt(id)+1;
      
                    $('#hidden_count').val(j);

                    if(obj.errCode == -1){
                        var div = 
                              '<div class="'+j+'">'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                  '<label>Product Name</label>'+
                                  '<select class="select-search form-control pro products_'+j+'"'+
                                                   'name="product_name[]" id="product_name" data-count="'+j+'">'+
                                                    '<option>Please Select Product</option>'+
                                                      '<optgroup label="Products">Products>';

                                                  $.each(obj.message,function(index,value){
                                                      div += '<option value="'+value.id+'" data-price="'+value.price+'">'+value.product_name+'</option>';
                                                      });
                    div   +=  '</optgroup></select></div></div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Unit Price:</label>'+
                                    '<input type="text" class="form-control" placeholder="Unit Price"'+
                                    'name="offline_price[]"  id="offline_price_'+j+'" readonly data-count="'+j+'">'+
                                    '</div>'+
                              '</div>'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                    '<label>Qty:</label>'+
                                    '<input type="text" class="form-control qty" placeholder="Qty"'+
                                    'name="qty[]" min="1" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                    '<label>Price:</label>'+
                                    '<input type="text" class="form-control price price_'+j+'"'+ 
                                    'placeholder="Price" name="price[]" id="price_'+j+'" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-1">'+
                              '<div class="form-group">'+
                                  '<label>&nbsp;</label>'+
                                  '<button class="btn btn-primary form-control remove"'+
                                  'data-remove="'+j+'" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                              '</div>'+
                            '</div>'+
                            '</div>';

     

                        $('.clone-div').last().append(div);

                        $('.select-search').select2();
                        
                    }else{
                     //   alert('No Customer found');
                    }
                }
            });
        });
        
        $('#addEnquiry').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Enquiry/addEnquiry',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                      $('#order_id').val(obj.order_id);
                      $('#order_customer_id').val(obj.customer_unique_id);
                   
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'delivery_boy_id' || key == 'delivery_zone_id'){
                              element.closest('.select').next('.select2').after(value);
                            }else{
                              element.closest('.form-control').after(value);
                            }
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });

        $('#customerform').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Customer/addCustomer',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        $('#customer').modal('hide');
                        $('.name').val(obj.message.name);
                        $('.mobile').val(obj.message.mobile);
                        $('.email').val(obj.message.email);
                        $('.customer_unique_id').val(obj.message.unique_id);

                        $('#add_address_customer_id').val(obj.message.unique_id);
                            
                            var div = '';
                            var i = 0;
                            $.each(obj.message.address,function(index,value){
                            var c = '';
                            if(i == 0){
                              c = 'checked';
                            }
                            div += '<div class="col-sm-4" style="padding:5px">'+
                                  '<div class="panel-body" style="border: 1px dashed;padding:10px">'+
                                    '<label><strong>'+value.type+'</strong></label><br>'+
                                    
                                    '<label for="address"><address style="margin-bottom:0px;"><input type="radio" id="address_id" name="address_id" value="'+value.id+'" '+c+'> &nbsp;&nbsp;'+value.flat_house+','+value.street_society+','+value.city+','+value.pincode+'&nbsp;&nbsp;<a data-target="#edit_address" data-toggle="modal" class="btn btn-primary btn-sm edit_address" data-id="'+value.id+'">Edit</a></address></label>'+
                                  '</div>'+
                                '</div>';
                                
                              });
                            
  
                            $('.address_section').append(div);
                            

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'delivery_boy_id' || key == 'delivery_zone_id'){
                              element.closest('.select').next('.select2').after(value);
                            }else{
                              element.closest('.form-control').after(value);
                            }
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });

        $('#address_form').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Customer/addCustomerAddress',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'delivery_boy_id' || key == 'delivery_zone_id'){
                              element.closest('.select').next('.select2').after(value);
                            }else{
                              element.closest('.form-control').after(value);
                            }
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });

        $(document).on('focusout','.recieved_amount',function(){
          var change = 0;
              var amount = $('.amount').val();
              var recieved_amount = $('.recieved_amount').val();
              if(recieved_amount > amount){
                var change = recieved_amount - amount;
              }
              
              $('.change').val(change);
          });

        $(document).on('change','.payment_mode', function() {

            var payment_mode = $('.payment_mode').val();
            if(payment_mode == 'cash'){
              $('.cash').css('display','block');
              $('.cheque').css('display','none');
              $('.upi').css('display','none');
              $('.nfet').css('display','none');
            }else if(payment_mode == 'cheque'){
              $('.cash').css('display','none');
              $('.cheque').css('display','block');
              $('.upi').css('display','none');
              $('.nfet').css('display','none');
            }else if(payment_mode == 'nfet'){
              $('.cash').css('display','none');
              $('.cheque').css('display','none');
              $('.upi').css('display','none');
              $('.nfet').css('display','block');
            }else if(payment_mode == 'upi'){
              $('.cash').css('display','none');
              $('.cheque').css('display','none');
              $('.upi').css('display','block');
              $('.nfet').css('display','none');
            }

            var order_id = $('#order_id').val();
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: {order_id:order_id},
                url: base_url + 'Enquiry/getEnquiryDetails',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                       $('.amount').val(obj.message.amount);

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                              element.closest('.form-control').after(value);

                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });

        $('#customer_modal').on('click',function(){
            $('#customerform')[0].reset()
        });

          
</script>