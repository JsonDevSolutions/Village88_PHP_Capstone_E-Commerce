<?php 
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
?>

		<div class="mb-3 row">
            <!-----Search------------------------------------>
			<div class="col-6 col-md-3">
				<form action="orders/get_list" method="post">
					<div class="input-group">
						<input type="text" class="form-control search_order" placeholder="Search Customer Name or Order ID" name="search_order"/>
					</div>
				</form>
			</div>
			<div class="col-0 col-md-7 space"></div>
			<div class="col-6 col-md-2">
                <!-----Status Sort----------------------------------->
				<select class="form-select" aria-label="Default select example">
					<option selected>Show all</option>
					<option value="1">Order in process</option>
					<option value="2">Shipped</option>
					<option value="3">Cancelled</option>
				</select>
			</div>
		</div>
        <!-----Order List----------------------------------->
		<div class="table-container">
			<table class="table table-light table-striped">
				<thead>
					<tr>
						<th class="col-1" scope="col-1">Order ID</th>
						<th class="col-2" scope="col-1">Name</th>
						<th class="col-1" scope="col-1">Date</th>
						<th class="col" scope="col-1">Billing address</th>
						<th class="col-1" scope="col-1">Total</th>
						<th class="col-2" scope="col-1">status</th>
					</tr>
				</thead>
				<tbody>
<?php 
	if(!empty($orders)){
		foreach($orders as $order){
			$billing_details = json_decode($order['billing_address'], true);
			$customer_name = $billing_details['first_name'] . ' ' . $billing_details['last_name'];
			$billing_address = $billing_details['address'] . ' ' . $billing_details['address_two'] . ' ' . $billing_details['city'] . ' ' . $billing_details['state'] . ' ' . $billing_details['zip_code'];
?>
					<tr>
						<td><a href="<?= base_url('orders/show/' . $order['id']) ?>"><?= $order['id'] ?></a></td>
						<td><?= $customer_name ?></td>
						<td><?= $order['order_date'] ?></td>
						<td><?= $billing_address ?></td>
						<td>$<?= $order['total_amount'] ?></td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
<?php
		}
	}
?>
				</tbody>
			</table>
		</div>
        <!-----Pagination----------------------------------->
		<div class="page">
            <a href="#"><</a><a href="#"><<</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a><a href="#">9</a><a href="#">10</a><a href="#">></a><a href="#">>></a>
		</div>
	</body>
</html>
