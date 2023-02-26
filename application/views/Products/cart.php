<?php 
	$this->load->view('partials/client_header_section');
    $this->load->view('partials/client_side_navigation');
?>

    <h1 class="text-light"><i class="fas fa-shopping-cart"></i> Cart</h1>
    <!---------------------Cart Item Table-------------------------------->
    <div id="cart_content">
        <!-- Display cart items here -->
    </div>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        //set your publishable key
        Stripe.setPublishableKey('pk_test_51MY8xOEpepl4hv4FtyO1CyFzT6viZOpQaj1mvQygRyi1NY1jhGuRPrqFgrXa04HE2kRsaWfnJvG0TbflmVcWkXGg00BbekxX03');
        //callback to handle the response from stripe
        function stripeResponseHandler(status, response) {
            if (response.error) {
                //enable the submit button
                $('#pay').removeAttr("disabled");
                //display the errors on the form
                // $('#payment-errors').attr('hidden', 'false');
                $('#payment-errors').addClass('alert alert-danger');
                $("#payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                //get token id
                var token = response['id'];
                //insert the token into the form
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                //submit form to the server
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            //on form submit
            $(document).on('submit', '#paymentFrm', function(event) {
                //disable the submit button to prevent repeated clicks
                $('#pay').attr("disabled", "disabled");

                //create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_number').val(),
                    cvc: $('#cvc').val(),
                    exp_month: $('#exp_month').val(),
                    exp_year: $('#exp_year').val()
                }, stripeResponseHandler);

                //submit from callback
                return false;
            });
        });
    </script>
</body>
</html>