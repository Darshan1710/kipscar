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
	<script src="<?php echo base_url() ?>js/plugins/forms/validation/validate.min.js"></script>
	<script src="<?php echo base_url() ?>js/plugins/forms/styling/uniform.min.js"></script>

	<script src="<?php echo base_url() ?>js/app.js"></script>

	<!-- /theme JS files -->

</head>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
<body class="login-container">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content pb-20">

					<!-- Form with validation -->
					<form action="#" class="form-validate" method="post" id="delete">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Delete to your account <small class="display-block alert-success" id="message"></small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								<input type="text" class="form-control" placeholder="Please enter mobile number" name="mobile" id="mobile" value="<?php echo set_value('mobile')?>">
								<?php echo form_error('mobile'); ?>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="otp" class="form-control" placeholder="OTP" name="otp" id="otp" value="<?php echo set_value('otp')?>" disabled>
								<?php echo form_error('otp')?>
							</div>

							<!-- <div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" checked="checked">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="#">Forgot password?</a>
									</div>
								</div>
							</div> -->

							<div class="form-group">
								<button type="submit" class="btn bg-blue btn-block">Submit <i class="icon-arrow-right14 position-right"></i></button>
							</div>

							<span class="help-block text-center no-margin">By continuing, We will delete Name,Mobile,Email,OS version details from our system permanently</a></span>
						</div>
					</form>
					<!-- /form with validation -->

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
	$('#delete').submit(function(e) {
			e.preventDefault();
			var otp = $('#otp').val();
			var mobile = $('#mobile').val();
			if(!mobile){
				$('#message').html('Please enter mobile number');
			}
			if(!otp && mobile){
				$('#otp').removeAttr('disabled');
				$('#message').html('OTP has been sent to your register mobile number');

				var form_data = new FormData($(this)[0]);
	            var base_url = $('#base_url').val();
	            $.ajax({
	                type: 'post',
	                data: form_data,
	                processData: false,
	                contentType: false,
	                url: base_url + 'Admin/sendOTP',
	                success: function(data) {
	                    var obj = $.parseJSON(data);
	                    $('.error').remove();
	                    if (!obj.error) {
	                        alert(obj.message);
	                    } else if (obj.errCode == 3) {
	                        
	                        $.each(obj.message, function(key, value) {
	                            var element = $('#' + key);
	                                element.closest('.form-control').after(value);
	                            
	                        });
	                    }

	                }

	            });
			}else if(otp && mobile){
				
	            var form_data = new FormData($(this)[0]);
	            var base_url = $('#base_url').val();
	            $.ajax({
	                type: 'post',
	                data: form_data,
	                processData: false,
	                contentType: false,
	                url: base_url + 'Admin/deleteUser',
	                success: function(data) {
	                    var obj = $.parseJSON(data);
	                    $('.error').remove();
	                    if (!obj.error) {
	                       alert(obj.message);
	                       $('#message').html('User with '+mobile+ 'is permanently deleted');
	                    }else if (obj.errCode == 3) {
	                        $.each(obj.message, function(key, value) {
	                            var element = $('#' + key);
	                            element.closest('.form-control').after(value); 
	                            
	                        });
	                    }

	                }

	            });
			}
            

        });
</script>