<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'fullscreen'); ?></p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number(esc_html__('No Responses', 'fullscreen'), esc_html__('One Response', 'fullscreen'), esc_html__('% Responses', 'fullscreen'));?> <span class="comments-subscribe"><?php post_comments_feed_link(esc_html__('Subscribe to comments', 'fullscreen')); ?></span></h3>

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
                                <?php echo get_avatar( $comment, 75 ); ?><br />
				<strong><?php comment_author_link() ?></strong>

			<div class="comment-entry">

				<?php comment_text() ?>
                                <?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php esc_html_e('Your comment is awaiting moderation.', 'fullscreen'); ?></em></p>
				<?php endif; ?>
                                <p class="post-time"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('M d, Y') ?> @ <?php comment_time() ?></a><br /><?php edit_comment_link('Edit','',''); ?></p>
			</div>
		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php esc_html_e('Comments are closed.', 'fullscreen'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond"><?php esc_html_e('Reply', 'fullscreen'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php esc_html_e('You must be', 'fullscreen'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php esc_html_e('logged in', 'fullscreen'); ?></a> <?php esc_html_e('to post a comment.', 'fullscreen'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php esc_html_e('Logged in as', 'fullscreen'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php esc_html_e('Logout', 'fullscreen'); ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><?php esc_html_e('Name', 'fullscreen'); ?> <?php if ($req) echo esc_html__('(required)', 'fullscreen'); ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><?php esc_html_e('Email (will not be published)', 'fullscreen'); ?> <?php if ($req) echo esc_html__('(required)', 'fullscreen'); ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><?php esc_html_e('Website', 'fullscreen'); ?></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comments" cols="60" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_html_e('Submit Comment', 'fullscreen'); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
