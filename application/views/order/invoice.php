<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Alphacore</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
	<script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url() ?>js/plugins/editors/ckeditor/ckeditor.js"></script>

	<script src="<?php echo base_url() ?>js/app.js"></script>
	<script src="<?php echo base_url() ?>js/demo_pages/invoice_template.js"></script>
	<!-- /theme JS files -->
	<style>
@media print {
.header, .hide { visibility: hidden }
}
</style>
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
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
	

							<ul class="breadcrumb position-right">
								<li><a href="#">Home</a></li>
								<li><a href="#">Invoices</a></li>
								<li class="active">Templates</li>
							</ul>
						</div>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Invoice template -->
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Invoice</h6>
							<div class="heading-elements">
								<button type="button" class="btn btn-default btn-xs heading-btn"><i class="icon-file-check position-left"></i> Save</button>
								<button type="button" class="btn btn-default btn-xs heading-btn"  id="printButton"><i class="icon-printer position-left"></i> Print</button>
		                	</div>
						</div>

						<div id="DivIdToPrint">
						<div class="panel-body no-padding-bottom">
							<div style="margin-left: -10px;margin-right: -10px;">
								<div style="width: 50%;float: left;position: relative;min-height: 1px;padding-left: 10px;padding-right: 10px;">
									<img src="<?php echo base_url() ?>uploads/1.png" alt="" style="width: 120px;">
		 							<ul style="padding-left: 0;list-style: none;">
										<li style="margin-top: 1px;font-size:12px;">Gala No.101,<br>Bldg. A-1, Shubh Innov8,<br>Opp. Chinchpada Bus Stop,<br>Vasai (E),401301.</li>
										<!-- <li style="margin-top: 1px;font-size:12px;">hemant@sevenelevenclub.in</li> -->
										<li style="margin-top: 1px;font-size:12px;">+91 93249 07490</li>
									</ul>
								</div>

								<div class="col-sm-6">
									<div style="float: right;text-align: right;padding-right: 20px;">
										<h5 style="font-weight: 500;text-transform: uppercase;letter-spacing: -.015em;font-size: 17px;font-family: inherit;font-weight: 400;color: inherit;margin-bottom: 0px;">Invoice #<?php echo $customer['invoice_no']?></h5>
										<ul style="padding-left: 0;list-style: none;float: right;text-align: right;">
											<li >Date: <span style="font-weight: 500;font-size:12px;"><?php echo date('M d , Y'); ?></span></li>
											<li style="font-size:14px;"><b><span style="font-size:15px;"><?php echo ucwords(strtolower($customer['name'])) ?></span></b></li>
											
											<li style="font-size:12px;"><?php 
											$address = wordwrap(ucwords(strtolower($customer['address'])),20,"<br>\n");
											echo $address ?></li>
											
											<li style="font-size:12px;"><strong style="margin-top: 3px;"><?php echo $customer['mobile'] ?></strong></li>
											<!-- <li style="margin-top: 3px;">Due date: <span style="font-weight: 500;">May 12, 2015</span></li> -->
										</ul>
									</div>
								</div>
							</div>
<!-- 
							<div style="margin-left: -10px;margin-right: -10px;">
								<div  style="margin-bottom: 20px!important;width: 75%;float: left;position: relative;min-height: 1px;padding-left: 10px;padding-right: 10px;">
									<span style="color: #999;">Invoice To:</span>
		 							<ul  style="padding-left: 0;list-style: none;">
										<li style="margin-top: 3px;"><h5><?php echo $customer['name'] ?></h5></li>
										<li style="margin-top: 3px;"><span class="text-semibold" style="font-weight: 500;margin-top: 3px;"><?php echo $customer['mobile'] ?></span></li>
										<li style="margin-top: 3px;"><?php echo $customer['address'] ?></li>
										<li style="margin-top: 3px;"><a href="#"><?php echo $customer['email'] ?></a></li>
									</ul>
								</div>

							</div> -->
						</div>
	
						<div  style="border-top: 1px solid #ddd;border: 0;margin-bottom: 0;overflow-x: auto;min-height: .01%;width: 100%">
						    <table  style="margin-bottom: 0;width: 100%;max-width: 100%;background-color: transparent;border-collapse: collapse;border-spacing: 0;">
						        <thead>
						            <tr style="transition: background-color ease-in-out .15s;">
						                <th style="border-top: 0;padding: 5px 20px;border-bottom: 1px solid #bbb;vertical-align: middle;font-weight: 500;text-align: left;display: table-cell;font-size:12px;">Product Name</th>
						                <th  style="border-top: 0;padding: 5px 20px;border-bottom: 1px solid #bbb;vertical-align: middle;font-weight: 500;text-align: left;display: table-cell;font-size:12px;width: 8.33333333%;min-height: 1px;">Unit Price</th>
						                <th  style="border-top: 0;padding: 5px 20px;border-bottom: 1px solid #bbb;vertical-align: middle;font-weight: 500;text-align: left;display: table-cell;font-size:12px;width: 8.33333333%;min-height: 1px;">Qty</th>
						                <th  style="border-top: 0;padding: 5px 20px;border-bottom: 1px solid #bbb;vertical-align: middle;font-weight: 500;text-align: left;display: table-cell;font-size:12px; width: 8.33333333%;min-height: 1px;">Price</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php foreach($order_details as $row){ ?>
						            <tr style="transition: background-color ease-in-out .15s;">
						                <td style="padding: 5px 10px;vertical-align: middle;transition: background-color ease-in-out .15s;border-top: 1px solid #ddd;">
						                	<h6 class="no-margin" style="font-family: inherit;font-weight: 400;color: inherit;margin: 0!important;font-size: 12px;letter-spacing: -.015em;"><?php echo $row['model_no'] ?></h6>
						                	<!-- <span class="text-muted">One morning, when Gregor Samsa woke from troubled.</span> -->
					                	</td>
						                <td style="padding: 5px 20px;vertical-align: middle;transition: background-color ease-in-out .15s;border-top: 1px solid #ddd;font-size: 12px"><?php echo round($row['mrp'] / $row['qty'],2) ?></td>
						                <td style="padding: 5px 20px;vertical-align: middle;transition: background-color ease-in-out .15s;border-top: 1px solid #ddd;font-size: 12px"><?php echo $row['qty'] ?></td>
						                <td style="padding: 5px 20px;vertical-align: middle;transition: background-color ease-in-out .15s;border-top: 1px solid #ddd;font-size: 12px"><?php echo $row['mrp'] ?></td>
						              
						            </tr>
						        <?php } ?>
						        </tbody>
						    </table>
						</div>

						<div class="panel-body">
							<div class="row invoice-payment">


								<div class="col-sm-6" style="float: right">
									<div class="content-group">
										<!-- <h6>Total due</h6> -->
										<div class="table-responsive no-border">
											<table class="table">
												<tbody>
													<!-- <tr>
														<th style="vertical-align: middle;padding: 12px 20px;line-height: 1.5384616;vertical-align: top;border-top: 1px solid #ddd;font-weight: 500;">Subtotal:</th>
														<td style="    vertical-align: middle;padding: 12px 20px;line-height: 1.5384616;vertical-align: top;border-top: 1px solid #ddd;text-align: right;">$7,000</td>
													</tr> -->
													<!-- <tr>
														<th style="vertical-align: middle;padding: 12px 20px;line-height: 1.5384616;vertical-align: top;border-top: 1px solid #ddd;font-weight: 500;">Tax: <span style="font-weight: 400;">(25%)</span></th>
														<td style="text-align: right;">$1,750</td>
													</tr> -->
													<tr>
														<th style="vertical-align: middle;padding: 12px 20px;line-height: 1.5384616;vertical-align: top;border-top: 1px solid #ddd;font-weight: 500;">Sub Total:</th>
														<td style="vertical-align: middle;padding: 0px 20px;line-height: 1.5384616;vertical-align: top;border-top: 1px solid #ddd;color: #2196f3!important;text-align: right;"><h5 style="    font-weight: 500;font-size: 17px;letter-spacing: -.015em;"><?php echo $customer['total'] ?></h5></td>
													</tr>
													
													
													
												</tbody>
											</table>
										</div>

									</div>
								</div>
							</div>
							<br>
						<!-- 	<h6>Other information</h6> -->
							<p class="text-muted" style="font-size: 12px;">Thank you for choosing us.It was a pleasure to have worked with you.</p>
						</div>
						</div>
					</div>
					<!-- /invoice template -->




					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">All rights reserved by</a> by <a href="Alphacore.in" target="_blank">Alphacore.in</a>
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
<script type="text/javascript">
	$('#printButton').on('click',function(){

		var divToPrint=document.getElementById('DivIdToPrint');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

		  newWin.document.close();

		  setTimeout(function(){newWin.close();},10);

		// $('#DivIdToPrint').printThis();
	});

</script>

