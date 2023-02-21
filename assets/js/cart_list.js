$(document).ready(function () {
    var base_url = "http://localhost:8080/capstone_ecommerse/";
    load_list();
    // Update Cart data using Ajax
    $(document)
    .on("click", "#btn_delete_product", function(){
        $(this).parent().parent().parent().remove();
        remove_cart_item($(this).parent())
        return false;
    })
    .on("click", "#btn_edit_quantity", function(){
        update_cart_item_quantity($(this).parent().siblings('span').text(), $(this).parent().siblings('span'), $(this));
        return false;
    })
    .on("change", "#same_address", function(){
        if ($(this).prop('checked')) {
            $("#billing_first_name").attr('value', $("#shipping_first_name").val());
            $("#billing_last_name").attr('value', $("#shipping_last_name").val());
            $("#billing_address_one").attr('value', $("#shipping_address_one").val());
            $("#billing_address_two").attr('value', $("#shipping_address_two").val());
            $("#billing_city").attr('value', $("#shipping_city").val());
            $("#billing_state").attr('value', $("#shipping_state").val());
            $("#billing_zip_code").attr('value', $("#shipping_zip_code").val());
            $("#billing_first_name, #billing_last_name, #billing_address_one, #billing_address_two, #billing_city, #billing_state, #billing_zip_code").prop("disabled", true);
        } else {
            $("#billing input[type=text]").prop("disabled", false);
        }
    })
    .on("click", "#pay", function(){
        $("#billing input[type=text]").prop("disabled", false);
    })
    function load_list(){
        $.get(base_url + 'carts/cart_list_html', function(res) {
            $('#cart_content').html(res);
        });
    }
    function remove_cart_item(form){
        $.post(form.attr('action'), form.serialize(), function(res) {
            $('.cart-count').text(res);
            load_list();
        });
        return false;
    }
    function success_msg(message){
        Swal.fire({
            title: message,
            toast: true,
            position: 'top-end',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            popup: 'colored-toast'
        }
        })
    }
    function update_cart_item_quantity(quantity, column, button){
        Swal.fire({
            title: 'Enter Quantity',
            html: '<input id="cart_item_quantity" type="number" class="swal2-input" value="' + quantity + '" style="text-align:center">',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                if(document.getElementById('cart_item_quantity').value <= 0){
                    Swal.fire({icon: 'error', text: 'Quantity must be greater than 0'}).then((result) => {
                        button.click();
                    })
                }else if(document.getElementById('cart_item_quantity').value != quantity){
                    var update_url = button.parent().attr('subaction') + '/' + document.getElementById('cart_item_quantity').value;
                    $.post(update_url, button.parent().serialize(), function(res) {
                        $('#cart_content').html(res);
                    });
                    column.text(document.getElementById('cart_item_quantity').value)
                    success_msg('Quantity updated Successfully.');
                }
            }
        })
    }
});