<?php
/**
 * Created by PhpStorm.
 * User: d.denisov
 * Date: 09.12.2016
 * Time: 17:53
 */


ob_start();
require(dirname(__FILE__) . '/wp-load.php');


global $wpdb;


if (isset($_POST['data'])) {


    $data = base64_decode($_POST['data']);
    $data = json_decode($data, true);

    if ( $data['public_key'] == 'i42010176483'  ) {

        $table_name = $wpdb->get_blog_prefix() . 'unfreeze_payments';

        print_r($data);

        $wpdb->insert(
            $table_name,
            array(
                'payment_id' => $data['payment_id'],
                'status' => $data['status'],
                'err_code' => $data['err_code'],
                'err_description' => $data['err_description'],
                'order_id' => $data['order_id'],
                'description' => $data['description'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'create_date' => $data['create_date'],
                'code' => $data['code'],
                'customer' => $data['customer']
            )

            //array( '%s', '%s', '%f', '%s' )
        );





        $rez = ob_get_clean();

        echo $rez;
        mail("denisov.dmitriy@gmail.com", "godbless", $rez);

    }


}

// 5168755522929757 card