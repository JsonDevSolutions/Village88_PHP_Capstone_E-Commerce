$(document).ready(function () {
    // fetch cart count for first load
    var base_url = "http://localhost:8080/capstone_ecommerse/";
    $.get(base_url + 'carts/cart_count', function(res) {
        $('.cart-count').text(res);
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
        return false;
    })
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
});