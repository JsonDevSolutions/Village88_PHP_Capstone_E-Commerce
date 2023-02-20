$(document).ready(function () {
    // fetch cart count for first load
    var base_url = "http://localhost:8080/capstone_ecommerse/";
    $.get(base_url + 'carts/cart_count', function(res) {
        $('.cart-count').text(res);
    });
    $.get(base_url + 'carts/cart_list_html', function(res) {
        $('#cart_content').html(res);
    });
    // Update Cart data using Ajax
    $(document)
    .on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('.cart-count').text(res);
        });
        return false;
    })
    .on("click", "#add-to-cart",  function(){
        add_to_cart();
    })
    .on("click", "#btn_delete_product", function(){
        $(this).parent().parent().parent().remove();
        remove_cart_item($(this).parent())
        return false;
    })
    .on("click", "#btn_edit_quantity", function(){
        // $(this).parent().attr('action', base_url + 'carts/update');
        // console.log($(this).parent().attr('subaction'));
        update_cart_item_quantity($(this).parent().siblings('span').text(), $(this).parent().siblings('span'), $(this));
        // console.log($(this).parent().siblings('span').text());
        return false;
    })
    function remove_cart_item(form){
        $.post(form.attr('action'), form.serialize(), function(res) {
            $('.cart-count').text(res);
        });
        return false;
    }
    function add_to_cart(){
        Swal.fire({
            title: 'Item added to the cart.',
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
            html: '<input id="swal-input1" type="number" class="swal2-input" value="' + quantity + '" style="text-align:center">',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                if(document.getElementById('swal-input1').value <= 0){
                    Swal.fire({icon: 'error', text: 'Quantity must be greater than 0'}).then((result) => {
                        button.click();
                    })
                }else{
                    var update_url = button.parent().attr('subaction') + '/' + document.getElementById('swal-input1').value;
                    $.post(update_url, button.parent().serialize(), function(res) {
                        $('#cart_content').html(res);
                    });
                    column.text(document.getElementById('swal-input1').value)
                }
            }
        })
    }
});