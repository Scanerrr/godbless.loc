<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 26.10.2016
 * Time: 14:03
 */


/********** POST TYPE GAME *******************/

function custom_post_game() {
    $labels = array(
        'name'               => 'Игры',
        'singular_name'      => 'Игра',
        'add_new'            => 'Добавить игру',
        'add_new_item'       => 'Добавить новую Игру',
        'edit_item'          => 'Редактировать игру',
        'new_item'           => 'Новая игра',
        'all_items'          => 'Все игры',
        'view_item'          => 'Посомтреть игру',
        'search_items'       => 'Поиск игр',
        'not_found'          => 'Игр не найдено',
        'not_found_in_trash' => 'В корзине игр не найдено',
        'parent_item_colon'  => '',
        'menu_name'          => 'Игры',

    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Содержит описание Игр для торговли игровой валюты',
        'public'        => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-shield',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'   => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'register_meta_box_cb' => 'add_game_metaboxes'

    );
    register_post_type( 'game', $args );
}
add_action( 'init', 'custom_post_game' );


add_action( 'add_meta_boxes', 'add_game_metaboxes' );

function add_game_metaboxes(){
    add_meta_box('game_servers', 'Игровые сервера', 'unfreeze_game_servers', 'game', 'side', 'default');
    add_meta_box('game_currencies', 'Валюты', 'unfreeze_game_currencies', 'game', 'side', 'default');
    add_meta_box('game_alliances', 'Альянсы', 'unfreeze_game_alliances', 'game', 'side', 'default');
    add_meta_box('game_table_type', 'Шаблон данных игры', 'unfreeze_game_template', 'game', 'side', 'default');
}

function unfreeze_game_servers() {

    global $post;
    echo '<input type="hidden" name="game_meta_noncename" id="game_meta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Список доступных серверов
    $servers = get_post_meta($post->ID, '_servers', true);


    $servers_list = explode (',', $servers);

    if(is_array($servers_list) && count ($servers_list)) {
        echo '<textarea name="_servers" class="widefat" >';
        foreach ($servers_list as $s_key=>$server) {
            echo $server;
            if ( $s_key != count($servers_list) -1 ) echo "\n";
        }
        echo '</textarea>';
    } else {
        echo '<textarea name="_servers" class="widefat" >' . $servers . '</textarea>';
    }

    // Должен ли быть сервер выбран только один или произвольное количество
    $servers_unique = get_post_meta($post->ID, '_servers_unique', true);
    $servers_unique_checked = $servers_unique ? "checked" : "";
    $servers_multi_checked = ( $servers_unique == "" || $servers_unique == 0 )  ? "checked" : "";

    echo '<p><input type="radio" name="_servers_unique" value="1" ' . $servers_unique_checked . '>Один Сервер в предложении<Br>
    <input type="radio" name="_servers_unique" value="0" ' . $servers_multi_checked . '>Много Серверов в предложение</p>';

}

function unfreeze_game_currencies() {
    global $post;
    echo '<input type="hidden" name="game_meta_noncename" id="game_meta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    $currencies = get_post_meta($post->ID, '_currencies', true);
    $currencies_list = explode (',', $currencies);

    if(is_array($currencies_list) && count ($currencies_list)) {
        echo '<textarea name="_currencies" class="widefat" >';
        foreach ($currencies_list as $c_key=>$currency) {
            echo $currency;
            if ( $c_key != count($currencies_list) -1 ) echo "\n";
        }
        echo '</textarea>';
    } else {
        echo '<textarea name="_currencies" class="widefat" >' . $currencies . '</textarea>';
    }
}
function unfreeze_game_alliances() {
    global $post;
    echo '<input type="hidden" name="game_meta_noncename" id="game_meta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    $alliances = get_post_meta($post->ID, '_alliances', true);
    $alliances_list = explode (',', $alliances);

    $_alliances_enable = get_post_meta($post->ID, '_alliances_enable', true);
    $alliances_enable_checked = $_alliances_enable ? " checked=\"1\" " : "";

    echo '<p>Альянсы включены <input onclick=\"alert(this.value)\" type="checkbox" id="_alliances_enable" name="_alliances_enable" '.$alliances_enable_checked.'/></p> ';

    if(is_array($alliances_list) && count ($alliances_list)) {
        echo '<textarea name="_alliances" class="widefat" >';
        foreach ($alliances_list as $a_key=>$alliance) {
            echo $alliance;
            if ( $a_key != count($alliances_list) -1 ) echo "\n";
        }
        echo '</textarea>';
    } else {
        echo '<textarea name="_alliances" class="widefat" >' . $alliances . '</textarea>';
    }

    $alliances_unique = get_post_meta($post->ID, '_alliances_unique', true);
    $alliances_unique_checked = $alliances_unique ? "checked" : "";
    $alliances_multi_checked = ( $alliances_unique == "" || $alliances_unique == 0 )  ? "checked" : "";

    echo '<p><input type="radio" name="_alliances_unique" value="1" ' . $alliances_unique_checked . '>Один Альянс в предложении<Br>
    <input type="radio" name="_alliances_unique" value="0" ' . $alliances_multi_checked . '>Много Альянсов в предложении</p>';

}

function unfreeze_game_template() {
    global $post;
    global $game_templates;
    echo '<input type="hidden" name="game_meta_noncename" id="game_meta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    $game_template = get_post_meta($post->ID, '_game_template', true);

    if(is_array($game_templates) && count($game_templates) > 0) {

        echo '<select name="_game_template">';
        foreach ($game_templates as $key=>$value) {
            $selected = $game_template == $key ? " selected=1 " : "";
            echo "<option value=\"$key\" $selected >$value</option>";
        }
        echo '</select>';

    } else {
        echo "<p style='color:red'>Ошибка. Список шаблонов недоступен.</p>";
    }


}
// Save the Metabox Data

function unfreeze_save_games_meta($post_id, $post) {

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['game_meta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    $_servers = explode ("\n",$_POST['_servers']);

    if(is_array($_servers) && count ($_servers) > 0) {
        $meta_servers = array();
        foreach($_servers as $key=>$server) {
            if (strlen(trim($server)) > 0)
                $meta_servers[] = trim($server);
        }

    } else {
        $meta_servers = $_servers;
    }

    $_currencies = explode ("\n",$_POST['_currencies']);

    if(is_array($_currencies) && count ($_currencies) > 0) {
        $meta_currencies = array();
        foreach($_currencies as $key=>$currency) {
            if (strlen(trim($currency)) > 0)
                $meta_currencies[] = trim($currency);
        }

    } else {
        $meta_currencies = $_currencies;
    }

    $_alliances = explode ("\n", $_POST['_alliances']);

    if(is_array($_alliances) && count ($_alliances) > 0) {
        $meta_alliances = array();
        foreach($_alliances as $key=>$alliance) {
            if (strlen(trim($alliance)) > 0)
                $meta_alliances[] = trim($alliance);
        }

    } else {
        $meta_alliances = $_alliances;
    }

    $events_meta['_servers'] = $meta_servers;
    $events_meta['_currencies'] = $meta_currencies;
    $events_meta['_alliances'] = $meta_alliances;

    $_servers_unique = $_POST['_servers_unique'];
    $events_meta['_servers_unique'] = $_servers_unique;

    $_alliances_unique = $_POST['_alliances_unique'];
    $events_meta['_alliances_unique'] = $_alliances_unique;

    $_alliances_enable = $_POST['_alliances_enable'];

    if ($_alliances_enable) $events_meta['_alliances_enable'] = $_alliances_enable;
    else $events_meta['_alliances_enable'] = 0;

    $_game_template = $_POST['_game_template'];
    $events_meta['_game_template'] = $_game_template;



    foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)

        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value

            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value

            add_post_meta($post->ID, $key, $value);
        }
        //if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }

}

add_action('save_post', 'unfreeze_save_games_meta', 1, 2); // save the custom fields

/********* END CUSTOM POST GAME ***************************/