<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 25.10.2016
 * Time: 10:44
 */

function showUserStatistic()
{
    if (!is_user_logged_in()) {

        echo "<h3>Статистика доступна только для зарегистрированных пользователей</h3>";
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


    $current_user = wp_get_current_user();
    $cur_user_id = $current_user->ID;


    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_clicks';

    $sql = "SELECT count(*) as clicks FROM `$table_name`
    INNER JOIN ( SELECT * FROM `wp_posts` WHERE wp_posts.post_author = $cur_user_id ) as all_posts
    ON wp_unfreeze_clicks.offer_id = all_posts.ID";

    $clicks_count = $wpdb->get_var($sql);

    $kurs = get_option('unfreeze-option-click-cost');
    $sum = $clicks_count * $kurs;
    $paid = round( $wpdb->get_var ("SELECT SUM(`amount` ) FROM  `wp_unfreeze_payments` WHERE `customer`= $cur_user_id AND  `status` = 'success' "), 2 );
    $to_pay = round ( $sum - $paid , 2 );

    //wp_list_authors();

    echo "Your offers has <b>$clicks_count views</b><br>";

    /*
    echo "Ваша стоимость одного перехода \$$kurs. <br>
             Совершено переходов на  сумму: <b>\$$sum </b> Оплачено: <b>\$$paid</b><br><br>";



    if ( $to_pay > 0 ) echo "К выплате: \$$to_pay <br>" ;
     else echo "Ваш баланс положительный <br>";


    echo "<a href='/payments'> <button >К оплате</button></a>";
    */



    echo do_shortcode('[wpdatatable id=8]');

    //echo do_shortcode('[wpdatatable id=15]');

}


add_shortcode('unfreeze_statistics', 'unfreeze_statistics_shortcode');



// The callback function that will replace [book]
function unfreeze_statistics_shortcode()
{
    ob_start();
    showUserStatistic();
    return ob_get_clean();
}