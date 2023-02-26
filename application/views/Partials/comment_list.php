            <!------------------------add review--------------------------->
            <form action="<?= base_url('comments/add_comment') ?>" method="POST">
				<h2>Leave a Comment</h2>
				<input type="hidden" name="product_id" value = "<?= $product_id ?>" />
				<textarea placeholder="Write a comment" name="content" class="form-control" rows="3"></textarea>
				<input type="submit" class="btn-lg btn-outline-primary mt-2 d-block me-0 ms-auto" value="Review" />
			</form>
            <!------------------------Review List--------------------------->
			<ul>
<?php
	if(!empty($comments)){
		foreach($comments as $comment){
?>
				<li class="comment">
					<h3 class="d-inline-block"><?= $comment['fullname'] ?></h3>
					<p class="d-inline-block text-secondary ms-4 mb-0"><?= $comment['comment_date'] ?></p>
					<p><?= $comment['content'] ?></p>
                    <!------------------------Reply List--------------------------->
					<ul>
<?php
	if(!empty($replies)){
		foreach($replies as $reply){
			if($reply['comment_id'] == $comment['comment_id']){
?>
						<li class="mt-4">
							<h4 class="d-inline-block"><i class="fas fa-level-up-alt fa-rotate-90 me-2 text-info"></i><?= $reply['fullname'] ?></h4>
							<p class="d-inline-block text-secondary ms-4 mb-0"><?= $reply['reply_date'] ?></p>
							<p class="ms-4"><?= $reply['content'] ?></p>
						</li>
<?php
			}
		}
	}
?>
					</ul>
					<!------------------------add a reply--------------------------->
					<form action="<?= base_url('replies/add_reply') ?>" method="post">
						<input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>" />
						<input type="hidden" name="product_id" value = "<?= $product_id ?>" />
						<textarea placeholder="Write a reply" name="content" class="form-control mb-4" rows="3"></textarea>
						<input type="submit" class="btn-lg btn-outline-primary mt-2 d-block me-0 ms-auto" value="reply" />
					</form>
				</li>
<?php
		}
	}
?>
			</ul>
			<a href="#" class="more">Show more reviews <i class="fas fa-angle-down"></i></a>