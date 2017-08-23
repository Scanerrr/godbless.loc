<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */

global $review_ratings;
$review_ratings = array(
    '0' => 'Нейтральный',
    '1' => 'Положительный',
    '2' => 'Отрицательный'
);

global $game_templates;
$game_templates = array(
    '7' => 'Валюта и сервер',
    '10' => 'Только сервер',
    '11' => 'Только валюта'
);

global $default_game_template;
$default_game_template = 7;


global $checkout_public_key, $checkout_private_key;
$checkout_public_key = '8C349A3B-D3A9-433C-9C6F-D61EEB9FB1AA';
$checkout_private_key = '8C349A3B-D3A9-433C-9C6F-D61EEB9FB1AA';

global $liqpay_public_key, $liqpay_private_key;

$liqpay_public_key = 'i42010176483';
$liqpay_private_key = '9idFXotPEpLOxTbFJbYDq6IRcJJjmeQDRDePxINI';



if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('twentysixteen_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own twentysixteen_setup() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     */
    function twentysixteen_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentysixteen
         * If you're building a theme based on Twenty Sixteen, use a find and replace
         * to change 'twentysixteen' to the name of your theme in all the template files
         */
        load_theme_textdomain('twentysixteen');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for custom logo.
         *
         *  @since Twenty Sixteen 1.2
         */
        add_theme_support('custom-logo', array(
            'height' => 240,
            'width' => 240,
            'flex-height' => true,
        ));

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'twentysixteen'),
            'social' => __('Social Links Menu', 'twentysixteen'),
            'games' => "Главное меню игр",
            'games_list' => "Главное меню игр (список)",
            'bottom' => "Меню футера"
        ));


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', twentysixteen_fonts_url()));

        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support('customize-selective-refresh-widgets');
    }
endif; // twentysixteen_setup
add_action('after_setup_theme', 'twentysixteen_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width()
{
    $GLOBALS['content_width'] = apply_filters('twentysixteen_content_width', 840);
}

add_action('after_setup_theme', 'twentysixteen_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'twentysixteen'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 1', 'twentysixteen'),
        'id' => 'sidebar-2',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 2', 'twentysixteen'),
        'id' => 'sidebar-3',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'twentysixteen_widgets_init');

if (!function_exists('twentysixteen_fonts_url')) :
    /**
     * Register Google fonts for Twenty Sixteen.
     *
     * Create your own twentysixteen_fonts_url() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function twentysixteen_fonts_url()
    {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Merriweather font: on or off', 'twentysixteen')) {
            $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
        }

        /* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Montserrat font: on or off', 'twentysixteen')) {
            $fonts[] = 'Montserrat:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Inconsolata font: on or off', 'twentysixteen')) {
            $fonts[] = 'Inconsolata:400';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection()
{
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentysixteen_javascript_detection', 0);

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts()
{
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentysixteen-fonts', twentysixteen_fonts_url(), array(), null);

    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1');

    // Theme stylesheet.
    wp_enqueue_style('twentysixteen-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array('twentysixteen-style'), '20160816');
    wp_style_add_data('twentysixteen-ie', 'conditional', 'lt IE 10');

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array('twentysixteen-style'), '20160816');
    wp_style_add_data('twentysixteen-ie8', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array('twentysixteen-style'), '20160816');
    wp_style_add_data('twentysixteen-ie7', 'conditional', 'lt IE 8');

    // Load the html5 shiv.
    wp_enqueue_script('twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
    wp_script_add_data('twentysixteen-html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20160816');
    }

    wp_enqueue_script('twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20160816', true);

    wp_enqueue_script('jquery-ui', 'http://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '20160816', true);
   // wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js', array('jquery'), '20160816', true);


    wp_localize_script('twentysixteen-script', 'screenReaderText', array(
        'expand' => __('expand child menu', 'twentysixteen'),
        'collapse' => __('collapse child menu', 'twentysixteen'),
    ));
}

add_action('wp_enqueue_scripts', 'twentysixteen_scripts');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes($classes)
{
    // Adds a class of custom-background-image to sites with a custom background image.
    if (get_background_image()) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of group-blog to sites with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of no-sidebar to sites without active sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'twentysixteen_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb($color)
{
    $color = trim($color, '#');

    if (strlen($color) === 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) === 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array $size Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr($sizes, $size)
{
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr($attr, $attachment, $size)
{
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args($args)
{
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}

add_filter('widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args');


// ************ ТУТ! ***********
// http://wp-kama.ru/question/kolichestvo-kommentariev-polzovatelya


//Customize the contact information fields available to your WordPress users.
// Edits the available contact methods on a user's profile page.
// Contact methods can be both added and removed.

// Обработка полей, которые добавляются в профиль пользователя
function new_contact_methods($contactmethods)
{

    if (current_user_can('manage_options')) {
        $contactmethods['level'] = 'Уровень';
        $contactmethods['date'] = '';
    }
    return $contactmethods;
}

add_filter('user_contactmethods', 'new_contact_methods', 10, 1);


//manage_users_columns is a filter applied to the columns on the manage users screen.
function new_modify_user_table($column)
{
    $column['level'] = 'Уровень';
    $column['date'] = 'Дата Регистрации';
    return $column;
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val, $column_name, $user_id)
{
    switch ($column_name) {
        case 'level' :
            return get_the_author_meta('level', $user_id);
            break;
        case 'date' :
            $udata = get_userdata( $user_id );
            $registered = $udata->user_registered;
            return date( get_option('date_format'), strtotime( $registered ) );
            break;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);


add_action('user_register', 'user_registration_set_levet', 10, 1);

function user_registration_set_levet($user_id)
{

    update_user_meta($user_id, 'level', '1');

}


function my_rewrite_flush()
{
    custom_post_game();
    custom_post_offer();
    flush_rewrite_rules();


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    global $wpdb;


    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_clicks';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			offer_id int(11) unsigned NOT NULL,
			click_time datetime  NOT NULL,
			PRIMARY KEY  (id)

		) {$charset_collate};";

    // Создать таблицу.
    dbDelta($sql);

    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_merchants';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql = "CREATE TABLE {$table_name} (
                id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
                name VARCHAR( 128) NOT NULL ,
                description VARCHAR( 512 ) NOT NULL ,
                PRIMARY KEY ( id )

		) {$charset_collate};";

    // Создать таблицу.
    dbDelta($sql);

    $table_name = $wpdb->get_blog_prefix() . 'unfreeze_payments';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql = "CREATE TABLE {$table_name} (
                id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
                payment_id INT (16) NOT NULL ,
                status VARCHAR( 128) NOT NULL ,
                err_code VARCHAR( 128),
                err_description VARCHAR( 256 ),
                order_id VARCHAR( 512 ),
                description  VARCHAR( 1024),
                amount FLOAT,
                currency VARCHAR(8),
                create_date DATETIME,
                code VARCHAR( 128),
                customer INT (8) NOT NULL ,
                PRIMARY KEY ( id )

		) {$charset_collate};";

    // Создать таблицу.
    dbDelta($sql);

}

add_action('after_switch_theme', 'my_rewrite_flush');
add_action('after_switch_theme', 'my_creating_custom_pages');

function my_creating_custom_pages () {
    $page_definitions = array(
        'member-login' => array(
            'title' => __( 'Вход', 'personalize-login' ),
            'content' => '[custom-login-form]'
        ),
        'member-password-reset' => array(
            'title' => __( 'Сброс парорля', 'personalize-login' ),
            'content' => '[custom-password-reset-form]'
        )
    );

    foreach ( $page_definitions as $slug => $page ) {
        // Check that the page doesn't exist already
        $query = new WP_Query( 'pagename=' . $slug );
        if ( ! $query->have_posts() ) {
            // Add the page using the data from the array above
            wp_insert_post(
                array(
                    'post_content'   => $page['content'],
                    'post_name'      => $slug,
                    'post_title'     => $page['title'],
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'ping_status'    => 'closed',
                    'comment_status' => 'closed',
                )
            );
        }
    }
}

include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_registration.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "custom-post-game.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "custom-post-offer.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "offers-wp-list.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_add_offer.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_edit_offer.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_redirect.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_statistics.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_payments.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_add_review.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "unfreeze_restore_selected.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "personalize-login.php";
include get_template_directory() . DIRECTORY_SEPARATOR . "extendcomment.php";


// * Enqueue Dashicons style for frontend use when enqueuing your theme's style sheet
add_action('wp_enqueue_scripts', 'unfreeze_dashicons');
function unfreeze_dashicons()
{
    wp_enqueue_style('unfreeze-dashicons-style', get_stylesheet_uri(), 'dashicons');
}


add_action('wp_enqueue_scripts', 'unfreeze_dashicons2');
function unfreeze_dashicons2()
{
    wp_enqueue_style('dashicons');
}



function script_ui_accordion() {
    //wp_enqueue_script( 'jquery-ui-accordion' );

    wp_enqueue_style('plugin_name-admin-ui-css',
        'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
        false,
        PLUGIN_VERSION,
        false);


}
add_action( 'wp_enqueue_scripts', 'script_ui_accordion' );

function accordion_script() {

    ?>
    <script type="text/javascript">
        jQuery( function() {


            /*
            jQuery( "#accordion" ).accordion();
            jQuery( "#accordion2" ).accordion();
            jQuery( "#accordion3" ).accordion();



             jQuery( "input.merchant-toggle" ).checkboxradio();

             jQuery(".merchant-toggles").controlgroup( {
             direction: "vertical"
             } );
            */

        } );
    </script>
    <?php

}
add_action( 'wp_footer', 'accordion_script' );



function print_pre($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    return;
}

if(function_exists('add_db_table_editor')){

    $args = array(
        'title'=>'Платежные системы',
        'table'=>'wp_unfreeze_merchants',
        'cap'=>'manage_options',
        'editcap'=>'manage_options',
        'sql'=>'SELECT * FROM  `wp_unfreeze_merchants`'
    );


    add_db_table_editor( $args );

}

add_filter('wpdatatables_filter_table_description', 'func1', 10, 2);

function func1($object, $table_id)
{

    return $object;

}


add_action('init', 'infreeze_init_session', 1);

if ( !function_exists('infreeze_init_session')):
    function infreeze_init_session()
    {
        session_start();
    }
endif;


//фильтруем класс в элементе меню навигации
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
    if( $item->title == 'Скидка' || $item->title == 'W'){
        $classes[] = 'last-menu-item';
    }
    return $classes;
}

// настроки unfreeze
// create custom plugin settings menu
add_action('admin_menu', 'baw_create_menu');

function baw_create_menu() {

    //create new top-level menu
    add_menu_page('Настройки Unfreeze', 'Настройки Unfreeze', 'administrator', 'unfreeze-options', 'unfreeze_option_page');

    //call register settings function
    add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
    //register our settings
    register_setting( 'baw-settings-group', 'unfreeze-option-click-cost' );
    register_setting( 'baw-settings-group', 'unfreeze-option-usd-kurs' );

}

function unfreeze_option_page() {
    ?>
    <div class="wrap">
        <h2>Настрокйи обмена</h2>

        <form method="post" action="options.php">
            <?php settings_fields( 'baw-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Стоимость 1 перехода в USD</th>
                    <td><input type="text" name="unfreeze-option-click-cost" value="<?php echo get_option('unfreeze-option-click-cost'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Стоимость 1 USD в ГРН (курс, если оплата придет в гривне)</th>
                    <td><input type="text" name="unfreeze-option-usd-kurs" value="<?php echo get_option('unfreeze-option-usd-kurs'); ?>" /></td>
                </tr>


            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>
    </div>
<?php }


add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a href="'. wp_logout_url( home_url() ) .'">Выйти</a></li>';
    }
    return $items;
}

if (!current_user_can('administrator')):
    show_admin_bar(false);
endif;

/*
 * ACF Dynamic select for offers
 * */
function acf_load_game_field_choices( $field ) {
    $field['choices'] = array('Выбрать игру');
    // Query Waiting Lists Products
    $args = array(
        'post_type' => 'game',
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => -1
    );
    $lists_array = get_posts( $args );

    foreach ( $lists_array as $list ) {
        $field['choices'][$list->ID] = $list->post_title;
    }
//    print_pre($field);
    wp_reset_postdata();

    return $field;
}

add_filter('acf/load_field/name=game_id', 'acf_load_game_field_choices');

add_action('admin_print_footer_scripts', 'my_action_javascript', 99);
function my_action_javascript() {
    ?>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            $('#select_game_id').find('select').on('change', function (e) {
                $('#select_alliance').find('select').empty().append($('<option>', {
                    value: 0,
                    text: 'Выбрать alliance'
                }));
                $('#select_servers').find('ul').empty();
                var data = {
                    action: 'load_game',
                    game_id: $(this).val()
                };

                // dynamic append data to select and inputs
                jQuery.post( ajaxurl, data, function(response) {
                    if (typeof response.alliance !== "undefined") {
                        $('#select_alliance').find('select').append($('<option>', {
                            value: response.alliance,
                            text: response.alliance
                        }));
                    }
                    if (typeof response.servers !== "undefined") {
                        $.each(response.servers, function (key, serv) {
                            var el = '<li><label><input id="acf-field_599d619d7c021-' + serv + '" type="checkbox" name="acf[field_599d619d7c021][]" value="' + serv + '">' + serv + '</label></li>';
                            $('#select_servers').find('ul').append(el);
                        });
                    }
                }, 'json');
            });
        });
    </script>
    <?php
}

add_action('wp_ajax_load_game', 'my_action_callback');
function my_action_callback() {
    $game_id = intval( $_POST['game_id'] );
    $data = [];
    $alliance = get_post_meta($game_id, '_alliances', true);
    if ($alliance)
        $data['alliance'] = $alliance;

    $servers = get_post_meta($game_id, '_servers', true);
    $servers = explode(',', $servers);
    if (!empty($servers))
        $data['servers'] = $servers;
    echo wp_json_encode($data);

    wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}