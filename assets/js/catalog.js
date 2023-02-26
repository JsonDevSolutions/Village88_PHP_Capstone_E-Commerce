$(document).ready(function () {
    $(document)
    .on('submit', 'form', function(){
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('#product-list').html(res.product_list);
            $('.page').html(res.pagination_links);
        },"json");
        return false;
    })
    .on("keyup change", "#search_product_name, .form-select",  function(){
        $(this).parent().submit();
    })
    // .on("click", ".link",  function(){
    //     event.preventDefault();
    //     var url = $(this).attr('href');
    //     $.get(url, function(res) {
    //         $('#product-list').html(res.product_list);
    //     },"json");
    // })
    $('#search').submit();
});