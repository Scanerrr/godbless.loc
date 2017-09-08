<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 26.10.2016
 * Time: 14:03
 */


/********** POST TYPE OFFER *******************/

function custom_post_offer() {
    $labels = array(
        'name'               => 'Предложения',
        'singular_name'      => 'Предложение',
        'add_new'            => 'ADD OFFER',
        'add_new_item'       => 'Добавить новое Предложение',
        'edit_item'          => 'Редактировать предложение',
        'new_item'           => 'Новое предложение',
        'all_items'          => 'Все предложения',
        'view_item'          => 'Посомтреть предложение',
        'search_items'       => 'Поиск предложений',
        'not_found'          => 'Предложений не найдено',
        'not_found_in_trash' => 'В корзине предложений не найдено',
        'parent_item_colon'  => '',
        'menu_name'          => 'Предложения',

    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Содержит описание Предложения для обмена игровой валюты',
        'public'        => true,
        'menu_position' => 4    ,
        'menu_icon' => 'dashicons-awards',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'has_archive'   => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        //'register_meta_box_cb' => 'add_offer_metaboxes'

    );
    register_post_type( 'offer', $args );
}
add_action( 'init', 'custom_post_offer' );
/********* END CUSTOM POST GAME ***************************/