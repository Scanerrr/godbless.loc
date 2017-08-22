<?php get_header(); ?>

<?php
$slider_cat = '';
$slider_cat = $theme_options[ 'slider_category' ];
$top_row_posts = $theme_options[ 'slider_posts' ];
$bottom_row_posts = $top_row_posts*4;
   
/*  Calculate slider width  */
$top_width = $top_row_posts*320;
$bottom_width = $top_width;
?>
                
<!-- Begin top thumbnails --> 
<div class="home-thumbs" style="width:<?php echo $top_width; ?>px;">  
    
<?php 
$home_query = new WP_Query("cat=$slider_cat&ignore_sticky_posts=1&showposts=$top_row_posts"); $i = 0; ?>
<ul class="thumbs" style="width:<?php echo $top_width; ?>px;">
	<?php while ($home_query->have_posts()) : $home_query->the_post();
	    $do_not_duplicate = $post->ID; $i++; ?>
	    <li class="post-<?php the_ID(); ?> thumb-big"><?php get_the_image( array( 'custom_key' => array( 'thumbnail' ), 'default_size' => '320x320', 'width' => '320', 'height' => '320' ) ); ?></li>
    <?php endwhile; wp_reset_query(); $i = 0; ?>
</ul>
</div>

<!-- Begin bottom thumbnails -->

<div class="home-thumbs bottom-thumbs" style="width:<?php echo $bottom_width; ?>px;">
<?php $home_query_bottom = new WP_Query("cat=$slider_cat&ignore_sticky_posts=1&showposts=$bottom_row_posts&offset=$top_row_posts"); $b = 0; ?>
<ul class="thumbs" style="width:<?php echo $bottom_width; ?>px;">
	<?php while ($home_query_bottom->have_posts()) : $home_query_bottom->the_post();
	    $do_not_duplicate = $post->ID; $b++; ?>
	
	    <li class="post-<?php the_ID(); ?> thumb"><?php get_the_image( array( 'custom_key' => array( 'thumbnail' ), 'default_size' => '160x160', 'width' => '160', 'height' => '160' ) ); ?></li>
    <?php endwhile; wp_reset_query(); $b = 0; ?>
</ul>
</div> <!-- End bottom thumbnails -->  

</div> <!--end container-->
<?php wp_footer(); ?>
</body>
</html>