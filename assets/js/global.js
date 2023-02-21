$(document).ready(function () {
    // fetch cart count for first load
    var base_url = "http://localhost:8080/capstone_ecommerse/";
    $.get(base_url + 'carts/cart_count', function(res) {
        $('.cart-count').text(res);
    });
});
function toast_message(icon, message){
    Swal.fire({
        title: message,
        toast: true,
        position: 'top-end',
        icon: icon,
        showConfirmButton: false,
        timer: 2000,
        customClass: {
        popup: 'colored-toast'
    }
    })
}