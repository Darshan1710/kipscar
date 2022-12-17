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
              <li><a href="#">Package</a></li>
              <li class="active">Add Package</li>
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
                  <h5 class="panel-title">Payment Form </h5>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td>Payment Mode</td>
                        <td>Recived Amount</td>
                        <td>Change</td>
                        <td>Cheque Number</td>
                        <td>Transcation Id</td>
                        <td>Account Number</td>
                        <td>Action</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($payment) && !empty($payment)){ 
                      foreach($payment as $row){ ?>
                      <tr>
                        <td><?php echo $row['payment_mode'] ?></td>
                        <td><?php echo $row['recieved_amount'] ?></td>
                        <td><?php echo $row['change'] ?></td>
                        <td><?php echo $row['cheque_number'] ?></td>
                        <td><?php echo $row['transcation_id'] ?></td>
                        <td><?php echo $row['account_number'] ?></td>
                        <td>
                          <button class="btn btn-sm btn-danger delete_payment" type="button" id="<?php echo $row['id'] ?>">Delete</button></td>
                      </tr>
                    <?php } } ?>
                    </tbody>
                  </table>
                  <hr>
                  <form method="post" action="#" id="addPayment">

                <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Payment Mode:</label>
                          <select class="form-control select payment_mode" name="payment_mode" readonly id="payment_mode">
                          <option value="">Please Select</option>
                          <option value="cash">Cash</option>
                          <option value="cheque">Cheque</option>
                          <option value="upi">UPI</option>
                          <option value="nfet">NFET</option>

                          </select>
                          <p><?php echo form_error('payment_mode') ?></p>
                        </div>
                    </div>

                  </div>

                  <legend class="text-semibold">Payment Information</legend>
                  <input  name="order_id" value="<?php echo $this->uri->segment(3); ?>" type="hidden">
                  <input type="hidden" name="customer_id" value="<?php echo $this->uri->segment(4);?>">

                  <div class="row cash" style="display: none;">
                    
                    
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Amount:</label>
                          <input type="number" class="form-control amount" placeholder="Amount " name="amount" value="<?php echo $amount?>">
                          <p><?php echo form_error('amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Recieved Amount:</label>
                          <input type="number" class="form-control recieved_amount" placeholder="Recieved Amount" name="cash_recieved_amount" step="0.01">
                          <p><?php echo form_error('cash_recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Change:</label>
                          <input type="text" class="form-control change" placeholder="Change" name="change" step="0.01">
                        </div>
                    </div>
                  </div>

                  <div class="row cheque" style="display: none;">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Amount:</label>
                          <input type="number" class="form-control amount" placeholder="Amount " name="amount" value="<?php echo $amount?>" readonly>
                          <p><?php echo form_error('amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Recieved Amount:</label>
                          <input type="number" class="form-control recieved_amount" placeholder="Recieved Amount" name="cheque_recieved_amount" step="0.01">
                          <p><?php echo form_error('cheque_recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Cheque Number:</label>
                          <input type="text" class="form-control cheque_number"  placeholder="Cheque Number" name="cheque_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Cheque Date:</label>
                          <input type="date" class="form-control cheque_date" placeholder="Cheque Date" name="cheque_date" >
                        </div>
                    </div>
                  </div>

                  <div class="row upi" style="display: none;">
                    
                    
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Amount:</label>
                          <input type="number" class="form-control amount" placeholder="Amount Amount" name="amount" value="<?php echo $amount?>" readonly>
                          <p><?php echo form_error('recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Recieved Amount:</label>
                          <input type="number" class="form-control recieved_amount" placeholder="Recieved Amount" name="upi_recieved_amount" step="0.01">
                          <p><?php echo form_error('upi_recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Transcation Id:</label>
                          <input type="text" class="form-control transcation_id" placeholder="Transcation Id" name="transcation_id" >
                        </div>
                    </div>
                  </div>

                  <div class="row nfet" style="display: none;">
                    
                    
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Amount:</label>
                          <input type="number" class="form-control amount" placeholder="Amount Amount" name="amount" value="<?php echo $amount?>" readonly>
                          <p><?php echo form_error('recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Recieved Amount:</label>
                          <input type="number" class="form-control recieved_amount" placeholder="Recieved Amount" name="nfet_recieved_amount" step="0.01">
                          <p><?php echo form_error('nfet_recieved_amount') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Account Number:</label>
                          <input type="text" class="form-control account_number" placeholder="Account Number" name="account_number" >
                        </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <?php if($amount > 0){ ?>
                    <button class="btn btn-primary pull-right submit-button" id="order_submit">Submit</button>
                    <?php } ?>
                    <?php if($amount <= 0){ ?>
                    <a class="btn btn-primary pull-right submit-button mr-10" href="<?php echo base_url() ?>Order/orderList">Go to Order List</a>
                    <?php } ?>
                  </div>
                
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
        
        $(document).on('focusout','.recieved_amount',function(){
              var amount = $('.amount').val();
              var recieved_amount = $('.recieved_amount').val();
              var change = recieved_amount - amount;
              $('.change').val(change);
          });

        $(document).on('change','.payment_mode', function() {

            var amount = $('.amount').val();
            if(amount < 1){
              alert('Payment is complete');
              $('.amount').val(0);
            }

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

        });

        $('#addPayment').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Order/addPayment',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                       if(confirm('Are you sure you want to add another payment ?')){
                        window.location.reload();
                       }else{
                        window.location.href = base_url+'Order/orderList';
                       }

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

        $('.delete_payment').on('click',function(e) {
          if(confirm('Are you sure you want to delete payment?')){
              
              var id = $(this).attr('id');
              alert(id);
              var base_url = $('#base_url').val();
              $.ajax({
                  type: 'post',
                  data: {id:id},
                  url: base_url + 'Order/deletePayment',
                  success: function(data) {
                      var obj = $.parseJSON(data);
                      if (obj.errCode == -1) {
                         window.location.reload();
                      } else if (obj.errCode == 2) {
                          alert(obj.message);
                      }

                  }

              });
          }
            

        });
</script>