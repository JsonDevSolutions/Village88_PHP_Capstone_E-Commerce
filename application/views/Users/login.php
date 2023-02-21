<?php
	$this->load->view('partials/client_header_section');
    $errors = $this->session->flashdata('login_error');
    $input_values = $this->session->flashdata('input_values');
    if($input_values === NULL){
        $input_values = array('email' => '', 'password' => '');
    }
?>
        <!-- ---------------------------Login Form-------------------------------->
		<form action="<?= base_url($login_url) ?>" method="post" class="login" autocomplete="off">
		<!-- ------------------Error Indicator-------->
<?php  
    if($errors != NULL){
        foreach($errors as $error){
?>
			<p class='alert alert-danger'><?= $error ?></p>
<?php 
        }
    }
?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <ul>
                <li><i class="fas fa-user"></i><input type="text" placeholder="Email" name="email" value="<?= $input_values["email"] ?>" /></li>
                <li><i class="fas fa-lock"></i><input type="password" placeholder="Password" id="password" name="password" value="<?= $input_values["password"] ?>" /></li>
            </ul>
            <!--------------For Button Animation---------->
			<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" value="Login" />
			</a>
			<div class="form-check mt-4 ms-3 text-white">
				<input class="form-check-input" type="checkbox" value="" id="show_password">
				<label class="form-check-label" for="show_password">Show Password</label>
			</div>
			<!------------------------------------------->
			<p>Don't have account yet? <a href="<?= base_url('users/register') ?>">Register</a></p>
		</form>
        <!------------------------------------------------------------------------->
	</body>
</html>