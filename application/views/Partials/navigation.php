		<!-------Navigation------------------------->
		<nav class="container">
			<div class="row w-100 align-items-center p-4 top-nav navbar fixed-top">
				<div class="col-3 col-md-2">
					<a href="<?= base_url('dashboard/orders') ?>" class="text-dark w-100 dash">Dashboard</a>
				</div>

				<div class="col-2 col-md-1">
					<a href="<?= base_url('dashboard/orders') ?>" class="text-dark w-100">Orders</a>
				</div>

				<div class="col-2 col-md-1">
					<a href="<?= base_url('dashboard/products') ?>" class="text-dark w-100">Products</a>
				</div>

				<div class="col text-end ">
					<a href="<?= base_url('users/logout_admin') ?>" class="text-dark w-100">Log off</a>
				</div>
			</div>
		</nav>