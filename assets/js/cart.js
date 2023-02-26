const baseUrl = window.location.origin;
$(document).ready(function () {
    // Triggers Comment or Reply
    $(document)
    .on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            comment_list();
        });
        return false;
    })
    // Update Cart data using Ajax
    $(document).on('click', '#add-to-cart', function(){
        $.post($('#add_cart').attr('action'), $('#add_cart').serialize(), function(res) {
            $('.cart-count').text(res);
            success_msg('Item added to the cart.');
        });
        return false;
    })
    comment_list();
    function comment_list(){
        $.get($('#test').attr('url'), function(res) {
            $('#comments').html(res);
        });
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
});