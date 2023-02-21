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
                            <form action="<?= base_url('orders/update_order_status/' . $order['id']) ?>" method="post">
                                <select class="form-select" name="order_status" id="order_status" aria-label="Default select example">
                                    <option value="Order in process" <?php if($order['status'] == "Order in process") echo "selected"; ?>>Order in process</option>
                                    <option value="Shipped" <?php if($order['status'] == "Shipped") echo "selected"; ?>>Shipped</option>
                                    <option value="Cancelled" <?php if($order['status'] == "Cancelled") echo "selected"; ?>>Cancelled</option>
                                </select>
                            </form>
						</td>
					</tr>
<?php
		}
	}
?>