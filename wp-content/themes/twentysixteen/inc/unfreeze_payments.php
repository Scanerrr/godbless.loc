<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 25.10.2016
 * Time: 10:44
 */

function show_payments_page()
{
    global $checkout_public_key, $checkout_private_key;
    if (!is_user_logged_in()) {

        echo "<h3>Статистика доступна только для зарегистрированных пользователей</h3>";

        $args = array(
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
            'label_log_in' => __('Log In'),
            'value_username' => '',
            'value_remember' => false
        );
        wp_login_form($args);
        return;
    }

    $current_user = wp_get_current_user();
    $cur_user_id = $current_user->ID;


    global $wpdb;

    global $liqpay_public_key, $liqpay_private_key;

    require_once ("LiqPay.php");
    $liqpay = new LiqPay($liqpay_public_key, $liqpay_private_key);

    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_clicks';

    $sql = "SELECT count(*) as clicks FROM `$table_name`
    INNER JOIN ( SELECT * FROM `wp_posts` WHERE wp_posts.post_author = $cur_user_id ) as all_posts
    ON wp_unfreeze_clicks.offer_id = all_posts.ID";

    $clicks_count = $wpdb->get_var($sql);

    $kurs = get_option('unfreeze-option-click-cost');
    $sum = $clicks_count * $kurs;
    $paid = round( $wpdb->get_var ("SELECT SUM(`amount` ) FROM  `wp_unfreeze_payments` WHERE `customer`= $cur_user_id AND  `status` = 'success' "), 2 );
    $to_pay = round ( $sum - $paid, 2 );

    //var_dump($to_pay);



    //wp_list_authors();

    echo "По вашим предложениям было совершено <b>$clicks_count переходов</b><br>
             Ваша стоимость одного перехода \$$kurs. <br>
             Совершено переходов на  сумму: <b>\$$sum </b> Оплачено: <b>\$$paid</b><br><br>";

    if ( $to_pay > 0 ) {
        echo "К выплате: \$$to_pay <br><br>" ;
        $description =  "Clicks payment Count: $clicks_count. ";

        // 5168755522929757 card
        echo $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => $to_pay,
            'currency'       => 'USD',
            'description'    => $description,
            //'order_id'       => 'order_id_1',
            'version'        => '3',
            'bnt_title'      => "Pay in USD ($to_pay)",
            'result_url' => 'http://godblessgamers.com/payment_status/',
            'language' => 'en',
            'customer' => $cur_user_id,
            //'sandbox' => '1'

        ));

    } else {
        echo "Ваш баланс пложительный. Можете оплатить 1000 переходов авансом." ;

        $to_pay_avans = $kurs * 1000;
        $description =  "Clicks payment Count: 1000. ";

        // 5168755522929757 card
        echo $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => $to_pay_avans,
            'currency'       => 'USD',
            'description'    => $description,
            //'order_id'       => 'order_id_1',
            'version'        => '3',
            'bnt_title'      => "Pay in USD (\$$to_pay_avans)",
            'result_url' => 'http://godblessgamers.com/payment_status/',
            'language' => 'en',
            'customer' => $cur_user_id,
            //'sandbox' => '1'

        ));
    }








    //echo "<h3>История оплат</h3>";

    echo do_shortcode('[wpdatatable id=15]');

    /*
    echo "<br>";

    echo $liqpay->cnb_form(array(
        'action'         => 'pay',
        'amount'         => $sum_uah,
        'currency'       => 'UAH',
        'description'    => $description,
        //'order_id'       => 'order_id_1',
        'version'        => '3',
        'bnt_title'      => "Оплатить в гривне ($sum_uah)",
        'result_url' => 'http://godblessgamers.com/payment_status/'

    ));
    ;


    echo "<br>";

    echo $liqpay->cnb_form(array(
        'action'         => 'pay',
        'amount'         => $sum_uah,
        'currency'       => 'UAH',
        'description'    => $description,
        //'order_id'       => '123123123123453453452342',
        'version'        => '3',
        'bnt_title'      => "Денисов тест грн ($sum_uah)",
        'result_url' => 'http://godblessgamers.com/payment_status/',
        'customer' => $cur_user_id,
        'sandbox' => 1,
        'language' => 'en'



    ));
       // 5168755522929757 card
    */





}


add_shortcode('unfreeze_payments', 'unfreeze_payments_shortcode');


// The callback function that will replace [book]
function unfreeze_payments_shortcode()
{


    ob_start();
    show_payments_page();
    return ob_get_clean();
}