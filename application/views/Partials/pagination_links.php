<?php 
    for($page_num = 1; $page_num <= $total_pages; $page_num++){
?>
        <a href="<?= base_url('products/html_product_list/' . $page_num) ?>" class="link"><?= $page_num ?></a>
<?php
    }
?>
        <a href="#">></a>