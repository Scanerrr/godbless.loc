<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 25.10.2016
 * Time: 10:44
 */
/*
 *
$user_id
$game_id

$servers
$currency
$alliances
$price
$payment_systems
$website
$dopinfo


 *
 */


// Вызываем функцию рисования формы, предварительно заполнив переменные если есть
function add_review_function()
{
    global $wpdb;
    $user =  isset ($_GET['user_id']) ? get_user_by( 'ID', $_GET['user_id']) : null ;
    if ($user instanceof  WP_User) {
        // print_pre($user);
        $user_id = $user->ID;
        $user_login = $user->user_login;
        $sql = "SELECT ID FROM wp_posts WHERE post_type = 'offer' and post_author = $user_id ORDER BY  wp_posts.ID DESC LIMIT 0 , 1";
        $last_offer_id = $wpdb->get_var($sql);
        $commenter = wp_get_current_commenter();
        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html_req = ( $req ? " required='required'" : '' );
        $html5 = true;

        $avatar_url = get_avatar_url($user->ID, array(
            'size' => 128,
            'default' => 'identicon',
        ));

        ?>
        <div class="user_info" style="border-bottom: none">
            <div class="user_info-column-1">
                <img src="<?= $avatar_url ?>" height="64px" width="64px"/>
            </div>
            <div class="user_info-column-2">
                <dl>
                    <!--<dt>Обменник</dt>-->
                    <dd style="font-size: 20px"><b><?php echo $user->user_login; ?></b></dd>
                    <!--<dt>Website</dt>-->
                    <dd><a href="<?php echo $user->user_url; ?>"><?php echo $user->user_url; ?></a></dd>
                    <!--<dt>Profile</dt>-->
                    <dd><?php echo $user->user_description; ?></dd>
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
        <div style="clear: both"></div>
        <?php
        $logedin_user_id = get_current_user_id();
        // forbid to review user by the same user
        if ($logedin_user_id === $user->ID) {
            echo "<h3>The user cannot leave a feedback about yourself.</h3>";
            return;
        }

        if ( $last_offer_id  ) {
            // Выводим формуц комента по данному оферу
            $args = [
                'title_reply_before' => '',
                'title_reply_after'  => '',
                'logged_in_as'         =>  '',
                'title_reply'          => 'LEAVE FEEDBACK',
                'label_submit'         => 'Send',
                'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'Вы должны войти <a href="%s">войти</a> чтобы оставить отзыв.' ), wp_login_url( $_SERVER['REQUEST_URI'] ) ) . '</p>',
                // '<p class="logged-in-as">' . sprintf( __( '<a href="%1$s" aria-label="Logged in as %2$s. Edit your profile.">Logged in as %2$s</a>. <a href="%3$s">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
              /*
                'fields'               => array(
                    'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>',
                    'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
                    'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                        '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
                )
              */
            ];
            comment_form( $args, $last_offer_id );


        } else {
            echo "<h3>У пользователя $user_login еще нет предложений.</h3>";
        }


    } else {
        // нет выбрал пользователь
        echo "<h3>Для того чтобы оставить отзыв выберите пользователя</h3>";
    }


}

add_shortcode('add_review', 'unfreeze_add_review');

// The callback function that will replace [book]
function unfreeze_add_review()
{
    ob_start();
    add_review_function();
    return ob_get_clean();
}

function wpse_58613_comment_redirect( $location ) {
    if ( isset( $_POST['redirect_to'] ) ) // Don't use "redirect_to", internal WP var
        $location = $_POST['redirect_to'];

    return $location;
}

add_filter( 'comment_post_redirect', 'wpse_58613_comment_redirect' );