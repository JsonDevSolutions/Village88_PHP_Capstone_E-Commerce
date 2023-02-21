<?php 
	if($page_number == 1){
?>
		<a href="<?= base_url($url . ($page_number - 1)) ?>" id ="previous" class="link btn btn-primary disabled"><</a>
<?php
	}else{
?>
		<a href="<?= base_url($url . ($page_number - 1)) ?>" id ="previous" class="link btn btn-primary"><</a>
<?php
	}
?>
<?php 
    for($page_num = 1; $page_num <= $total_pages; $page_num++){
        if($page_num == $page_number){
?>
        <a href="<?= base_url($url . $page_num) ?>" class="link btn btn-light disabled"><?= $page_num ?></a>
<?php
        }else{
?>
        <a href="<?= base_url($url . $page_num) ?>" class="link btn btn-primary"><?= $page_num ?></a>
<?php
        }
    }
?>
<?php 
	if($page_number == $total_pages){
?>
		<a href="<?= base_url($url . ($page_number + 1)) ?>" id ="previous" class="link btn btn-primary disabled">></a>
<?php
	}else{
?>
		<a href="<?= base_url($url . ($page_number + 1)) ?>" id ="next" class="link btn btn-primary">></a>
<?php
	}
?>