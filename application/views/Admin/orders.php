<?php 
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
?>
		<form action="<?= base_url('orders/filter_order_display/1') ?>" id="search" method="post">
			<div class="mb-3 row">
				<!-----Search------------------------------------>
				<div class="col-6 col-md-3">
					<div class="input-group">
						<input type="text" class="form-control search_order" placeholder="Search Customer Name or Order ID" name="search_order"/>
					</div>
				</div>
				<div class="col-0 col-md-7 space"></div>
				<div class="col-6 col-md-2">
					<!-----Status Sort----------------------------------->
					<select class="form-select" id="filter_order" name="filter_order" aria-label="Default select example">
						<option selected>Show all</option>
						<option value="Order in process">Order in process</option>
						<option value="Shipped">Shipped</option>
						<option value="Cancelled">Cancelled</option>
					</select>
				</div>
			</div>
		</form>
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

				</tbody>
			</table>
		</div>
        <!-----Pagination----------------------------------->
		<div class="page">
		</div>
	</body>
</html>
