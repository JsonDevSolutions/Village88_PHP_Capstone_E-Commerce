

<?php 
	$order_items = json_decode($order['order_items'], true);
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
	$billing_details = json_decode($order['billing_address'], true);
	$shipping_details = json_decode($order['shipping_address'], true);
	$sub_total = 0;
?>
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
