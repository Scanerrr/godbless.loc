<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 26.10.2016
 * Time: 14:26
 */


add_shortcode('restore_selected', 'unfreeze_restore_selected');

function unfreeze_restore_selected()
{
    ob_start();


    if (!is_user_logged_in()) {

        echo "<h3>Страницы доступна только для зарегистрированных пользователей</h3>";
        $redirect_url = (is_ssl()? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        echo do_shortcode("[custom-login-form redirect=" . $redirect_url . "]");
        /*$args = array(
            'echo' => true,
            'remember' => true,
            'redirect' => (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'form_id' => 'loginform',
            'id_username' => 'user_login',
            'id_password' => 'user_pass',
            'id_remember' => 'rememberme',
            'id_submit' => 'wp-submit',
            'label_username' => __('Username'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in' => __('Sign In'),
            'value_username' => '',
            'value_remember' => false
        );
        wp_login_form($args);*/
        return;
    }

    $cur_author = wp_get_current_user();

    // Удаление
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $offer_id = isset($_GET['offer_id']) ? $_GET['offer_id'] : null;

    if ($action == 'no_confirm_delete' && isset($_GET['offer_id'])) {

        // Удаление офера
        $delete_result = wp_delete_post($offer_id, true); // Полное удаление
        //var_dump ( $delete_result );
        if ($delete_result) echo "<p>Предложение №$offer_id удалено!</p>";
        else echo "<p>Ошибка при удалении предложения №$offer_id</p>";
    }




    //  восстановить все оферы
    if ($action == 'restore_all') {
        //
        $args = array('post_type' => 'offer', 'post_status' => 'trash', 'nopaging' => true, 'author' => $cur_author->ID);

        $offers_to_trash = get_posts($args);

        if (count($offers_to_trash)) {
            echo "<p>";
            foreach ($offers_to_trash as $offer) {
                $temp_query = array(
                    'ID' => $offer->ID,
                    'post_status' => 'publish',
                );
                $restore_result = wp_update_post($temp_query, true);
                if ($restore_result) echo "<br>Восстановлено предложение / № $offer->ID / $offer->post_title ";

            }
            echo "</p>";
        } else echo "<p> У вас нет скрытых предложений!</p>";
    }

    if ($action == 'restore_selected' && isset($_GET['offer_id'])) {

        if (is_array( $_GET['offer_id'] )) $offer_ids = $_GET['offer_id'];
        else $offer_ids = array ( $_GET['offer_id'] => 'on' );

        $post_in = array();
        foreach ($offer_ids as $offer_key=>$offer_value) {
            $post_in[]=$offer_key;
        }

        $args = array('post_type' => 'offer', 'post_status' => 'trash', 'nopaging' => true, 'author' => $cur_author->ID, 'post__in' => $post_in );
        $offers_to_trash = get_posts($args);
        if (count($offers_to_trash)) {

            echo "<p>";
            foreach ($offers_to_trash as $offer) {


                $temp_query = array(
                    'ID' => $offer->ID,
                    'post_status' => 'publish',
                );

                $restore_result = wp_update_post($temp_query, true);
                if ($restore_result) echo "<br>Восстановлено предложение / $offer->ID / $offer->post_title ";

            }
            echo "</p>";
        } else echo "<p>Не найдено предложение для восстановления</p>";

    } else echo "<p>Не выбраны предложения чтобы восстановить</p>";



    if( $action == 'restore') {

        //$offer_id
        $temp_query = array(
            'ID' => $offer_id,
            'post_status' => 'publish',
        );

        $restore_result = wp_update_post($temp_query, true);
        if ($restore_result) echo "<br>Восстановлено предложение № $offer_id ";
    }

    ?>






    <form method="get">

    <div class="exchange-buttons">


        <a href="/myoffers">
            <button name="action" value="restore_selected" type="button">Show active</button>
        </a>

        <button name="action" value="restore_selected" type="submit"">Up chosen</button>

        <button name="action" value="restore_all" type="submit">Up all</button>

    </div>

    <?php
    // строим таблицу с оферами

    echo "<div class='game-offers-table'>";
    echo do_shortcode("[wpdatatable id=14]");
    echo "</div></form>";

    return ob_get_clean();
}





