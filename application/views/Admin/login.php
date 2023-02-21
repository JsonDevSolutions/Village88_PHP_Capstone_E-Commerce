<?php 
    $errors = $this->session->flashdata('login_error');
    $input_values = $this->session->flashdata('input_values');
    if($input_values === NULL){
        $input_values = array('email' => '', 'password' => '');
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Login</title>
        <!-- -----------Google Fonts------------>
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;500;900&display=swap" rel="stylesheet" />
        <!-- -----------Fonts Awesome----------->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <!-- -----------Jquery--------->
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- -----------Bootstrap--------------->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- -----------Stylesheet-------------->
		<link rel="stylesheet/less" type="text/css" href="<?= base_url('assets/style/login.less') ?>" />
        <!-- -----------LESS-------------------->
		<script src="https://cdn.jsdelivr.net/npm/less@4"></script>
	</head>
	<body>
        <!-- ------------------Error Indicator-------->
        <div class="error">
<?php 
    if($errors != NULL){
        foreach($errors as $error){
?>
			<p><?= $error ?></p>
<?php 
        }
    }
?>
        </div>
        <!-------------------------------------------->
        <!-- ---------------------------Login Form-------------------------------->
		<form action="<?= base_url('users/process_admin_login') ?>" method="post" class="login" autocomplete="off">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <ul>
                <li><i class="fas fa-user"></i><input type="text" placeholder="Email" name="email" value="<?= $input_values["email"] ?>" /></li>
                <li><i class="fas fa-lock"></i><input type="password" placeholder="Password" name="password" value="<?= $input_values["password"] ?>" /></li>
            </ul>
            <!--------------For Button Animation---------->
			<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" value="Login" />
			</a>
		</form>
        <!------------------------------------------------------------------------->
	</body>
</html>
