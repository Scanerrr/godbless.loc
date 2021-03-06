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


function add_offer_form($server_, $currency_, $alliance_, $price, $payment_systems, $website, $dopinfo)
{


    if (!is_user_logged_in()) {

//        echo "<h3>Добавление предложений доступно только для зарегистрированных пользователей</h3>";
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

    $user_level = get_user_meta($cur_user_id, 'level', true);

    global $wpdb;
    $sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'offer' AND post_status='publish' AND post_author=$cur_user_id;";
    $offers_count = $wpdb->get_var($sql);

    if (!current_user_can('administrator')) {
        if ($user_level < 3 && $offers_count >= 1) {

            echo "<h3>У вас закончился лимит добавления преложений (У вас добавлено $offers_count предложения)</h3>";
            return;
        }
    }

    if (isset ($_GET['game_id']) && $_GET['game_id'] > 0) {
        $game_id = $_GET['game_id'];
        echo '<header class="entry-header">
                <h1 class="entry-title">ADD OFFER</h1>
            </header>';

        $post = get_post($game_id);

        if ($post instanceof WP_Post) {

            $post_title = $post->post_title;
            echo "<h3 style='margin-top: 0'>GAME: $post_title </h3>";
            echo '
            <div class="unfreeze-registration">
            <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
            /***************** ВЫБОР СЕРВЕРА ****************/
            echo "<strong>SERVER: </strong>";
            $_servers = get_post_meta($game_id, '_servers', true);
            $_servers_unique = get_post_meta($game_id, '_servers_unique', true);

            if ($_servers_unique == 1) $servers_type = "radio";
            else $servers_type = "checkbox";

            $servers_list = explode(',', $_servers);
            if (is_array($servers_list) && count($servers_list) > 1) {

                ?>
                <dl class="dropdown" id="dropdown_server">
                    <dt>
                        <a href="#" onclick="return false;">
                            <?php if (!empty($server_)): ?>
                              <p class="multiSel">
                                  <?php foreach ($server_ as $item): ?>
                                      <span title="<?php echo $item ?>"><?php echo $item ?>,</span>
                                  <?php endforeach; ?>
                              </p>
                            <?php else: ?>
                                <span class="hida">Select server</span>
                                <p class="multiSel"></p>
                            <?php endif; ?>
                        </a>
                    </dt>

                    <dd>
                        <div class="mutliSelect">
                            <ul>
                <?php
                foreach ($servers_list as $s_key => $server) {

                    $checked = "";
                    if (is_array($server_) && in_array($server, $server_)) $checked = 'checked="1"';
                    elseif ($_servers_unique == 1 && $server == $server_) $checked = 'checked="1"';
                    if ($_servers_unique == 1) $server_input_name = 'server';
                    else $server_input_name = 'server[' . ($s_key + 1) . ']';

                    echo  '<li>';
                    echo ' <label for="server_' . ($s_key + 1) . '" class="selectit">
                    <input name="' . $server_input_name . '" type="' . $servers_type . '" id="server_' . ($s_key + 1) . '" value="' . $server . '" ' . $checked . ' >' . $server . ' </label>&nbsp;&nbsp;&nbsp;';
                    echo  '</li>';

                }
                ?>
                            </ul>
                        </div>
                    </dd>
                </dl>
                <?php
            } elseif ($_servers) {

                echo '<label for="server_0" class="selectit">
                    <input name="server" type="' . $servers_type . '" id="server_0"  checked="1" disable="true"  value="' . $_servers . '" >' . $_servers . '</label>';
            } else echo '<label for="server_0" class="selectit">
                    <input name="server" type="' . $servers_type . '" id="server_0" checked="1" disable value="Все сервера" >Все сервера</label>';

            /***************** ВЫБОР ВАЛЮТЫ ****************/

            echo "<br><strong>CURRENCY, ITEM OR SERVICE: </strong>";
            $_currencies = get_post_meta($game_id, '_currencies', true);


            $currencies_list = explode(',', $_currencies);
            if (is_array($currencies_list) && count($currencies_list) > 1) {
                ?>
                <dl class="dropdown" id="dropdown_currency">
                    <dt>
                        <a href="#" onclick="return false;">
                            <?php if (!empty($currency_)):
                                $currency_ = [$currency_] ?>
                              <p class="multiSel">
                                  <?php foreach ($currency_ as $item): ?>
                                      <span title="<?php echo $item ?>"><?php echo $item ?></span>
                                  <?php endforeach; ?>
                              </p>
                            <?php else: ?>
                                <span class="hida">Select currency</span>
                                <p class="multiSel"></p>
                            <?php endif; ?>
                        </a>
                    </dt>

                    <dd>
                        <div class="mutliSelect">
                            <ul>
                <?php
                foreach ($currencies_list as $c_key => $currency) {
                    if ($currency == $currency_[0]) $checked = 'checked="1"';
                    else $checked = "";
                    echo  '<li>';
                    echo "<label for='currency_" . ($c_key + 1) . "' class='selectit'>
                    <input name='currency' type='radio' id='currency_" . ($c_key + 1) . "' value='$currency' $checked>$currency</label>";
                    echo  '</li>';
                }
                ?>
                            </ul>
                        </div>
                    </dd>
                </dl>
                <?php
            } elseif ($_currencies) {
                echo '<label for="currency_0" class="selectit">
                    <input name="currency" type="radio" id="currency_0" checked="1" value="' . $_currencies . '" >' . $_currencies . '</label>';
            } else echo '<label for="currency_0" class="selectit">
                    <input name="currency" type="radio" id="currency_0" checked="1" value="Все сервера" >Все валюты</label>';


            /***************** ВЫБОР АЛЬЯНСА ****************/
            $_alliances_enable = get_post_meta($game_id, '_alliances_enable', true);
            if ($_alliances_enable) {
                echo "<br><strong>FRACTION: </strong>";
                $_alliances = get_post_meta($game_id, '_alliances', true);

                $_alliances_unique = get_post_meta($game_id, '_alliances_unique', true);

                if ($_alliances_unique == 1) $alliances_type = "radio";
                else $alliances_type = "checkbox";

                $alliances_list = explode(',', $_alliances);
                if (is_array($alliances_list) && count($alliances_list) > 1) {
                    ?>
                    <dl class="dropdown" id="dropdown_alliance">
                        <dt>
                            <a href="#" onclick="return false;">
                                <?php if (!empty($alliance_)):
                                    $alliance_ = [$alliance_]; ?>
                                  <p class="multiSel">
                                      <?php foreach ($alliance_ as $item): ?>
                                          <span title="<?php echo $item ?>"><?php echo $item ?></span>
                                      <?php endforeach; ?>
                                  </p>
                                <?php else: ?>
                                    <span class="hida">Select fraction</span>
                                    <p class="multiSel"></p>
                                <?php endif; ?>
                            </a>
                        </dt>

                        <dd>
                            <div class="mutliSelect">
                                <ul>
                    <?php
                    foreach ($alliances_list as $a_key => $alliance) {

                        $checked = "";
                        if (is_array($alliance_) && in_array($alliance, $alliance_)) $checked = 'checked="1"';
                        elseif ($_alliances_unique == 1 && $alliance == $alliance_) $checked = 'checked="1"';
                        if ($_alliances_unique == 1) $alliance_input_name = 'alliance';
                        else $alliance_input_name = 'alliance[' . ($a_key + 1) . ']';
                        echo  '<li>';
                        echo '<label for="alliance_' . ($a_key + 1) . '" class="selectit">
                            <input name=' . $alliance_input_name . '  type="' . $alliances_type . '" id="alliance_' . ($a_key + 1) . '" value="' . $alliance . '" ' . $checked . ' >' . $alliance . ' </label>';
                        echo  '</li>';
                    }
                    ?>
                                </ul>
                            </div>
                        </dd>
                    </dl>
                    <?php
                } elseif ($_alliances) {
                    echo '<label for="alliance_0" class="selectit">
                    <input name="alliance" type="' . $alliances_type . '" id="alliance_0" checked="1" value="' . $_alliances . '" >' . $_alliances . '</label>';
                } else echo '<label for="alliance_0" class="selectit">
                    <input name="alliance" type="' . $alliances_type . '" id="alliance_0" checked="1" value="Все сервера" >Все альянсы</label>';
            } else {
                $disabled_value = 'alliance_disabled';
                echo "<input name='alliance' type='hidden' id='alliance_disabled' value='$disabled_value'>";
            }


            echo '<div>
        <label for="price">AMOUNT FOR 1 $</label>
        <input type="text" name="price" value="' . (isset($_POST['price']) ? $price : null) . '">
        </div>

    <div>
        <label for="payment_systems">PAYMENT METHOD </label>';

            global $wpdb;
            $table_name = $wpdb->prefix . "unfreeze_merchants";
            $merchants = $wpdb->get_results("SELECT * FROM $table_name");
            ?>
            <dl class="dropdown" id="dropdown_payment">
                <dt>
                    <a href="#" onclick="return false;">
                        <?php if (!empty($payment_systems)):
                            $payment_systems = explode(',', $payment_systems);
                            ?>
                          <p class="multiSel">
                              <?php foreach ($payment_systems as $item): ?>
                                  <span title="<?php echo $item ?>"><?php echo $item ?>,</span>
                              <?php endforeach; ?>
                          </p>
                        <?php else: ?>
                            <span class="hida">Select payment method</span>
                            <p class="multiSel"></p>
                        <?php endif; ?>
                    </a>
                </dt>

                <dd>
                    <div class="mutliSelect">
                        <ul>
            <?php
            foreach ($merchants as $m_key => $merchant) {
                $merchant_id = $merchant->id;
                $merchant_name = $merchant->name;
                $checked = isset($_POST['merchant-toggle']) && in_array($merchant_name, $_POST['merchant-toggle']) ? " checked=1" : "";
                echo  '<li>';
                echo "<label for='merchant-toggle-$merchant_id' class='selectit'>
                            <input name='merchant-toggle[$merchant_id]'  type='checkbox' id='merchant-toggle-$merchant_id' value='$merchant_name' $checked >$merchant_name</label>";
                 echo  '</li>';
            }
            ?>
                        </ul>
                    </div>
                </dd>
            </dl>
            <?php

            echo '

    </div>


 <div>
         <label for="website">LINK</label>
        <input type="text" name="website" value="' . (isset($_POST['website']) ? $website : null) . '">
        </div>

        <div>
        <label for="dopinfo">OTHER INFORMATION</label>
        <textarea name="dopinfo">' . (isset($_POST['dopinfo']) ? $dopinfo : null) . '</textarea>
        </div>

        <div>
        <p><br>
        <img id=_captcha src="/captcha/?' . session_name() . '=' . session_id() . '"><br>
        <a href="./" onclick="document.getElementById(\'_captcha\').src = \'/captcha/?<?=session_name()?>=<?=session_id()?>&\'+Math.random(99999999999999999); return false;">
REFRESH</a><br>
        <label for="bio">CAPTCHA *</label>
        <input id="keystring" type="text" name="keystring"></p>
        </div>


        <button type="submit" name="submit" value="Register">Create</button>
        </form>
        </div>
        ';
            ?>



            <?php
        }
    } else {
        // игра не выбрана
        if (!isset($_GET)) {
            echo "<h3>Игра не выбрана.</h3>";
        }
        $games_query = new WP_Query(array('post_type' => 'game', 'post_status' => 'publish', 'nopaging' => true));

        if ($games_query->have_posts()) {
            ?>
            <form name="select_games" method="get">
                <label for="game_id">SELECT GAME</label>
                <select id="game_id" name="game_id">


                    <?php
                    while ($games_query->have_posts()) {
                        $games_query->the_post();
                        $game_title = get_the_title();
                        $game_id = get_the_ID();
                        echo "<option value='$game_id'>$game_title</option>";
                    }
                    ?>
                </select>
                <br><br>
                <button type="submit" name="submit">Next</button>
            </form>
            <?php
        } else {
            echo "<h3>Не найдено активных Игр!</h3>";
        }
        wp_reset_postdata();


    }
}


function add_offer_validation($server, $currency, $alliance, $price, $payment_systems, $website, $dopinfo)
{

    //echo "<pre>"; echo "</pre>";

    global $reg_errors;
    $reg_errors = new WP_Error;

    // Проверяем что был выбран хотя бы 1 сервер, затем валюта и альянс
    if (empty($server)) {
        $reg_errors->add('field', 'PLEASE ADD SERVER');
    }
    if (empty($currency)) {
        $reg_errors->add('field', 'PLEASE ADD CURRENCY');
    }
    if (empty($alliance) && $alliance !== 'alliance_disabled') {
        $reg_errors->add('field', 'PLEASE ADD FRACTION');
    }

    if (empty($price)) {
        $reg_errors->add('field', 'PLEASE ADD PRICE');
    }


    if (empty($payment_systems)) {
        $reg_errors->add('field', 'PLEASE ADD PAYMENT METHOD');
    }

    if (empty($website)) {
        $reg_errors->add('field', 'PLEASE ADD WEBSITE');
    }


    if (!empty($website)) {

        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $reg_errors->add('website', 'INVALID LINK');
        }
    }

    if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']) {
        //echo "Капача правильная";
    } else {
        $reg_errors->add('captcha', 'WRONG CAPTCHA');
    }
    unset($_SESSION['captcha_keystring']);


    if (is_wp_error($reg_errors)) {

        echo '<div class="registration-errors">';

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div>';
            echo '<span class="validation-error">' . $error . '</span>';
            echo '</div>';

        }
        echo '<div>';
    }
}


// Фактическое добавление офера
function add_offer_complete()
{
    global $reg_errors, $server, $currency, $alliance, $price, $payment_systems, $website, $dopinfo;
    if (1 > count($reg_errors->get_error_messages())) {

        $game_title = get_the_title($_GET['game_id']);

        $server_string = is_array($server) ? implode(",", $server) : $server;
        if ($alliance === 'alliance_disabled') $alliance = '';
        $alliance_string = is_array($alliance) ? implode(",", $alliance) : $alliance;


        $post_data = array(
            'post_title' => "Game $game_title. Price: $price ( $server_string | $currency | $alliance_string )",
            'post_content' => $dopinfo,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type' => 'offer'
        );

        // Вставляем запись в базу данных
        $offer_post_id = wp_insert_post($post_data);

        // Обновляем признак игры
        $offer_meta_id = update_post_meta($offer_post_id, 'game_id', intval(sanitize_text_field($_GET['game_id'])));
        update_post_meta($offer_post_id, 'server', $server_string);
        update_post_meta($offer_post_id, 'currency', $currency);
        update_post_meta($offer_post_id, 'alliance', $alliance_string);
        update_post_meta($offer_post_id, 'price', $price);
        update_post_meta($offer_post_id, 'payment_systems', $payment_systems);
        update_post_meta($offer_post_id, 'website', $website);

        update_post_meta($offer_post_id, 'dopinfo', $dopinfo);


        if ($offer_post_id && $offer_meta_id) {
            echo "<h4>Offer created ID $offer_post_id </h4>";
        }
    }
}

// Вызываем функцию рисования формы, предварительно заполнив переменные если есть
function add_offer_form_function()
{
    if (isset($_POST['submit']) && $_GET['game_id']) {


        global $server, $currency, $alliance, $price, $payment_systems, $website, $dopinfo;


        //$payment_systems = sanitize_text_field($_POST['payment_systems']);


        if (is_array($_POST['merchant-toggle']) && count($_POST['merchant-toggle']) > 0) {
            $payment_systems = implode(',', $_POST['merchant-toggle']);
        }

        $server = $_POST['server'];
        $currency = $_POST['currency'];
        $alliance = $_POST['alliance'];

        $price = str_replace(',', '.', $_POST['price']);
        $price = (floatval($price));


        $website = esc_url($_POST['website']);
        $dopinfo = sanitize_text_field($_POST['sdopinfo']);

        add_offer_validation(

            $server,
            $currency,
            $alliance,
            $price,
            $payment_systems,
            $website,
            $dopinfo
        );


        // sanitize user form input


        // call @function complete_registration to create the user
        // only when no WP_error is found

        add_offer_complete(
            $server,
            $currency,
            $alliance,
            $price,
            $payment_systems,
            $website,
            $dopinfo
        );

    }

    add_offer_form(
        $server,
        $currency,
        $alliance,
        $price,
        $payment_systems,
        $website,
        $dopinfo
    );
}

add_shortcode('add_offer', 'unfreeze_add_offer');

// The callback function that will replace [book]
function unfreeze_add_offer()
{
    ob_start();
    add_offer_form_function();
    return ob_get_clean();
}