
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style type="text/css">
		.table td, .table th{
			padding: 5px !important;
		}
	</style>
</head>
<body>





						

						
								<table>
								<tbody>
								<tr>
									<td><strong><h4>Order No#<?php echo $customer['invoice_no']?><br>
									Date : <?php echo date('d/m/Y'); ?></h4></strong></td>
								</tr>
								<tr>
								<td style="width:400px">
									<h5><strong>From :</strong></h5>
								<!-- <img src="<?php echo base_url() ?>uploads/1.png" class="img-responsive" width="120px" height="50px"> -->
								<p><strong>KIPSC AR-AV Eletronics Pvt Ltd</strong><br>
								Gala No.104,Bldg. A-1, Shubh Innov8,<br>Opp. Chinchpada Bus Stop,<br>Vasai (E),401208.<br>+91 8446056051 / 7775039995</p>
								</div>
								</td>
								<td style="width: 400px;vertical-align: baseline;">
								
								<h5><strong>To :</strong></h5>
								<p><strong><?php echo ucwords(strtolower($customer['name'])) ?></strong><br>
								<?php 
											$address = wordwrap(ucwords(strtolower($customer['address'])),35,"<br>\n");
											echo $address ?><br>
								<strong><?php echo ucfirst($customer['contact_person']) ?><br>
							   <?php echo $customer['mobile'] ?></strong></p>
								
								</td>
								</tr>
								</tbody>
								</table>
								<table class="table table-bordered">
								  <thead>
								    <tr class="text-center">
								      <th scope="col" width="25px">Sr No</th>
								      <th scope="col" width="100px">Product Code</th>
								      <th scope="col" width="300px">Description</th>
								      <th scope="col" width="50px">MRP</th>
								      <th scope="col" width="25px">Qty</th>
								      <?php if($client_contact_id){?>
								      <th scope="col" width="25px">Discount</th>
								  	  <?php } ?>
								      <th scope="col" width="50px">Amount</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php if(isset($order_details) && !empty($order_details)){ 
								  	$i = 1;
								  	foreach($order_details as $row){
								  	?>
								    <tr class="text-center">
								      <td width="25px"><?php echo $i; ?></td>
								      <td width="100px"><?php echo $row['model_no'] ?></td>
								      <td width="300px"><?php echo $row['description'] ?></td>
								      <td width="50px"><?php echo $row['mrp'] ?></td>
								      <td width="25px"><?php echo $row['qty'] ?></td>
								      <?php if($client_contact_id){?>
								      <td width="25px"><?php echo $row['discount'].'%' ?></td>
								      <?php } ?>
								      <td width="50px"><?php echo $subtotal = calculate_total($row['mrp'],$row['qty'],$row['discount']) ?></td>
								    </tr>
								    <?php $i++; } } ?>
								    <tr class="text-center">
								    	<td colspan="<?php echo $a = $client_contact_id == true ? 5 :4;?>"></td>
								    	<td>Total</td>
								    	<td><?php echo number_format($customer['total'],2) ?></td>
								    </tr>
								  </tbody>
								</table>

			
							
						<div class="panel-body">
							<p><strong>Note : Freight/ Delivery charges as actual</strong></p>
							<p class="text-center">Thank you for choosing us.It was a pleasure to have worked with you.</p>
						</div>
					

</body>
</html>

