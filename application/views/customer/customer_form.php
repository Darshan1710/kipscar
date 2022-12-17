
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customer Form</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/extras/animate.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
	<script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
	<script src="<?php echo base_url() ?>js/custom.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url() ?>js/app.js"></script>
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
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="components_tabs.html">Components</a></li>
							<li class="active">Tabs</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Basic tabs title -->


					<!-- Bordered tab content -->
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Customer</h6>
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                		<li><a data-action="reload"></a></li>
					                		<li><a data-action="close"></a></li>
					                	</ul>
				                	</div>
								</div>

								<div class="panel-body">
									<div class="tabbable tab-content-bordered">
										<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
											<li class="active"><a href="#account_information" data-toggle="tab">Account Information</a></li>
											<li><a href="#address" data-toggle="tab" style="<?php echo $style = $unique_id != 'new' ? 'display: block' : 'display: none'; ?>" class="tab">Address</a></li>
											<li><a href="#order" data-toggle="tab" style="<?php echo $style = $unique_id != 'new' ? 'display: block' : 'display: none'; ?>" class="tab">Order</a></li>
										</ul>

										<div class="tab-content">
											<div class="tab-pane has-padding active" id="account_information">

												<form action="#" method="post" id="add_customer">
              							<input type="hidden" name="unique_id" class="unique" value="<?php echo $unique_id = isset($unique_id) && !empty($unique_id) ? $unique_id : 'new'; ?>">

              							
						                <div class="modal-body" id="customer-body">
						                    <div class="form-group">
						                        <div class="row">
						                            <div class="col-sm-4">
						                                <label>Name</label>
						                                <input type="text" placeholder="Name" class="form-control name" name="name" id="name" value="<?php echo $name = isset($customer['name'])  && !empty($customer['name']) ? $customer['name'] : set_value('name');
						                                 ?>">
						                            </div>
						                            <div class="col-sm-4">
						                                <label>Mobile</label>
						                                <input type="number" minlength="10"  maxlength="10" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile = isset($customer['mobile']) && !empty($customer['mobile']) ? $customer['mobile'] : set_value('mobile');
						                                 ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
						                            </div>
						                            
						                            <div class="col-sm-4">
						                                <label>Email</label>
						                                <input type="text" placeholder="Email" class="form-control email" name="email" id="email" value="<?php echo $email = isset($customer['email']) && !empty($customer['email']) ? $customer['email'] : set_value('email');
						                                 ?>">
						                            </div>
						                        </div>
						                    </div>


						                    <div class="form-group" id="password_section">
						                        <div class="row">
						                          
						                            <div class="col-sm-4">
						                                <label>Password</label>
						                                <input type="password" placeholder="Password" class="form-control password" name="password" id="password" value="<?php echo $password = isset($customer['password']) && !empty($customer['password']) ? $customer['password'] : set_value('name');
						                                 ?>">
						                            </div>
						                            <div class="col-sm-4">
						                                <label>Confirm Password</label>
						                                <input type="password" placeholder="Confirm Password" class="form-control confirm_password" name="confirm_password" id="confirm_password" value="<?php echo $confirm_password = isset($customer['password']) && !empty($customer['password']) ? $customer['password'] : set_value('confirm_password');
						                                 ?>">
						                            </div>
						                            <div class="col-sm-4">
						                                <label>&nbsp;</label><br>
						                                <button class="btn btn-primary auto_generate" type="button">Auto generate Password</button>
						                            </div>
						                        </div>
						                    </div>

						                </div>

						                <div class="modal-footer">
						                    <button type="submit" class="btn btn-primary" id="add_customer"><?php if(empty($this->uri->segment(3))){ echo 'Add'; }else{ echo 'Update'; }?> Customer</button>
						  
						                </div>
						            </form>
											</div>

											<div class="tab-pane has-padding" id="address">
												<div class="panel-heading">
						                            <a class="btn btn-sm btn-success" href="#" data-target="#add_modal" data-toggle="modal"><i class="icon-home4"></i> Add Address</a>
						                            <a class="btn btn-sm btn-danger delete_all" href="#" ><i class="icon-bin"></i> Delete</a>
						                        </div>
												<table class="table" id="customer_list">
					                            <thead>
					                                <tr>
					                                    <th><input type="checkbox" name="select_all" value="" id="select-all"></th>
					                                    <th>Sr. No.</th>
					                                    <th>Type</th>
					                                    <th>Street Address</th>
					                                    <th>City</th>
					                                    <th>Pincode</th>
					                                    <th>Created At</th>
					                                    <th>Action</th>
					                                </tr>
					                            </thead>
					                            <tbody>
					                           		<?php if(isset($address)){
					                           			$i = 1;
					                           		foreach($address as $a){ ?>
					                           		<tr>
					                           			<td><input type="checkbox" value="<?php echo $a['id'] ?>" class="check"></td>
					                           			<td><?php echo $i; ?></td>
					                           			<td><?php echo $a['type'] ?></td>
					                           			<td><?php echo $a['street_address'] ?></td>
					                           			
					                           			<td><?php echo $a['city'] ?></td>
					                           			<td><?php echo $a['pincode'] ?></td>
					                           			<td><?php echo $a['created_at'] ?></td>
					                           			<td class="text-center">
				                                        <ul class="icons-list">
				                                            <li class="dropdown">
				                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				                                                    <i class="icon-menu9"></i>
				                                                </a>

				                                                <ul class="dropdown-menu dropdown-menu-right">
				                                                    <li><a href="#" id="<?php echo $a['id'] ?>" data-toggle="modal" data-target="#edit_modal" class="edit_address"><i class="icon-file-pdf"></i> Edit</a></li>
				                                                    <li><a href="#" id="<?php echo $a['id']?>" class="delete_address"><i class="icon-file-excel"></i> Delete</a></li>
				                                                </ul>
				                                            </li>
				                                        </ul>
				                                    </td>					                           		</tr>
					                           		<?php } } ?>
					                            </tbody>
					                        </table>
											</div>

											<div class="tab-pane has-padding" id="order">
												<table class="table" id="customer_list">
					                            <thead>
					                                <tr>
					                                    
					                                    <th>Sr. No.</th>
					                                    <th>Order Id</th>
					                                    <th>Amount</th>
					                                    <th>Address</th>
					                                    <th>Order Status</th>
					                                    <th>Payment Status</th>
					                                    <th>Created At</th>
					                                 
					                                </tr>
					                            </thead>
					                            <tbody>
					                           		<?php if(isset($order)){
					                           			$i = 0;
					                           		foreach($order as $o){ ?>
					                           		<tr>
					                           			
					                           			<td><?php echo $i; ?></td>
					                           			<td><?php echo $o['id'] ?></td>
					                           			<td><?php echo $o['final_total'] ?></td>
					                           			<td><?php echo $o['address'] ?></td>
					                           			<td>
					                           				<?php if($o['status'] == '1'){
					                           					echo '<button class="btn btn-sm btn-warning">Pending</button>';
					                           				}else if($o['status'] == '2'){
					                           					echo '<button class="btn btn-sm btn-success">Completed</button>';
					                           				}else{	
					                           					echo '<button class="btn btn-danger btn-sm">Cancel</button>';
					                           				} ?>
					                           			</td>
					                           			<td>>
					                           				<?php if($o['payment_status'] == '1'){
					                           					echo '<button class="btn btn-sm btn-warning">Complete</button>';
					                           				}else if($o['payment_status'] == '2'){
					                           					echo '<button class="btn btn-sm btn-success">Partial</button>';
					                           				}else{	
					                           					echo '<button class="btn btn-danger btn-sm">No Payment</button>';
					                           				} ?></td>
					                           			<td></td>
					                           		</tr>
					                           		<?php } } ?>
					                            </tbody>
					                        </table>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /bordered tab content -->




					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div>
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
<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Address form</h5>
            </div>

            <form action="#" method="post" id="add_address">
              	<input type="hidden" name="unique_id" class="unique_id" value="<?php echo $unique_id = isset($unique_id) && !empty($unique_id) ? $unique_id : 'new'; ?>">
                <div class="modal-body" id="customer-body">

                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                                <label>Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Street Address</label>
                                <input type="text" placeholder="Street Address" class="form-control" name="street_address" id="street_address">
                            </div>
                            <div class="col-sm-4">
                                <label>City</label>
                                <input type="text" placeholder="City" class="form-control" name="city" id="city">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          
                          <div class="col-sm-4">
                                <label>Pincode</label>
                                <input type="text" placeholder="Pincode" minlength="6"  maxlength="6" class="form-control" name="pincode" id="pincode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
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
                    <button type="submit" class="btn btn-primary" id="add_customer">Add Address</button>
  
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Address form</h5>
            </div>

            <form action="#" method="post" id="update_address">
              	<input type="hidden" name="address_id" class="address_id" value="">
                <div class="modal-body" id="customer-body">

                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                                <label>Type</label>
                                <select class="form-control type" name="type">
                                    <option value="home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Street Address</label>
                                <input type="text" placeholder="Street Address" class="form-control street_address" name="street_address">
                            </div>
                            <div class="col-sm-4">
                                <label>City</label>
                                <input type="text" placeholder="City" class="form-control city" name="city">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          
                          <div class="col-sm-4">
                                <label>Pincode</label>
                                <input type="text" placeholder="Pincode" minlength="6"  maxlength="6" class="form-control pincode" name="pincode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            
                            <div class="col-sm-4">
                                <label>Is Default</label>
                                <select class="form-control select is_default" name="is_default" > 
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Address</button>
  
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
	$('#add_customer').submit(function(e) {
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
                    var unique_id = obj.unique_id;
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        window.location.href = base_url+'Customer/customerForm/'+unique_id;
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                       window.location.href = base_url+'Customer/customerForm/'+unique_id;
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            if(key == 'status'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                            
                        });
                    }

                }

            });

        });

	$('#add_address').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Customer/addAddress',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        window.location.href = base_url+'Customer/customerForm/'+obj.unique_id;
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {

                            var element = $('#' + key);
                            if(key == 'status'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                        });
                    }

                }

            });

        });

	$(document).on('click','.edit_address', function() {
            var base_url = $('#base_url').val();
            var id = $(this).attr('id');
   			
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Customer/getAddressDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){

                        $('.address_id').val(obj.data.id);
                        $('.type').val(obj.data.type);
                        $('.street_address').val(obj.data.street_address);
                        $('.pincode').val(obj.data.pincode);
                        $('.city').val(obj.data.city);
                        $('.is_default').val(obj.data.is_default);

                    }else{
                      //  alert('No Customer found');
                    }
                }
            });
        });

        $('#update_address').submit(function(e) {
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
                        
                    	alert(obj.message);
                    	window.location.reload();
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('.' + key);
                            element.closest('.form-control').after(value);
                            
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
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


</script>
