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
  <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->
  <!-- <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.date.js"></script> -->
  <script src="<?php echo base_url ()?>js/plugins/notifications/jgrowl.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/daterangepicker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/anytime.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.date.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.time.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/legacy.js"></script>


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
              <li><a href="#">Order</a></li>
              <li class="active">Add Order</li>
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
                  
                  <hr>
                  <form method="post" action="#" id="addOrder">

                  <div class="row" >
                    <?php if(isset($sales_person) && !empty($sales_person)){ ?>
                    <legend class="text-semibold">Sales Person</legend>
                   <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Sales Person:</label>
                          <select class="select-search form-control" name="sales_person_id" readonly id="sales_person_id<?php echo $i; ?>" data-count="<?php echo $i ?>" >
                            <optgroup label="Products">
                              <option>Please Select Sales Person</option>
                              <?php foreach($sales_person_list as $s){ ?>
                              <option value="<?php echo $s['id'] ?>" <?php echo set_select('sales_person_id', $s['id'], isset($order['sales_person_id']) && !empty($order['sales_person_id']) && $order['sales_person_id'] == $s['id'] ? TRUE : FALSE ); ?>><?php echo $s['name'] ?></option>
                              <?php } ?> 
                            </optgroup>
                          </select>
                          <p><?php echo form_error('sales_person_id') ?></p>
                        </div>
                    </div>
                  </div>
                    <?php } ?>
                    <?php 
                    $i = 0;
                    if(isset($order) && !empty($order)){ ?>

                      
                    <input type="hidden" name="id" id="id" value="<?php echo set_value('id',isset($order['id']) ? $order['id'] : 'new')?>">
                    <input type="hidden" name="client_contact_id" id="client_contact_id" value="<?php echo set_value('client_contact_id',isset($order['client_contact_id']) ? $order['client_contact_id'] : 'new')?>">
                   <legend class="text-semibold">order Information</legend>
                   <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Mobile:</label>
                          <input type="text" class="form-control mobile" name="mobile" value="<?php echo set_value('mobile',isset($order['mobile']) ? $order['mobile'] : '')?>" id="mobile">
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Client Name:</label>
                          <input type="text" class="form-control order_name" name="name" value="<?php echo set_value('name',isset($order['name']) ? $order['name'] : '')?>" id="name">
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Address:</label>
                          <input type="text" class="form-control address"  name="address" value="<?php echo set_value('address',isset($order['address']) ? $order['address'] : '')?>" id="address">
                        </div>
                    </div>
                  </div>
                   <?php  } ?>

                    
                    
                  </div>


                  <legend class="text-semibold">Order Information</legend>
                  <div class="error-div">
                    </div>
                  <?php 

                  if(isset($order_details)){
                    $count = COUNT($order_details);
                  }else{
                    $count = 1;
                  } 



                  ?>
                  <input type="hidden"  value="<?php echo $order['id']; ?>" name="id">
                  <input type="hidden"  value="<?php echo $count; ?>" id="hidden_count">
                  <input type="hidden"  value="<?php echo $count; ?>" id="total_count">
                  <input type="hidden" name="order_id" value="<?php if($this->uri->segment(3) != ''){ echo $this->uri->segment(3); }else{ echo 'new'; } ?>">
                  <?php if(isset($order_details)){
                  $i = 1;
                  foreach($order_details as $row){ ?>
                  <div class="row clone-div">
                    
                    <div class="<?php echo $i; ?>">
                    
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Product Name</label>
                        <select class="form-control" name="product_id" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" disabled>
                          <option>Please Select Product</option>
                          <?php foreach($products as $p){ ?>
                          <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $row['product_id'] == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['model_no'] ?></option>
                          <?php } ?> 
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                          <input type="hidden" name="model_no[]" value="<?php echo $row['product_id'] ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>MRP:</label>
                          <input type="text" class="form-control" placeholder="MRP" name="mrp[]" value="<?php echo set_value('id',isset($row['mrp']) ? $row['mrp'] : '')?>" readonly id="mrp_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('mrp[]') ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Qty:</label>
                          <input type="text" class="form-control qty" placeholder="Qty" name="qty[]" value="<?php echo set_value('id',isset($row['qty']) ? $row['qty'] : '0')?>" id="qty_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('qty[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Discount:</label>
                          <input type="text" class="form-control discount" placeholder="Discount" name="discount[]" value="<?php echo set_value('discount',isset($row['discount']) ? $row['discount'] : '0')?>" id="discount_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('discount[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Subtotal:</label>
                          <input type="text" class="form-control subtotal_<?php echo $i; ?>" placeholder="subtotal" name="subtotal[]" value="<?php echo set_value('id',isset($row['subtotal']) ?  round(str_replace(',','',$row['subtotal'])) : '0')?>" id="subtotal_<?php echo $i; ?>" data-count="<?php echo $i ?>" readonly>
                          <p><?php echo form_error('subtotal[]') ?></p>
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
                  </div>
                  
                  
                  <div class="row">
                  <div class="col-md-offset-7 col-md-1"><label style="margin-top: 10%">Final Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text"  readonly="" class="form-control" id="total" value="<?php echo set_value('total',isset($order['total']) ? $order['total'] : '')?>">
                    </div>
                  </div>
                  </div>


                  <div class="row">
                    <button class="btn btn-primary pull-right submit-button">Submit</button>
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




<script type="text/javascript">
      $(document).ajaxStart(function(){
          $('.loader').show();
          $('.submit-button').prop('disabled', true);
        });

        $(document).ajaxComplete(function(){
          $('.loader').hide();
          $('.submit-button').prop('disabled', false);
        });
        
        $( ".mobile" ).autocomplete({
            source: function(request, response) {
                 $.ajax({  
                 url : "<?php echo site_url('Customer/getClientNumber?');?>",
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
            var current_count = $(this).data('count');
            var qty = $(this).val();
            var data_count = $('#hidden_count').val();
            var mrp = $('#mrp_'+current_count).val();
            var subtotal = qty * mrp;
            var  discount = $('#discount_'+current_count).val(); 
              
            discount = (parseFloat(subtotal) * parseFloat(discount)) / 100;
            var subtotal = subtotal - discount;
            $('#subtotal_'+data_count).val(subtotal);
         

            var final_subtotal = 0;
            for(var i = 1; i <= data_count; i++){
              
                var price = $('.subtotal_'+i).val();
                if(price){
                  price = parseFloat(price);
                  final_subtotal += price;
                }
            }

            $('#total').val(final_subtotal);
        });



        $(document).on('focusout','.discount',function(){
              var current_count = $(this).data('count');
              var data_count = $('#hidden_count').val();
              var mrp = $('#mrp_'+current_count).val();
              var qty = $('#qty_'+current_count).val();
              var subtotal = mrp * qty;
              var  discount = $('#discount_'+current_count).val(); 
              
              discount = (parseFloat(subtotal) * parseFloat(discount)) / 100;
              subtotal = subtotal - discount;
              $('#subtotal_'+data_count).val(subtotal);

              var final_subtotal = 0;
              for(var i = 1; i <= data_count; i++){
                  var subtotal = $('.subtotal_'+i).val();
                  if(subtotal){
                    subtotal = parseFloat(subtotal);
                    final_subtotal += subtotal;
                  }
              }

             // console.log(subtotal+''+delivery_charge+'_d '+final_discount+'_f');
              $('#total').val(final_subtotal.toFixed(2));
          });

        

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            var final_count = $('#hidden_count').val();
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var final_subtotal = 0;
            // var inputs = $(".price");
            for(var i = 1; i <= final_count; i++){
                var subtotal = $('.subtotal_'+i).val();
                if(subtotal){
                  final_subtotal = parseFloat(final_subtotal)+parseFloat(subtotal);
                }
            }
            
            
            
             // console.log(subtotal+''+delivery_charge+'_d '+final_discount+'_f');
              $('#total').val(final_subtotal.toFixed(2));
        });


        $(document).on('change','.pro', function() {

          var mrp = $(this).select2().find(":selected").data("mrp");
          var data_count = $(this).data('count');
          $('#mrp_'+data_count).val(mrp);
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
                        $('#sell_price_'+data_count).val(obj.message.sell_price);
                        $('#stock_in_'+data_count).val(obj.message.stock);
                    }else{
                        alert('No products found');
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
                url : base_url+'Customer/getClientDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                      $('.mobile, .name, .address').empty();

                        $('#id').val(obj.data.client_id);
                        $('#name').val(obj.data.name);
                        $('#mobile').val(obj.data.mobile);
                        $('#address').val(obj.data.address);
                        
                    }else{
                        alert('No Record found');
                    }
                }
            });
        });

        $(document).on('click','#add_button',function(){
            // $('.clone-row').first().clone().last().appendTo('#clone-div');
            var base_url = $('#base_url').val();
            $.ajax({
                url : base_url+'Product/getModelNames',
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
                                                   'name="model_no[]" id="model_no" data-count="'+j+'">'+
                                                    '<option>Please Select Product</option>'+
                                                      '<optgroup label="Products">Products>';

                                                  $.each(obj.message,function(index,value){
                                                      div += '<option value="'+value.id+'" data-mrp="'+value.mrp+'">'+value.model_no+'</option>';
                                                      });
                    div   +=  '</optgroup></select></div></div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>MRP:</label>'+
                                    '<input type="text" class="form-control" placeholder="MRP"'+
                                    'name="mrp[]"  id="mrp_'+j+'" readonly data-count="'+j+'">'+
                                    '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Qty:</label>'+
                                    '<input type="text" class="form-control qty qty_'+j+'" placeholder="Qty"'+
                                    'name="qty[]" id="qty_'+j+'" min="1" data-count="'+j+'" value="1">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Discount:</label>'+
                                    '<input type="text" class="form-control discount discount_'+j+'" placeholder="Discount"'+
                                    'name="discount[]" min="1" data-count="'+j+'" value="0" id="discount_'+j+'">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Subtotal:</label>'+
                                    '<input type="text" class="form-control subtotal subtotal_'+j+'"'+ 
                                    'placeholder="Subtotal" name="subtotal[]" id="subtotal_'+j+'" data-count="'+j+'" value="0" readonly>'+
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
                        alert('No Customer found');
                    }
                }
            });
        });
        
       $('#addOrder').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Order/updateOrder',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        location.reload();
                        

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            element.closest('.form-control').after(value);
                        });
                    }else if(obj.errCode == 5){
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
                url: base_url + 'Customer/addOrderCustomer',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        window.location.reload();

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


          
</script>