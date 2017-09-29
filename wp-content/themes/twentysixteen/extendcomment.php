<?php
/**
 * Created by PhpStorm.
 * User: margo
 * Date: 13.11.2016
 * Time: 12:08
 */

// Add custom meta (ratings) fields to the default comment form
// Default comment form includes name, email address and website URL
// Default comment form elements are hidden when user is logged in

/*
add_filter('comment_form_default_fields', 'custom_fields');
function custom_fields($fields)
{

    //Этот набор полей показывается не залогиненым пользователям

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $fields['author'] = '<p class="comment-form-author">' .
        '<label for="author">' . __('Name') . '</label>' .
        ($req ? '<span class="required">*</span>' : '') .
        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
        '" size="30" tabindex="1"' . $aria_req . ' /></p>';

    $fields['email'] = '<p class="comment-form-email">' .
        '<label for="email">' . __('Email') . '</label>' .
        ($req ? '<span class="required">*</span>' : '') .
        '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) .
        '" size="30"  tabindex="2"' . $aria_req . ' /></p>';

    $fields['url'] = '<p class="comment-form-url">' .
        '<label for="url">' . __('Website') . '</label>' .
        '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
        '" size="30"  tabindex="3" /></p>';

    $fields['phone'] = '<p class="comment-form-phone">' .
        '<label for="phone">' . __('Phone') . '</label>' .
        '<input id="phone" name="phone" type="text" size="30"  tabindex="4" /></p>';


    return $fields;
}
*/

add_action('comment_form_logged_in_after', 'additional_fields'); // доп поля для залогиненых
add_action('comment_form_after_fields', 'additional_fields'); // доп поля для не залогиненых


function additional_fields()
{
    $user_id = $_GET['user_id'];
    if ($user_id) $redirect_url = "/?author=$user_id";
    else $redirect_url = "/";


    echo '
        <input type="hidden" name="redirect_to" value="'.$redirect_url.'"/>
        <p class="comment-form-rating">' .
        '<label for="rating">Rating<span class="required">*</span></label>
  <span class="commentratingbox">';

    global $review_ratings;

    //Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
    for ($i = 0; $i < count ($review_ratings); $i++) {
        echo '<label for="rating_'.$i.'" class="commentrating">
                    <input name="rating" type="radio" id="rating_'.$i.'"  value="' . $i . '" >' . $review_ratings[$i] . '</label>';
    }

    echo '</span></p>';


}

add_action('comment_post', 'save_comment_meta_data');

function save_comment_meta_data($comment_id)
{
    $offer_id = !isset($_POST['comment_post_ID']) ?: $_POST['comment_post_ID'];
    if ((isset($_POST['rating'])) && ($_POST['rating'] != '')) {
        $rating = wp_filter_nohtml_kses($_POST['rating']);
        add_comment_meta($comment_id, 'rating', $rating);
        add_comment_counter($offer_id, $rating);
    }
}



// Add the comment meta (saved earlier) to the comment text
// You can also output the comment meta values directly to the comments template

add_filter( 'comment_text', 'modify_comment');
function modify_comment( $text ){


    if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
        global $review_ratings;
        $rating = $review_ratings [ $commentrating ];
        $commentrating = '<p class="comment-rating"> Рейтинг отзыва: <strong>'. $rating .' </strong></p>';
        $text = $text . $commentrating;
        return $text;
    } else {
        return $text;
    }
}

// Add an edit option to comment editing screen

add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Рейтинг отзыва' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function extend_comment_meta_box ( $comment ) {

    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>


    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
      <span class="commentratingbox">
      <?php
      global $review_ratings;
      for ($i = 0; $i < count ($review_ratings); $i++) {
          $checked = $rating == $i ? " checked=1 " : "";
          echo '<label for="rating_'.$i.'" class="commentrating">
                    <input name="rating" type="radio" id="rating_'.$i.'"  value="' . $i . '" '.$checked.'>' . $review_ratings[$i] . '</label>';
      }

      ?>
      </span>
    </p>
    <?php
}


// Update comment meta data from comment editing screen

add_action( 'edit_comment', 'extend_comment_edit_metafields' );

function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;




    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
        $rating = wp_filter_nohtml_kses($_POST['rating']);
        update_comment_meta( $comment_id, 'rating', $rating );
    else :
        delete_comment_meta( $comment_id, 'rating');
    endif;

}

function add_comment_counter($offer_id, $rating = 0) {
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_comments_count';
    $data = $wpdb->get_results($wpdb->prepare(
        "SELECT ID, offer_ID, comments, comments_positive, 
                    comments_negative, comments_neutral
               FROM {$table_name} WHERE offer_ID = %s", $offer_id));
    switch ($rating){
        case 0:
            $rating = 'neutral';
            break;
        case 1:
            $rating = 'positive';
            break;
        case 2:
            $rating = 'negative';
            break;
    }
    if ($data) {
        $data = $data[0];
        $data->comments = intval($data->comments);
        $data->comments_positive = intval($data->comments_positive);
        $data->comments_negative = intval($data->comments_negative);
        $data->comments_neutral = intval($data->comments_neutral);
        $res = $wpdb->update($table_name, [
            'offer_ID' => $offer_id,
            'comments' => ++$data->comments,
            'comments_positive' => ($rating == 'positive') ? ++$data->comments_positive : $data->comments_positive,
            'comments_negative' => ($rating == 'negative') ? ++$data->comments_negative : $data->comments_negative,
            'comments_neutral' => ($rating == 'neutral') ? ++$data->comments_neutral : $data->comments_neutral
        ], ['ID' => $data->ID]);
    } else {
        $counter = 0;
        $res = $wpdb->insert($table_name, [
            'offer_ID' => $offer_id,
            'comments' => 1,
            'comments_positive' => ($rating == 'positive') ? 1 : $counter,
            'comments_negative' => ($rating == 'negative') ? 1 : $counter,
            'comments_neutral' => ($rating == 'neutral') ? 1 : $counter
        ]);
    }
    return $res;
}