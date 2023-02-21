$(document).ready(function () {
    var status = '';
    $(document)
    .on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('.table tbody').html(res.order_list);
            $('.page').html(res.pagination_links);
        },"json");
        return false;
    })
    .on("keyup change", ".search_order, #filter_order",  function(){
        $(this).closest("form").submit();
    })
    .on("click", "#order_status",  function(){
        status = $(this).val();
    })
    .on("click", ".link",  function(){
        event.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(res) {
            $('.table tbody').html(res.order_list);
            $('.page').html(res.pagination_links);
        },"json");
    })
    .on("change", "#order_status",  function(){
        if(status != 'Order in process'){
            $(this).val(status);
            toast_message('error', 'Unable to update order status.');
        }else{
            $(this).parent().submit();
            toast_message('success', 'Order status updated successfully.');
        }
    })
    $('#search').submit();
});