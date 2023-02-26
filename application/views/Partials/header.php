<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?= $title ?></title>
		<!--Google fonts-->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;500;900&display=swap" rel="stylesheet" />
		<!--Jquery library-->
		<script src="<?= base_url('assets/script/jquery.min.js') ?>"></script>
		<script src="<?= base_url('assets/script/jquery-ui.js') ?>"></script>
		<!-- bootstrap library-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- font awesome library-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
		<!-- -----------Sweet Alert----------->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- main style -->
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/admin_nav.less') ?>">
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/admin_products.less') ?>" />
		<!-- <link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/admin_nav.less') ?>">
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/custom_styles.less') ?>"> -->
<?php
	if(!empty($stylesheet_name)){
?>
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/' . $stylesheet_name . '.less') ?>" />
<?php
	}
?>
		<!-- less library -->
		<script src="https://cdn.jsdelivr.net/npm/less@4"></script>

		<!-- custom JS -->
		<!-- <script src="<?= base_url('assets/script/user_interaction.js') ?>"></script> -->
		<!-- -----------Javascript file------------------>
		<script src="<?= base_url('assets/js/global.js') ?>"></script>
<?php
	if(!empty($script_file_name)){
?>
		<script src="<?= base_url('assets/js/' . $script_file_name . '.js') ?>"></script>
<?php
	}
?>
	</head>
	<body>