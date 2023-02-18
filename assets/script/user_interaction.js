$(document).ready(function () {
    /********************************************************************/
    /*  Load Category List    */
    $.get('products/html_category', function(res) {
        $('#category_list').html(res);
    });

    $(document)
    .on("mouseenter", ".category_name",  function(){
        $(this).children(".edit-category").css("visibility", "visible");
        $(this).children(".delete-category").css("visibility", "visible");
        $(this).children("form").children().css("cursor", "default").css("background-color", "#00aff8");
        $(this).css("cursor", "default").css("background-color", "#00aff8");
        // if($(this).children("form").children("input[type=text]").attr("readonly") == null){
        //     $(this).children("form").children("input[type=text]").css("cursor", "text");
        // }
    })
    .on("mouseleave", ".category_name",  function(){
        $(this).children(".edit-category").css("visibility", "hidden");
        $(this).children(".delete-category").css("visibility", "hidden");
        $(this).children("form").children().css("background-color", "white");
        $(this).css("background-color", "white");
    });
    $(document)
    .on("click", ".category_name",  function(){
        $('#dropdownMenuButton1').text($(this).children().children().attr('value'));
    });
    $(document)
    .on("change", ".category_value",  function(){
        $(this).parent().parent("form").submit();
    });
    /**********************************************/

    /********************************************************************/
    /*  Change Modal Title, form action and btn save    */
    $('#add').click(function(){
        $('.add-update').text('Add a new product');
        $('#form-add-update').attr('action', 'products/do_upload');
        $('.btn_save').attr('value', 'Save');
    });
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

        var reader = new FileReader();
        var onLoadCounter = 0;
        reader.addEventListener('load', function(e){
            var htmlStr = "" +
                '<li class="img_upload_section">' +
                    '<div class="row align-items-center">' +
                        '<i class="fas fa-bars col-1"></i>' +
                        '<div class="col-3">' +
                            '<div class="img_container">' +
                                '<img src="' + e.target.result + '" alt="' + input.files[onLoadCounter].name + '" />' +
                            '</div>' +
                        '</div>' +
                        '<p class="img_filename col-4">' + input.files[onLoadCounter].name + '</p>' +
                        '<i class="fas fa-trash col-1 btn_img_upload_delete"></i>' +
                        '<input class="col-1" type="checkbox" name="img_upload_main_id" value="filename" />' +
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
    }
