    <div class="table-container">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th class="col" scope="col-1">Item</th>
                    <th class="col-2" scope="col-1">Price</th>
                    <th class="col-2" scope="col-1">Quantity</th>
                    <th class="col-2" scope="col-1">Total</th>
                </tr>
            </thead>
            <tbody>
<?php
    $total = 0;
    if(!empty($products) && $user == 'guest'){
        foreach($products as $product){
            $total += $product['price'] * $cart[$product['id']];
?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= '$' . number_format($product['price'], 2) ?></td>
                    <td>
                        <span><?= $cart[$product['id']] ?></span>
                        <form action="<?= base_url('carts/remove_cart/' . $product['id']) ?>" subaction="<?= base_url('carts/update_item_quantity/' . $product['id']) ?>" method="post" class="ms-5" style="display:inline-block;">
                                <button class="btn btn-danger btn-sm" id="btn_delete_product" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn btn-light btn-sm" id="btn_edit_quantity" type="submit">
                                    <i class='fa fa-edit' style='color: red'></i>
                                </button>
                        </form>
                    </td>
                    <td><?= '$' . number_format(($product['price'] * $cart[$product['id']]), 2) ?></td>
                </tr>
<?php
        }
    }elseif(!empty($products) && $user == 'registered_user'){
        foreach($products as $product){
            $total += $product['total'];
?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= '$' . number_format($product['price'], 2) ?></td>
                    <td>
                        <span><?= $product['quantity'] ?></span>
                        <form action="<?= base_url('carts/remove_cart/' . $product['id']) ?>" subaction="<?= base_url('carts/update_item_quantity/' . $product['id']) ?>" method="post" class="ms-5" style="display:inline-block;">
                                <button class="btn btn-danger btn-sm" id="btn_delete_product" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn btn-light btn-sm" id="btn_edit_quantity" type="submit">
                                    <i class='fa fa-edit' style='color: red'></i>
                                </button>
                        </form>
                    </td>
                    <td><?= '$' . number_format($product['total'], 2) ?></td>
                </tr>
<?php
        }
    }
?>
            </tbody>
        </table>
    </div>
    <!---------------------Total-------------------------------->
    <div class="total mb-5 text-light text-end">
        <p class="text-end">TOTAL: $<?= number_format($total, 2) ?></p>
        <a href="<?= base_url('products/show_all/1') ?>" class="btn btn-success">Continue Shopping</a>
    </div>
    <!---------------------Information-------------------------------->
    <form action="<?= base_url('orders/place_order') ?>" method="post" autocomplete="off" class="row g-3 needs-validation">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="container text-light">
            <div class="row">
                <!---------------------Shipping information-------------------------------->
                <div class="col-12 col-lg-6">
                    <h2 class="row">Shipping Information</h2>
                    <!---------------------Shipping Input fields------------------------------->
                    <div class="row">
                        <p class="col-4">First name: </p>
                        <input class="col-8" id="shipping_first_name" type="text" name="first_name[]" required>
                    </div>

                    <div class="row">
                        <p class="col-4">Last name: </p>
                        <input class="col-8" id="shipping_last_name" type="text" name="last_name[]" required>
                    </div>
                    
                    <div class="row">
                        <p class="col-4">Address: </p>
                        <input class="col-8" id="shipping_address_one" type="text" name="address_one[]">
                    </div>

                    <div class="row">
                        <p class="col-4">Address 2: </p>
                        <input class="col-8" id="shipping_address_two" type="text" name="address_two[]">
                    </div>

                    <div class="row">
                        <p class="col-4">City: </p>
                        <input class="col-8" id="shipping_city" type="text" name="city[]">
                    </div>

                    <div class="row">
                        <p class="col-4">State: </p>
                        <input class="col-8" id="shipping_state" type="text"  name="state[]">
                    </div>

                    <div class="row">
                        <p class="col-4">Zip code: </p>
                        <input class="col-8" id="shipping_zip_code" type="text" name="zip_code[]">
                    </div>
                </div>

                <div class="col-12 col-lg-6" id = "billing">
                    <!---------------------Billing Information-------------------------------->
                    <h2 class="row">Billing Information</h2>
                    <input class="form-check-input" type="checkbox" name="same_address" value="same" id="same_address">
                    <label class="form-check-label mb-1" for="same_address">Same as shipping</label> 
                    <!---------------------Billing Inputfields------------------------------->
                    <div class="row">
                        <p class="col-4">First name: </p>
                        <input class="col-8" id="billing_first_name" type="text" name="first_name[]">
                    </div>
                
                    <div class="row">
                        <p class="col-4">Last name: </p>
                        <input class="col-8" id="billing_last_name" type="text"  name="last_name[]">
                    </div>

                    <div class="row">
                        <p class="col-4">Address: </p>
                        <input class="col-8" id="billing_address_one" type="text" name="address_one[]">
                    </div>

                    <div class="row">
                        <p class="col-4">Address 2: </p>
                        <input class="col-8" id="billing_address_two" type="text" name="address_two[]">
                    </div>

                    <div class="row">
                        <p class="col-4">City: </p>
                        <input class="col-8" id="billing_city" type="text" name="city[]">
                    </div>

                    <div class="row">
                        <p class="col-4">State: </p>
                        <input class="col-8" type="text" id="billing_state"  name="state[]">
                    </div>
                    <div class="row">
                        <p class="col-4">Zip code: </p>
                        <input class="col-8" type="text" id="billing_zip_code" name="zip_code[]">
                    </div>
                    <div class="row">
                        <p class="col-4">Card: </p>
                        <input class="col-8" name="card_number" type="text">
                    </div>
                    
                    <div class="row">
                        <p class="col-4">Security code: </p>
                        <input class="col-8" name="security_code" type="text" placeholder = "CCV">
                    </div>

                    <div class="row">
                        <p class="col-4">Expiration: </p>
                        <input class="col-3" name ="month" type="text" placeholder = "Month">
                        <p class="col-2 text-center">/</p>
                        <input class="col-3" name="year" type="text" placeholder="Year">
                    </div>
                </div>
            </div>
        </div>
        <!---------------------Pay button------------------------------->
        <div class="pay text-end">
            <input type="submit" class="btn btn-primary mt-3" id = "pay" value="Pay $<?= number_format($total, 2) ?>">
        </div>
    </form>