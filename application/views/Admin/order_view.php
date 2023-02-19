<?php 
	$billing_details = json_decode($order['billing_address'], true);
	$shipping_details = json_decode($order['shipping_address'], true);
	$sub_total = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Orders</title>
		<!--Google fonts-->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;500;900&display=swap" rel="stylesheet" />
		<!--Jquery library-->
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		<!-- bootstrap library-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- font awesome library-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
		<!-- main style -->
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/order_view.less') ?>" />
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/admin_nav.less') ?>">
		<!-- less library -->
		<script src="https://cdn.jsdelivr.net/npm/less@4"></script>
	</head>
	<body>
		<!-------Navigation------------------------->
		<nav class="container">
			<div class="row w-100 align-items-center p-4 top-nav navbar fixed-top">
	
				<div class="col-3 col-md-2">
					<a href="#" class="text-dark w-100 dash">Dashboard</a>
				</div>
				
				<div class="col-2 col-md-1">
					<a href="/Admin/orders" class="text-dark w-100">Orders</a>
				</div>
				
				<div class="col-2 col-md-1">
					<a href="/Admin/admin_products" class="text-dark w-100">Products</a>
				</div>
	
				<div class="col text-end ">
					<a href="../Users/login.html" class="text-dark w-100">Log off</a>
				</div>
			</div>
		</nav>
		<!-------------Order Info---------------->
		<div class="row gx-4">
			<div class="col-9 col-md-3 m-auto mb-3 bg-white p-4">
				<p class="mb-4">Order ID: <?= $order['id'] ?></p>
				<!-------------Shipping Info---------------->
				<p class="fw-bold">Customer shipping info:</p>
				<p>Name: <?= $billing_details['first_name'] . ' ' . $billing_details['last_name'] ?></p>
				<p>Address: <?= $billing_details['address'] ?></p>
				<p>City: <?= $billing_details['city'] ?></p>
				<p>State: <?= $billing_details['state'] ?></p>
				<p>Zip: <?= $billing_details['zip_code'] ?></p>
				<!-------------Billing Info---------------->
				<p class="fw-bold">Customer Billing info:</p>
				<p>Name: <?= $shipping_details['first_name'] . ' ' . $shipping_details['last_name'] ?></p>
				<p>Address: <?= $shipping_details['address'] ?></p>
				<p>City: <?= $shipping_details['city'] ?></p>
				<p>State: <?= $shipping_details['state'] ?></p>
				<p>Zip: <?= $shipping_details['zip_code'] ?></p>
			</div>
			<div class="col row gy-0">
				<!-------------Ordered Items---------------->
				<div class="table-container col-12 mb-0">
					<table class="table table-light table-striped">
						<thead>
							<tr>
								<th scope="col-1">ID</th>
								<th scope="col-1">Item</th>
								<th scope="col-1">Price</th>
								<th scope="col-1">Quantity</th>
								<th scope="col-1">Total</th>
							</tr>
						</thead>
						<tbody>
<?php 
	if(!empty($order_details)){
		foreach($order_details as $order_detail){
			$sub_total += ($order_detail['price'] * $order_detail['quantity']);
?>
							<tr>
								<td><?= $order_detail['product_id'] ?></td>
								<td><?= $order_detail['product_name'] ?></td>
								<td>$<?= number_format($order_detail['price'], 2) ?></td>
								<td><?= $order_detail['quantity'] ?></td>
								<td>$<?= number_format($order_detail['total'], 2) ?></td>
							</tr>
<?php
		}
	}
?>
						</tbody>
					</table>
				</div>
				<!-------------Status---------------->
				<div class="order_info col-12 row">
					<div class="col-12 col-md-6">
						<p class="bg-success text-light fs-3 text-center w-50 m-auto mb-3">Status: shipped</p>
					</div>
					<!-------------Total---------------->
					<div class="col-12 col-md-6">
						<div class="w-50 m-auto fs-5 text-end">
							<p>Subtotal: $<?= number_format($sub_total, 2) ?></p>
							<p>Shipping: $<?= number_format($order['shipping_fee'], 2) ?></p>
							<p>Total Price: $<?= number_format($sub_total + $order['shipping_fee'], 2) ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
