<?php
/**
 * Created by PhpStorm.
 * User: Bohdan
 * Date: 8/28/2017
 * Time: 22:53
 */
 $query = 'SELECT post_offer.ID, post_offer.post_title as offer_title,
post_offer_meta_server.meta_value as server, post_offer_meta_currency.meta_value as currency,
post_offer_meta_alliance.meta_value as alliance,  post_offer_meta_price.meta_value as price,
post_offer_meta_website.meta_value as website,  
CONCAT (\'<a href="/redirect?id=\', post_offer.ID, \'&url=\', post_offer_meta_website.meta_value, \'">\', post_offer_meta_website.meta_value, \'</a>\' ) as link,
post_offer_meta_payment_systems.meta_value as payment_systems,
post_offer_meta_game.meta_value as game_id, post_game.post_title as game_title ,
CONCAT (
\'<a href="/edit_offer/?offer_id=\', post_offer.ID, \'">Редактировать\', \'</a><br>\', 
\'<a href="?action=delete&offer_id=\', post_offer.ID, \'">Удалить\', \'</a><br>\', 
\'<a href="?action=clone&offer_id=\', post_offer.ID, \'">Клонировать\', \'</a> \'
) as actions,
CONCAT (\'<input name="offer_id[\', post_offer.ID , \']" type="checkbox">\'

) as select_offer,

post_offer_clicks.clicks as clicks 



FROM wp_posts AS post_offer

INNER JOIN wp_users AS posts_offer_author
ON posts_offer_author.ID = post_offer.post_author AND post_offer.post_author = %CURRENT_USER_ID% 

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_server
ON post_offer.ID = post_offer_meta_server.post_id AND post_offer_meta_server.meta_key = \'server\'

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_currency
ON post_offer.ID = post_offer_meta_currency.post_id AND post_offer_meta_currency.meta_key = \'currency\'

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_alliance
ON post_offer.ID = post_offer_meta_alliance.post_id AND post_offer_meta_alliance.meta_key = \'alliance\'

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_price
ON post_offer.ID = post_offer_meta_price.post_id AND post_offer_meta_price.meta_key = \'price\'

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_website
ON post_offer.ID = post_offer_meta_website.post_id AND post_offer_meta_website.meta_key = \'website\'

LEFT JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_payment_systems
ON post_offer.ID = post_offer_meta_payment_systems.post_id AND post_offer_meta_payment_systems.meta_key = \'payment_systems\'

LEFT JOIN (SELECT count(*) as clicks, offer_id as clicks_offer_id  
FROM `wp_unfreeze_clicks` group by offer_id ) as post_offer_clicks
on post_offer.ID = post_offer_clicks.clicks_offer_id

INNER JOIN (SELECT post_id, meta_key, meta_value FROM wp_postmeta ) as post_offer_meta_game
ON post_offer.ID = post_offer_meta_game.post_id 
   AND post_offer_meta_game.meta_key = \'game_id\'

LEFT JOIN (SELECT ID, post_title  FROM wp_posts WHERE post_type=\'game\' ) as post_game
ON post_game.ID = post_offer_meta_game.meta_value

WHERE post_offer.post_type = \'offer\' AND post_offer.post_status = \'publish\'
ORDER BY ID DESC
';


include('../../wp-blog-header.php');

// Preparing a WP_query
$the_query = new WP_Query(
    array(
        'post_type' => 'offer',
        'orderby' => 'ID',
        'order' => 'DESC',
        'post_status' => 'publish',
        'post_count' => -1 // We do not want to limit the post count
// We can define any additional arguments that we need - see Codex for the full list
    )
);

$return_array = array(); // Initializing the array that will be used for the table

while( $the_query->have_posts() ){

// Fetch the post
    $the_query->the_post();

// Filling in the new array entry
    $return_array[] = array(
        'Id' => get_the_id(), // Set the ID
        'Title' => get_the_title(), // Set the title
        'Content preview with link' => get_permalink().'||'.strip_tags( strip_shortcodes( substr( get_the_content(), 0, 200 ) ) ).'...'
// Get first 200 chars of the content and replace the shortcodes and tags
    );

}

// Now the array is prepared, we just need to serialize and output it
echo serialize( $return_array );

?>