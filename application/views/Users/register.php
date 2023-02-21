<?php 
	$this->load->view('partials/client_header_section');
	/*  DOCU: To display validation errors and Retain previous user input*/
	$errors = $this->session->flashdata('login_error');
    $input_values = $this->session->flashdata('input_values');
    if($input_values === NULL){
        $input_values = array('first_name' => '', 'last_name' => '', 'email' => '', 'contact_number' => '', 'password' => '', 'confirm_password' => '');
    }
?>
        
        <!-- ---------------------------Register Form-------------------------------->
		<form action="<?= base_url('users/process_register') ?>" method="post" class="register" autocomplete="off">
		<!-- ------------------Error and Success Registration Indicator-------->
<?php 
    if($this->session->flashdata('success') != NULL){
?>
			<p class='alert alert-success'><?= $this->session->flashdata('success') ?></p>
<?php
    }  
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
                <li><i class="far fa-address-card"></i><input type="text" placeholder="First Name" name="first_name"  value="<?= $input_values["first_name"] ?>" /></li>
                <li><i class="far fa-address-card"></i><input type="text" placeholder="Last Name" name="last_name"  value="<?= $input_values["last_name"] ?>" /></li>
                <li><i class="fas fa-at"></i><input type="email" placeholder="Email" name="email" value="<?= $input_values["email"] ?>" /></li>
                <li><i class="fas fa-phone"></i><input type="number" placeholder="Contact #" name="contact_number" value="<?= $input_values["contact_number"] ?>" /></li>
                <li><i class="fas fa-lock"></i><input type="password" placeholder="Password" name="password"  id="confirm_password"  value="<?= $input_values["password"] ?>" /></li>
                <li><i class="fas fa-check"></i><input type="password" placeholder="Confirm Password" name="confirm_password"  id="password"  value="<?= $input_values["confirm_password"] ?>" /></li>
            </ul>
            <!--------------For Button Animation---------->
			<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" value="Register" />
			</a>
            <div class="form-check mt-4 ms-3 text-white">
				<input class="form-check-input" type="checkbox" value="" id="show_password">
				<label class="form-check-label" for="show_password">Show Password</label>
			</div>
            <!-------------------------------------------->
			<p>Already have an account? <a href="<?= base_url('users') ?>">Login</a></p>
		</form>
        <!------------------------------------------------------------------------->
	</body>
</html>
