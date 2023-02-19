$(document).ready(function () {
    // fetch cart count for first load
    var base_url = "http://localhost:8080/capstone_ecommerse/";
    $.get(base_url + 'carts/cart_count', function(res) {
        $('.cart-count').text(res);
    });
    // Update Cart data using Ajax
    $(document).on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('.cart-count').text(res);
        });
        return false;
    });
    // Add to cart notification
    document.getElementById('add-to-cart').addEventListener('click', function() {
        add_to_cart();
    });
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