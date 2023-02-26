
		<nav class="container">
			<div class="row w-100 align-items-center p-2 top-nav navbar fixed-top">
				<div class="col col-12 col-md-3 col-lg-2 col-xl-10">
					<a href="<?= base_url('/') ?>" class="slick"><span class="tech glow">BEST Deals</span> PH</a>
				</div>
				<div class="col-auto col-lg-1 mt-1 text-center">
					<a href="<?= base_url('carts') ?>" class="text-light w-100 cart"><i class="fas fa-shopping-cart"></i><div class="cart-count">0</div></a>
				</div>
<?php if($is_logged_in): ?>
				<!-- <div class="col-auto col-lg-1 text-center align-items-center">
					<a class="text-light" href="<?= base_url('users/logout_user') ?>">Logout</a>
				</div> -->
				<div class="col-auto col-lg-1 text-center align-items-center dropdown">
                <a class="dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $user['fullname'] ?></a>
                <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
					<li><a class="dropdown-item" href="<?= base_url('orders/order_history') ?>"><i class="fas fa-list-alt"></i> Order History</button></a></li>
					<li><a class="dropdown-item" href="<?= base_url('users/logout_user') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
<?php else: ?>
				<div class="col-auto col-lg-1 text-center align-items-center">
					<a class="text-light" href="<?= base_url('users/logout_user') ?>">Login</a>
				</div>
<?php endif; ?>
			</div>
		</nav>