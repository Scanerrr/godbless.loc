<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

$cur_game_id = get_the_ID();


$args = array(
    'post_type' => 'offer',
    'meta_query' => array(
        array(
            'key' => 'game_id',
            'value' => $cur_game_id,
        ),
    ),
    'post_status' => 'publish'
);


$query = new WP_Query;
$offers_for_popup = $query->query($args);


?>

<script>
    var popup_data = {};

    <?php
foreach ($offers_for_popup as $offer) {

    $offer_title = $offer->post_title;
    $offer_id = $offer->ID;
    $offer_dop_info = get_post_meta($offer_id, 'dopinfo', true);
    $offer_website = get_post_meta($offer_id, 'website', true);
    if (!strlen($offer_dop_info)) $offer_dop_info = "Нет";

    $offer_message = "<p>Предложение: <br/>$offer_title<br/><br/>Website:<br>$offer_website<br><br> Дополнительная информаци: <br>$offer_dop_info </p>";
    echo 'popup_data["popup_block_'.$offer_id.'"] = "'.$offer_message.'" '; echo "\n";

    //echo '<div class="game_popup_block popup_block_' . $offer_id . '"><p>' . $offer_message . '</p></div>';

} ?>

</script>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header>
    <!-- .entry-header -->

    <?php twentysixteen_excerpt(); ?>

    <?php twentysixteen_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentysixteen') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'twentysixteen') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));

        if ('' !== get_the_author_meta('description')) {
            //get_template_part( 'template-parts/biography' );
        }
        ?>
    </div>
    <!-- .entry-content -->

    <?php
    $cur_post_id = get_the_ID();
    global $default_game_template;
    $game_template = get_post_meta($cur_post_id, '_game_template', true);
    if (!$game_template) $game_template = $default_game_template;

    echo "<div class='game-offers-table'>";
    echo do_shortcode("[wpdatatable id=$game_template  var1=$cur_post_id]");
    echo "</div>";
    ?>

    <footer class="entry-footer">
        <?php twentysixteen_entry_meta(); ?>
        <?php
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer>
    <!-- .entry-footer -->
</article><!-- #post-## -->

<div class="game_popup_block"><p>Нет информации</p></div>







