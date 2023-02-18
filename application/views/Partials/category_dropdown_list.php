<?php 
    if(!empty($categories)){
        foreach($categories as $category){
?>
        <form action="categories/update" method="post">
            <li class="position-relative category_name">
                <a class="dropdown-item" href="#" style="background-color:red;">
                    <input class="w-75 category_value" type="text" value="<?= $category['name'] ?>" />
                </a> 
                <!-- <img src="<?= base_url('assets/img/ajax-loading-icon.gif')?>" alt="waiting icon" style="width:30px; height: 30px; display: inline-block;"> -->
                <i class="fas fa-pen position-absolute edit-category" style="right: 40px; top: 5px"></i>
                <i class="fas fa-trash position-absolute  delete-category" style="right: 10px; top: 5px"></i>
            </li>
        </form>
<?php
        }
    }
?>