<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 26.10.2016
 * Time: 14:26
 */


add_shortcode('offers_list', 'render_offers_shortcode');

function render_offers_shortcode()
{
    ob_start();


    if (!is_user_logged_in()) {

        echo "<h3>Обмен доступна только для зарегистрированных пользователей</h3>";
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
            'label_username' => __('EMAIL OR LOGIN'),
            'label_password' => __('PASSWORD'),
            'label_remember' => __('Forgot your password?'),
            'label_log_in' => __('Sign In'),
            'value_username' => '',
            'value_remember' => false
        );
        wp_login_form($args);
        echo '<a href="/registration/"><button tybe="button">Sign Up</button></a>';
        echo '</div>';*/
        return;
    }

    $cur_author = wp_get_current_user();

    // Удаление
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $offer_id = isset($_GET['offer_id']) ? $_GET['offer_id'] : null;

    if ($action == 'delete' && isset($_GET['offer_id'])) {

        // Удаление офера
        $delete_result = wp_delete_post($offer_id, true); // Полное удаление
        //var_dump ( $delete_result );
        if ($delete_result) echo "<p>Предложение №$offer_id удалено!</p>";
        else echo "<p>Ошибка при удалении предложения №$offer_id</p>";
    }

    //  скрыть офер
    if ($action == 'hide' && isset($_GET['offer_id'])) {
        // отправить офер в корзину
        $hide_result = wp_trash_post($offer_id); // поместить в корзину
        if ($hide_result) echo "<p>Предложение №$offer_id скрыто в корзину.</p>";
        else  echo "<p>Ошибка отправки предложения №$offer_id в корзину.</p>";
    }

    //  скрыть выбранные оферы
    if ($action == 'hide_selected' && isset($_GET['offer_id'])) {

        if (is_array( $_GET['offer_id'] )) $offer_ids = $_GET['offer_id'];
        else $offer_ids = array ( $_GET['offer_id'] => 'on' );

        $post_in = array();
        foreach ($offer_ids as $offer_key=>$offer_value) {
            $post_in[]=$offer_key;
        }

        $args = array('post_type' => 'offer', 'post_status' => 'publish', 'nopaging' => true, 'author' => $cur_author->ID, 'post__in' => $post_in );
        $offers_to_trash = get_posts($args);
        if (count($offers_to_trash)) {

            echo "<p>";
            foreach ($offers_to_trash as $offer) {
                $hide_result = wp_trash_post($offer->ID); // поместить в корзину
                echo "<br>Скрыто предложение № $offer->ID / $offer->post_title ";
            }
            echo "</p>";
        } else echo "<p>Не выбрано предложений чтобы скрыть</p>";

    }

    //  скрыть все офферы
    if ($action == 'hide_all') {
        // отправить офер в корзину
        $args = array('post_type' => 'offer', 'post_status' => 'publish', 'nopaging' => true, 'author' => $cur_author->ID);

        $offers_to_trash = get_posts($args);
        if (count($offers_to_trash)) {

            echo "<p>";
            foreach ($offers_to_trash as $offer) {
                $hide_result = wp_trash_post($offer->ID); // поместить в корзину
                echo "<br>Скрыто предложение № $offer->ID / $offer->post_title ";
            }
            echo "</p>";
        } else echo "<p> У вас нет активных предложений</p>";
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

    // клонировать офер
    if ($action == 'clone' && isset($_GET['offer_id'])) {

        $cur_offer = get_post($offer_id);
        //  print_pre( $cur_offer);

        $post_data = array(
            'post_title' => $cur_offer->post_title . " (копия)",
            'post_content' => $cur_offer->post_content,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type' => 'offer'
        );

        // Вставляем запись в базу данных
        $offer_post_id = wp_insert_post($post_data);

        // Обновляем признак игры
        $offer_meta_id = update_post_meta($offer_post_id, 'game_id', get_post_meta($offer_id, 'game_id', true));

        update_post_meta($offer_post_id, 'server', get_post_meta($offer_id, 'server', true));
        update_post_meta($offer_post_id, 'currency', get_post_meta($offer_id, 'currency', true));
        update_post_meta($offer_post_id, 'alliance', get_post_meta($offer_id, 'alliance', true));
        update_post_meta($offer_post_id, 'price', get_post_meta($offer_id, 'price', true));
        update_post_meta($offer_post_id, 'payment_systems', get_post_meta($offer_id, 'payment_systems', true));
        update_post_meta($offer_post_id, 'website', get_post_meta($offer_id, 'website', true));
        update_post_meta($offer_post_id, 'dopinfo', get_post_meta($offer_id, 'dopinfo', true));


        if ($offer_post_id && $offer_meta_id) echo "<p>Предложение №$offer_id склонировано. Код копии $offer_post_id </p>";
        else echo "<p>Ошибка при клонировании предложения №$offer_id </p>";

    }

    // Инфо о себе
    $avatar_url = get_avatar_url($cur_author->ID, array(
        'size' => 128,
        'default' => 'identicon',
    ));

    ?>


    <div id="delete_dialog" title="Удаление предложения">
        <p>Вы собирайтесь удалить предложение. Вы уверены?
        </p>
    </div>




    <form method="get">
    <div class="user_info">
        <div class="user_info-column-1">
            <img src="<?= $avatar_url ?>" height="64px" width="64px"/>
        </div>
        <div class="user_info-column-2">
            <dl>
                <!--<dt>Сайт</dt>-->
                <dd><a href="<?php echo $cur_author->user_url; ?>"><?php echo $cur_author->user_url; ?></a></dd>



                <!--<dt>Изменить данные профиля</dt>-->
                <dd><a href="<?php echo admin_url('profile.php'); ?>">
                        <button type="button">Edit</button>
                    </a>&nbsp;&nbsp;&nbsp;
                    <!-- <a href='http://godblessgamers.com/payments/'><button >К оплате</button></a> -->
                </dd>

            </dl>
        </div>
        <div class="user_info-column-3">
            <dl>
                <!--<dt>Описание</dt>-->
                <dd><!--<hr>--><?php echo $cur_author->user_description; ?></dd>
            </dl>
        </div>
        <div class="clear"></div>
        <div class="exchange-buttons">

                <a href="/add_offer">
                    <button type="button">Create new</button>
                </a>

                <button name="action" value="hide_all" type="submit">Hide all</button>


                <button name="action" value="hide_selected">Hide chosen</button>

                <button name="action" value="restore_all" type="submit">Up all hidden</button>
                <a href="/restore_selected">
                    <button name="action" value="restore_selected" type="button">Show hidden</button>
                </a>
        </div>


    </div>
    <?php
    // строим таблицу с оферами

    echo "<div class='game-offers-table'>";
    echo do_shortcode("[wpdatatable id=9]");
    echo "</div></form>";

    return ob_get_clean();
}





