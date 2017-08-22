<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 25.10.2016
 * Time: 10:44
 */

function unfreeze_redirect_function(){
 
    $url_redirect = $_GET['url'];
    $offer_id = $_GET['id'];

    $clicks = get_post_meta($offer_id, 'click', false );

    $moment = date('Y-m-d G:i:s');


    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_clicks';
    $insert = $wpdb->insert($table_name, ['offer_id' => $offer_id, 'click_time' => $moment]);




    if ($url_redirect) {
        ?>
        <p>Браузер будет отправлен на сайт <a href="<?php echo $url_redirect; ?>"><?php echo $url_redirect; ?></a> через несколько секунд…
        </p>
        <script language="JavaScript">
            function redirect(){
                window.location.replace("<?php echo $url_redirect; ?>");
            }
            setTimeout(redirect, 3000)


        </script>
        <?php
    }


}

add_shortcode('unfreeze_redirect', 'unfreeze_redirect_shortcode');

// The callback function that will replace [book]
function unfreeze_redirect_shortcode()
{
    ob_start();
    unfreeze_redirect_function();
    return ob_get_clean();
}