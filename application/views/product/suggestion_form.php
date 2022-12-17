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
              <li><a href="#">Product</a></li>
              <li class="active">Add Suggested Product</li>
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
         
   
                  <form method="post" action="#" id="add">
                   <div class="row">
                    
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Model No:</label>
                          <select class="form-control select-search" name="model_no" id="model_no">
                              <option selected="" value="">Please Select Model No</option>

                              <?php if(isset($products) && !empty($products)){ 
                              foreach($products as $p){ ?>
                              <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $model_no == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['model_no'] ?></option>
                            <?php } } ?>
                          </select>
                        </div>
                    </div>
                  </div>


                  <legend class="text-semibold">Information</legend>
                  <div class="error-div">
                    </div>
                  <?php 

                  if(isset($product_details)){
                    $count = COUNT($product_details);
                  }else{
                    $count = 0;
                  } ?>
                  <input class="hidden_count"  name="hidden_count" value="<?php echo $count; ?>" id="hidden_count" type="hidden">
                  
                  <?php if(isset($product_details) && !empty($product_details)){
                  $i = 1;
                  foreach($product_details as $row){ ?>
                  <div class="row clone-div">
                    
                    <div class="<?php echo $i; ?>">
                    
                    
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>Condition</label>
                          
                          <select class="select-search form-control select" name="condition[]" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" >
                            <optgroup label="Products">
                              <option>Please Select Condition</option>
                              <?php foreach($condition as $c){ ?>
                              <option value="<?php echo $c['id'] ?>" <?php echo set_select('condition', $c['id'], $row['condition_id'] == $c['id'] ? TRUE : FALSE ); ?>><?php echo $c['condition'] ?></option>
                              <?php } ?> 
                            </optgroup>
                          </select>
                          <p><?php echo form_error('condition') ?></p>
                         
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Product Id:</label>
                          <select class="select-search form-control" name="product[]" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" >
                            <optgroup label="Products">
                              <option>Please Select Product</option>
                              <?php foreach($products as $p){ ?>
                              <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $row['suggested_product_id'] == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['model_no'] ?></option>
                              <?php } ?> 
                            </optgroup>
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
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
        

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            var final_count = $('#hidden_count').val();
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var final_subtotal = 0;
            // var inputs = $(".price");
            for(var i = 1; i <= final_count; i++){
                var price = $('.price_'+i).val();
                if(price){
                  final_subtotal = parseInt(final_subtotal)+parseInt(price);
                }
            }
            
        });

        $(document).on('click','#add_button',function(){
            // $('.clone-row').first().clone().last().appendTo('#clone-div');
            var base_url = $('#base_url').val();
            $.ajax({
                url : base_url+'Product/getSuggestionData',
                success:function(data){
                    var obj = $.parseJSON(data);
                    var id  = $('#hidden_count').val();

                    var j  = parseInt(id)+1;
      
                    $('#hidden_count').val(j);

                    if(obj.errCode == -1){
                        var div = 
                              '<div class="'+j+'">'+
                              '<div class="col-md-8">'+
                                '<div class="form-group">'+
                                  '<label>Condition</label>'+
                                  '<select class="select-search form-control pro condition_'+j+'"'+
                                                   'name="condition[]" id="condition" data-count="'+j+'">'+
                                                    '<option>Please Select condition</option>'+
                                                      '<optgroup label="Condition">Products>';

                                                  $.each(obj.message.condition,function(index,value){
                                                      div += '<option value="'+value.id+'" data-price="'+value.condition+'">'+value.condition+'</option>';
                                                      });
                    div   +=  '</optgroup></select></div></div>'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                    '<label>Price:</label>'+
                                    '<select class="select-search form-control pro products_'+j+'"'+
                                                   'name="product[]" id="product" data-count="'+j+'">'+
                                                    '<option>Please Select Product</option>'+
                                                      '<optgroup label="Product">Products>';

                                                  $.each(obj.message.products,function(index,value){
                                                      div += '<option value="'+value.id+'" data-price="'+value.model_no+'">'+value.model_no+'</option>';
                                                      });
                    div   +=  '</optgroup></select>'+
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
                        alert('No Condition Found.Please add conditions for suggested Product.');
                    }
                }
            });
        });
        
        
        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Product/addSuggestedProduct',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                      window.location.href = base_url+'Product/getSuggestionList';
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'model_no'){
                              element.closest('.select-search').next('.select2').after(value);
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