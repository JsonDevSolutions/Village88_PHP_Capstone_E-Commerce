<?php
	$this->load->view('partials/client_header_section');
    $this->load->view('partials/client_side_navigation');
?>
    <div class="container-fluid p-4">
<?php
 if(!empty($orders)){
    foreach($orders as $order){
        $billing_details = json_decode($order['billing_address'], true);
        $billing_address = $billing_details['address'] . ' ' . $billing_details['address_two'] . ' ' . $billing_details['city'] . ' ' . $billing_details['state'] . ' ' . $billing_details['zip_code'];
        $order_items = json_decode($order['order_items'], true);
?>
        <div class="row bg-dark text-white p-2">
            <div class="col-md-2">
                <p class="h5">Order ID: <span class="fw-bold"><?= $order['id'] ?></span></p>
            </div>
            <div class="col-md-2">
                <p class="h5">Date:<span class="fw-bold"><?= $order['order_date'] ?></span></p>
            </div>
            <div class="col-md-4">
                <p class="h5">Address: <span class="fw-bold"><?= $billing_address ?></span></p>
            </div>
            <div class="col-md-2">
                <p class="h5">Total: <span class="fw-bold">$ <?= $order['total_amount'] ?></span></p>
            </div>
            <div class="col-md-2">
<?php
	if($order['status'] == 'Order in process'){
?>
                        <p class="h5 bg-info text-dark p-1">Status: <span class="fw-bold">Order in Process</span></p>
<?php
	}elseif($order['status'] == 'Shipped'){
?>
						<p class="h5 bg-success text-white p-1">Status: <span class="fw-bold">Shipped</span></p>
<?php
	}elseif($order['status'] == 'Cancelled'){
?>
						<p class="h5 bg-danger text-white p-1">Status: <span class="fw-bold">Cancelled</span></p>
<?php
	}
?>
            </div>
        </div>
        <div class="row mt-2 mb-4 border border-dark">
            <p class="h6">Order Items</p>
            <table class="table table-striped-columns align-middle">
                <thead>
                    <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
<?php
	foreach($order_items as $product_id => $product){
?>
                    <tr>
                        <td><?= $product[0] ?></td>
                        <td>$<?= number_format($product[2], 2) ?></td>
                        <td><?= $product['1'] ?></td>
                        <td>$<?= number_format(($product[2] * $product['1']), 2) ?></td>
                    </tr>
<?php
	}
?>
                </tbody>
            </table>
        </div>
<?php
    }
 }else{
?>
        <div class="row bg-danger text-center text-white p-2">
            <p class="h3">No order history</p>
        </div>
<?php
 }
?>
    </div>
</body>
</html>