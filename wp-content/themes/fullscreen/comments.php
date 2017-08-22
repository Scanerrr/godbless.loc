<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','fullscreen'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

	<p id="comments"><?php comments_number(esc_html__('No Responses', 'fullscreen'), esc_html__('One Response', 'fullscreen'), esc_html__('Responses (%)', 'fullscreen'));?> to &#8220;<?php the_title(); ?>&#8221;</p>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php esc_html_e('Comments are closed.', 'fullscreen'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

     <?php comment_form( array('label_submit' => esc_attr__( 'Submit Comment', 'fullscreen' ), 'title_reply' => '<span>' . esc_attr__( 'Leave a Reply', 'fullscreen' ) . '</span>', 'title_reply_to' => esc_attr__( 'Leave a Reply to %s', 'fullscreen' )) ); ?>
    <?php else: ?>

<?php endif; // if you delete this the sky will fall on your head ?>
