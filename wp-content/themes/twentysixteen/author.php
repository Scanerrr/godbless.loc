<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();


?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


        <?php

        if (isset($_GET['author_name'])) :
            $cur_author = get_user_by('user_login', $_GET['author_name']);
        else :
            $cur_author = get_userdata(intval($author));
        endif;

        //print_pre($cur_author);

        $query = new WP_Query(array('post_type' => 'offer', 'author' => $cur_author->data->ID));
        if ($query->have_posts()) : ?>

            <header class="page-header">
                <?php
                //echo '<h1 class="page-title">' . $cur_author->data->user_login . '</h1>';
                //the_archive_description('<div class="taxonomy-description">', '</div>');
                $avatar_url = get_avatar_url($cur_author->ID, array(
                    'size' => 128,
                    'default' => 'identicon',
                ));
                ?>


                <h2>Страница пользователя: <?php echo $cur_author->nickname; ?></h2>

                <div class="user_info">
                    <div class="user_info-column-1">
                        <img src="<?= $avatar_url ?>" height="128px" width="128px"/>
                    </div>
                    <div class="user_info-column-2">
                        <dl>
                            <dt>Website</dt>
                            <dd><a href="<?php echo $cur_author->user_url; ?>"><?php echo $cur_author->user_url; ?></a></dd>
                            <dt>Profile</dt>
                            <dd><?php echo $cur_author->user_description; ?></dd>
                        </dl>
                    </div>
                    <div class="user_info-column-3">
                        <dl>
                            <dt>Данные Webmoney</dt>
                            <dd>
                        Сумма резервов: $232; <br>
                            Сертификат webmoney: проверен
                            Сумма резервов 2: $232; <br>
                            </dd>
                        </dl>
                    </div>

                </div>
                <div s  tyle="clear: both"></div>
                <a href="/add_review?user_id=<?=$cur_author->ID?>"> <button >Оставить отзыв</button></a>





            </header>
            <!-- .page-header -->

            <h2>Отзывы об обменнике</h2>


            <?php
            global $review_ratings;
            // сначала нужно выбрать массив оферов данного пользователя
            $cur_author_user_id = $cur_author->ID;
            $query = new WP_Query(array(
                'post_type' => 'offer',
                'author' => $cur_author_user_id,
                'post_status' => 'publish'
            ));

            $offer_ids = array();
            foreach ($query->posts as $offer) {
                $offer_ids[] = $offer->ID;
            }

            $args = array(
                'post__in' => $offer_ids,
                'post_type' => 'offer',
                'status' => 'all',
                'meta_key' => 'rating',
                'meta_value' => '1',
            );
            // Формируем позитивные отзывы
            if ($comments_positive = get_comments($args)) {
                echo '<div class="review-container">';
                foreach ($comments_positive as $comment) {
                    $avatar_url = get_avatar_url($comment, array(
                        'size' => 48,
                        'default' => 'identicon',
                    ));

                    $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                    //echo "<br>" . $review_ratings[$rating];
                    ?>
                    <div class="review positive-review">
                        <div class="review-header">
                            <img src="<?= $avatar_url ?>" height="48px" width="48px"/>
                            <span class="comment_author"><?= $comment->comment_author ?></span>
                        <span class="comment_info"><?= $comment->comment_author_IP ?> (<?= $comment->comment_date ?>
                            )</span>
                        </div>
                        <div class="review-content"><?= $comment->comment_content ?></div>
                        <div class="review-actions"></div>
                    </div>

                    <?php
                }
                echo '</div>';
            }


            $args = array(
                'post__in' => $offer_ids,
                'post_type' => 'offer',
                'status' => 'all',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'rating',
                        'value' => '0'
                    ),
                    array(
                        'key' => 'rating',
                        'value' => '2'
                    )
                ),
            );

            global $review_ratings;

            if ($comments_negative = get_comments($args)) {
                echo '<div class="review-container">';

                foreach ($comments_negative as $comment) {
                    $avatar_url = get_avatar_url($comment, array(
                        'size' => 48,
                        'default' => 'identicon',
                    ));

                    $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                    $rating_class = $rating == '2' ? 'negative-review' : 'neutral-review';
                    ?>
                    <div class="review <?= $rating_class ?>">
                        <div class="review-header">
                            <img src="<?= $avatar_url ?>" height="48px" width="48px"/>
                            <span class="comment_author"><?= $comment->comment_author ?></span>
                        <span class="comment_info"><?= $comment->comment_author_IP ?> (<?= $comment->comment_date ?>
                            )</span>
                        </div>
                        <div class="review-content"><?= $comment->comment_content ?></div>
                        <div class="review-actions"></div>
                    </div>

                    <?php
                }

                echo '</div>';

            }
            ?> <div class='clear'></div>
            <br>



            <?php // Start the Loop.

            while ($query->have_posts()) : $query->the_post();


                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 *
                 */

                //get_template_part('template-parts/content', 'offer');

                // End the loop.
            endwhile;


            // Previous/next page navigation.
            the_posts_pagination(array(
                'prev_text' => __('Previous page', 'twentysixteen'),
                'next_text' => __('Next page', 'twentysixteen'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentysixteen') . ' </span>',
            ));

        // If no content, include the "No posts found" template.
        else :
            get_template_part('template-parts/content', 'none');

        endif;
        ?>

    </main>
    <!-- .site-main -->
</div><!-- .content-area -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>
