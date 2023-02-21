$(document).ready(function () {
    // Update Cart data using Ajax
    $(document)
    .on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('.cart-count').text(res);
        });
        return false;
    })
    .on("click", "#add-to-cart",  function(){
        success_msg('Item added to the cart.');
        $(this).parent().submit();
    })
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