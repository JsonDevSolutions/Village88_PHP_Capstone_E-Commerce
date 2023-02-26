<?php
    if(!empty($categories)){
        foreach($categories as $category){
?>
        <li class="position-relative category_name">
            <form action="<?= base_url('categories/update/' . $category['id']) ?>" class="category_update" method="post">
                <input class="w-75 category_value" type="text" name="category_name" value="<?= $category['name'] ?>" readonly/>
                <div>
                    <i class="fas fa-sync fa-spin position-absolute waiting" style="right: 70px; top: 5px"></i>
                    <i class="fas fa-pen position-absolute edit-category" style="right: 40px; top: 5px"></i>
                    <i class="fas fa-trash position-absolute  delete-category" url = "<?= base_url('categories/delete_category/' . $category['id']) ?>" style="right: 10px; top: 5px"></i>
                </div>
            </form>
        </li>
<?php
        }
    }
?>