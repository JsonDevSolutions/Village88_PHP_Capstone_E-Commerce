<?php 
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
?>

		<div class="mb-3 row">
            <!-----Search------------------------------------>
			<div class="col-6 col-md-3">
				<div class="input-group">
					<button class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></button>
					<input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="basic-addon1" />
				</div>
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
						<th class="col-1" scope="col-1">Order id</th>
						<th class="col-2" scope="col-1">Name</th>
						<th class="col-1" scope="col-1">Date</th>
						<th class="col" scope="col-1">Billing address</th>
						<th class="col-1" scope="col-1">Total</th>
						<th class="col-2" scope="col-1">status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><a href="">100</a></td>
						<td>Bob</td>
						<td>9/6/2014</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
						<td>$143</td>
						<td>
							<select class="form-select" aria-label="Default select example">
								<option value="1">Order in process</option>
								<option value="2">Shipped</option>
								<option value="3">Cancelled</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
        <!-----Pagination----------------------------------->
		<div class="page">
            <a href="#"><</a><a href="#"><<</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a><a href="#">9</a><a href="#">10</a><a href="#">></a><a href="#">>></a>
		</div>
	</body>
</html>
