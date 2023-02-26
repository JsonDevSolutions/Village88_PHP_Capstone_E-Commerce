const baseUrl = window.location.origin;
var div_content;
$(document).ready(function () {
    // Handles Searching or Deleting the Product
    $('#confirm_delete, #search').submit(function(event) {
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('.table tbody').html(res.product_list);
            $('.page').html(res.pagination_links);
        },"json");
        return false;
    });
    // Add / Update Product
    $('#form-add-update').submit(function(event) {
        event.preventDefault();
        var form_data = new FormData($('#form-add-update')[0]);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#search').submit();
                load_category();
              // handle success response
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('error');
              // handle error response
            }
        });
        return false;
    });
    // Updating Category Name
    function submit_data(form){
        $.post(form.attr('action'), form.serialize());
        return false;
    }
    // Reset Textbox values
    function reset_form_values(){
        $("#product_name").val("");
        $("#description").val("");
        $("#stocks").val("");
        $("#price").val("");
        $("#add_new_categ").val("");
        $('#dropdownMenuButton1').text("Category");
        $(".img_upload_container").html("");
        $("#product_name").removeClass('is-valid')
        $("#product_name").removeClass('is-invalid')
        $("#description").removeClass('is-valid')
        $("#description").removeClass('is-invalid')
        $("#stocks").removeClass('is-valid')
        $("#stocks").removeClass('is-invalid')
        $("#price").removeClass('is-valid')
        $("#price").removeClass('is-invalid')
        $("#dropdownMenuButton1").removeClass('is-valid')
        $("#dropdownMenuButton1").removeClass('is-invalid')
    }
    $(document).on("keyup", ".search_product",  function(){
        $('#search').submit();
    })
    // Add / Update Product
    $(document).on("keyup", "#product_name, #description, #stocks, #price",  function(){
        if($(this).val() != ''){
            $(this).addClass('is-valid')
            $(this).removeClass('is-invalid')
        }else{
            $(this).removeClass('is-valid')
            $(this).addClass('is-invalid')
        }
    })
    $(document).on("keyup", "#add_new_categ",  function(){
        if($(this).val() != ''){
            $(this).addClass('is-valid')
            $('#dropdownMenuButton1').removeClass('is-invalid')
        }else{
            $(this).removeClass('is-valid')
            if($('#dropdownMenuButton1').text() == 'Category'){
                $('#dropdownMenuButton1').addClass('is-invalid')
            }
        }
    })
    // Pagination Links
    .on("click", ".link",  function(){
        event.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(res) {
            $('.table tbody').html(res.product_list);
            $('.page').html(res.pagination_links);
        },"json");
    })
    $('#search').submit();
    $(document)
    /********************************************************************/
    /*  Load Category List    */
    $.get(baseUrl + '/products/html_category', function(res) {
        $('#category_list').html(res);
    });
    function load_category(){
        $.get(baseUrl + '/products/html_category', function(res) {
            $('#category_list').html(res);
        });
    }
    // #product_name, #description, #stocks, #price
    $(".btn_save").click(function(){
        if(validate_input() === false){
            return false;
        }else{
            if($('#add_new_categ').val() == ''){
                $('#add_new_categ').val($('#dropdownMenuButton1').text());
            }
            $('#form-add-update').submit();
            if($(this).val() == 'Save'){
                toast_message('success', 'Product Added Successfully.');
            }else{
                toast_message('success', 'Product Updated Successfully.');
            }
            reset_form_values();
            event.preventDefault();
        }
    });
    // For checking input validation when save is clicked
    function validate_input(){
        if($("#product_name").val() === '' || $("#description").val() === '' || $("#stocks").val() === '' || $("#price").val() === ''){
            toast_message('error', 'Empty fields is invalid.');
            return false;
        }else if($(".img_upload_section").length == 0){
            toast_message('error', 'Upload at least One Image.');
            return false;
        }else if($("#main_image").val() ===''){
            toast_message('error', 'Select main image.');
            return false;
        }
    }
    $(document)
    .on("mouseenter", ".category_name",  function(){
        $(this).children("form").children().children(".edit-category").css("visibility", "visible");
        $(this).children("form").children().children(".delete-category").css("visibility", "visible");
        $(this).children("form").children().css("cursor", "default").css("background-color", "#00aff8");
        $(this).css("cursor", "default").css("background-color", "#00aff8");
        if($(this).children("form").children("input[type=text]").attr("readonly") == null){
            $(this).children("form").children("input[type=text]").css("cursor", "text");
        }
    })
    .on("mouseleave", ".category_name",  function(){
        $(this).children("form").children().children(".edit-category").css("visibility", "hidden");
        $(this).children("form").children().children(".delete-category").css("visibility", "hidden");
        $(this).children("form").children().css("background-color", "white");
        $(this).css("background-color", "white");
    })
    // Triggers when edit category is clicked
    $(document).on("click", ".edit-category", function(event){
        $('#dropdownMenuButton1').click();
        $(".category_value").attr("readonly", true).css("outline", "none");
        $(this).parent().siblings(".category_value").attr("readonly", false).css("outline", "2.5px solid black").css("cursor", "text");
    });
    // Delete Category in the list
    $(document).on("click", ".delete-category", function(event){
        confirm_delete_category($(this).attr('url'));
        $('#dropdownMenuButton1').click();
    });
    // Updating Category Name
    $(document).on("keypress mouseleave", ".category_value", function(){
        if($(this).attr("readonly") != "readonly"){
            // display waiting icon before sending
            $(this).siblings().children(".waiting").css("visibility", "visible");
            // activate ajax and send form.
            submit_data($(this).parent());
            // hide waiting icon after receiving ang changing all data.
            setTimeout(function(){
                $(".waiting").css("visibility", "hidden");
            }, 500);
        }
    });
    // Revert Textbox into read only
    $(document).on("mouseleave", ".category_value", function(){
        if($(this).attr("readonly") != "readonly"){
            $(".category_value").attr("readonly", true).css("outline", "none");
        }
    });
    $(document)
    // Get Selected category Value
    .on("click", ".category_value",  function(){
        if($(this).attr("readonly") == "readonly"){
            $('#dropdownMenuButton1').text($(this).attr('value'));
            $('#dropdownMenuButton1').removeClass('is-invalid')
            $('#dropdownMenuButton1').addClass('is-valid')
            $('#dropdownMenuButton1').click();
            $(".category_value").attr("readonly", true).css("outline", "none");
        }
    });
    // COnfirm delete message for category
    function confirm_delete_category(url){
        console.log(url);
        Swal.fire({
            title: 'Are you sure you want to delete this category?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.post(url, $(this).serialize(), function(res) {
                    $('#category_list').html(res);
                });
                toast_message('success', 'Deleted Successfully.');
            }
        })
    }

    /********************************************************************/
    /*  Change Modal Title, form action and btn save    */
    $('#add').click(function(){
        $('.add-update').text('Add a new product');
        $('#product_info').html(div_content);
        $('#form-add-update').attr('action', baseUrl + '/products/create');
        reset_form_values();
        $('.btn_save').attr('value', 'Save');
    });
    // Update Modal Content When Edit is clicked
    $(document).on("click", ".edit_product",  function(){
        div_content = $('#product_info').html();
        $('#product_info').html('');
        $('.add-update').text('Edit Product');
        $('#form-add-update').attr('action', $(this).attr('alt_url'));
        $('.btn_save').attr('value', 'Update');
        $.get($(this).attr('href'), function(res) {
            $('#product_info').html(res);
            load_category();
            // $('#dropdownMenuButton1').val($('#add_new_categ').text());
        });
        event.preventDefault();
    });
    $(document).on("click", ".delete_product",  function(){
        var url = $(this).attr('href');
        $("#confirm_delete").attr('action', url);
        event.preventDefault();
    });
    $("#confirm_delete .btn-danger").click(function(){
        toast_message('success', 'Product Deleted Successfully.');
    });
    // Preview Uploaded Images
    $(document).on("change", "#img_upload", function(){
        readURL(this); // javascript solution
    });
    /********************************************************************/
    /*  Disable other checkbox when a checkbox is checked    */
    $(document).on("click", ".img_upload_section input[type=checkbox]", function(){
        if($(".img_upload_section input[type=checkbox]").not(this).attr("disabled")){
            resetCheckbox();
        }
        else{
            $("#main_image").val($(this).siblings('.img_filename').text());
            $(".img_upload_section input[type=checkbox]").not(this).attr("disabled", true);
            $(".img_upload_section input[type=checkbox]").not(this).siblings("label").css("color", "gray");
        }
    });
    /********************************************************************/
    /*  Remove the uploaded photo and verify if checkbox is checked to reset the checkbox    */
    $(document)
        .on("mouseover", ".img_upload_section",  function(){
            $(this).children().children(".btn_img_upload_delete").css("visibility", "visible");
            $(this).children().children(".btn_img_upload_delete").css("cursor", "pointer");
            $(this).css("outline", "2px solid #1975ff");
        })
        .on("mouseleave", ".img_upload_section",  function(){
            $(this).children().children(".btn_img_upload_delete").css("visibility", "hidden");
            $(this).children().children(".btn_img_upload_delete").css("cursor", "default");
            $(this).css("outline", "none");
        });

    $(document).on("click", ".btn_img_upload_delete", function(){
        if(!$(this).siblings("input[type=checkbox]").attr("disabled")){
            resetCheckbox();
        }
        $(this).parent().parent().remove();
    });
    /********************************************************************/
    /*  For sorting/arrangement of photo    */
    $(document)
        .on("mouseover", ".img_upload_section .col-3 .img_container",  function(){
            $(this).parent().parent().parent().parent().sortable({
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                }
            });
            $(this).parent().parent().parent().parent().sortable("enable");
            $(this).css("cursor", "grab");
        })
        .on("mouseleave", ".img_upload_section .col-3 .img_container",  function(){
            $(this).parent().css("background-color", "white");
            $(this).parent().parent().parent().parent().sortable("disable");
        })
        .on("mousedown", ".img_upload_section .col-3 .img_container",  function(){
            $(this).css("cursor", "grabbing");
        })
        .on("mouseup", ".img_upload_section .col-3 .img_container",  function(){
            $(this).css("cursor", "grab");
        });
});
    /*  DOCU: This function read the uploaded image files.
        This codes used the FileReader from JavaScript.
        This will render the preview of uploaded images.
    */
    function readURL(input) {
        if(!input.files || !input.files[0]){
            return false;
        }
        else if($(".img_upload_section").length + input.files.length > 6){
            alert("Only four (6) images in total are allowed to be upload.");
            return false;
        }
        // console.log(onLoadCounter);
        var reader = new FileReader();
        var onLoadCounter = 0;
        reader.addEventListener('load', function(e){
            var htmlStr = "" +
                '<li class="img_upload_section">' +
                    '<div class="row align-items-center">' +
                        '<i class="fas fa-bars col-1"></i>' +
                        '<div class="col-3">' +
                            '<div class="img_container">' +
                                '<img src="' + e.target.result + '" id = "uploaded_image" alt="' + input.files[onLoadCounter].name + '" />' +
                            '</div>' +
                        '</div>' +
                        '<p class="img_filename col-4 overflow-hidden">' + input.files[onLoadCounter].name + '</p>' +
                        '<i class="fas fa-trash col-1 btn_img_upload_delete"></i>' +
                        '<input class="col-1" id = "chk_main" type="checkbox" name="img_upload_main_id" value="filename" />' +
                        // '<input type="file" name="image_url[]" value = "' + e.target.result + '"/>' +
                        '<p class="col-1 m-0 p-0">main</p>' +
                    '</div>' +
                '</li>';
            onLoadCounter++;
            $(".img_upload_container").append(htmlStr);
            // console.log(e.target.result);
        // }
        });
        reader.readAsDataURL(input.files[0]);

        var counter = 1;
        reader.onloadend = function(e){
            if(counter < input.files.length){
                reader.readAsDataURL(input.files[counter]); 
                counter++;
            }
        }
    }
    /********************************************************************/

    /*  Reset the attributes of checkbox    */
    function resetCheckbox(){
        $(".img_upload_section input[type=checkbox]").attr("disabled", false);
        $(".img_upload_section input[type=checkbox]").siblings("label").css("color", "black");
        $("#main_image").val('');
    }
    /*  Clicking preview button will display a new tab of Preview page    */
    $(document).on("click", ".btn_preview_products_add_edit", function(){
        var prevProductName = $("#product_name").val();
        var prevProductDesc = $("#description").val();
        var prevProductPrice = $("#price").val();

        var totalOptions = 3;
        var prevProductPriceOption = [];
        for(var i = 0; i < totalOptions; i++){
            prevProductPriceOption[i] = i + 1 + ' ($' + prevProductPrice * (i + 1) + ')';
        }

        var imgUpload = $("#uploaded_image");
        var imgCheckbox = $("#chk_main");
        var prevProductImg = [];
        var mainIndexImg = 0;
        for(var i = 0; i < imgUpload.length; i++){
            prevProductImg[i] = imgUpload[i].currentSrc;
            if(imgCheckbox[i].checked){
                mainIndexImg = i;
            }
        }

        preview(prevProductName, prevProductDesc, prevProductPriceOption, prevProductImg, mainIndexImg);
    });
    function preview(prevProductName, prevProductDesc, prevProductPriceOption, prevProductImg, mainIndexImg){
        var previewWindowHTML = '' +
            '<!DOCTYPE html>' +
            '<html lang="en">' +
            '<head>' +
                '<meta charset="UTF-8">' +
                '<meta http-equiv="X-UA-Compatible" content="IE=edge">' +
                '<meta name="viewport" content="width=device-width, initial-scale=1.0">' +
                '<title>(Product Page) '+ prevProductName +' | BEST Deals PH</title>' +

                '<link rel="stylesheet" type="text/css" href="' + baseUrl +'/assets/css/normalize.css'+ '" />' +
                '<link rel="stylesheet" type="text/css" href="' + baseUrl + '/assets/css/style.css' + '" />' +

            '</head>' +
            '<body>' +
                '<header>' +
                    '<a href=""><h2>BEST Deals PH</h2></a>' +
                    '<a class="nav_end" href=""><h3>Shopping Cart (<span class="cart_quantity">0</span>)</h3></a>' +
                '</header>' +
                '<main>' +
                    '<section class="item_panel">' +
                        '<a class="go_back" href=""><p>Go Back</p></a>' +
                        '<div class="item_details">' +
                            '<aside class="img_section">' +
                                '<img class="main_img" src="' + prevProductImg[mainIndexImg] + '" alt="img"/>' +
                                '<section>';
        for(var i = 0; i < prevProductImg.length; i++){
            previewWindowHTML += '<img class="sub_img" src="' + prevProductImg[i] + '" alt="img"/>'
        }
                                    // '<img class="sub_img" src="' + prevProductImg + '" alt="img"/>' +
                                    // '<img class="sub_img default_main_img" src="' + '" alt="img"/>' +
                                    // '<img class="sub_img" src="' + '" alt="img"/>' +
                                    // '<img class="sub_img" src="' + '" alt="img"/>' +
        previewWindowHTML += '' +
                                '</section>' +
                            '</aside>' +
                            '<aside class="desc_section">' +
                                '<h2>' + prevProductName + '</h2>' +
                                '<p>' + prevProductDesc + '</p>' +
                                '<form action="" method="post">' +
                                    '<input type="hidden" name="product_id" value="product_id"/>' +
                                    '<select class="new_order_qty">' +
                                        '<option>' + prevProductPriceOption[0] + '</option>' +
                                        '<option>' + prevProductPriceOption[1] + '</option>' +
                                        '<option>' + prevProductPriceOption[2] + '</option>' +
                                    '</select>' +
                                    '\n<input type="submit" value="Buy"/>' +
                                    '<p class="item_added_confirm">Item added to the cart.</p>' +
                                '</form>' +
                            '</aside>' +
                        '</div>' +
                    '</section>' +
                '</main>' +
            '</body>';

        var previewWindow = window.open("", "Preview");
        previewWindow.document.write(previewWindowHTML);
    }
    /********************************************************************/