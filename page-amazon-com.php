<?php
/**
 * Template Name: Amazon.com
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
error_reporting(-1);

/*
$post = array(
  'ID'             => [ <post id> ] //Are you updating an existing post?
  'menu_order'     => [ <order> ] //If new post is a page, it sets the order in which it should appear in the tabs.
  'comment_status' => [ 'closed' | 'open' ] // 'closed' means no comments.
  'ping_status'    => [ 'closed' | 'open' ] // 'closed' means pingbacks or trackbacks turned off
  'pinged'         => [ ? ] //?
  'post_author'    => [ <user ID> ] //The user ID number of the author.
  'post_category'  => [ array(<category id>, <...>) ] //post_category no longer exists, try wp_set_post_terms() for setting a post's categories
  'post_content'   => [ <the text of the post> ] //The full text of the post.
  'post_date'      => [ Y-m-d H:i:s ] //The time post was made.
  'post_date_gmt'  => [ Y-m-d H:i:s ] //The time post was made, in GMT.
  'post_excerpt'   => [ <an excerpt> ] //For all your post excerpt needs.
  'post_name'      => [ <the name> ] // The name (slug) for your post
  'post_parent'    => [ <post ID> ] //Sets the parent of the new post.
  'post_password'  => [ ? ] //password for post?
  'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 'custom_registered_status' ] //Set the status of the new post.
  'post_title'     => [ <the title> ] //The title of your post.
  'post_type'      => [ 'post' | 'page' | 'link' | 'nav_menu_item' | 'custom_post_type' ] //You may want to insert a regular post, page, link, a menu item or some custom post type
  'tags_input'     => [ '<tag>, <tag>, <...>' ] //For tags.
  'to_ping'        => [ ? ] //?
  'tax_input'      => [ array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ) ] // support for custom taxonomies. 
);
*/
$title = 'Test Post #4';
$post = array(
	'post_content' => 'The content',            // The full text of the post.
	'post_date'    => date('Y-m-d H:i:s'),      // The time post was made.
	'post_name'    => sanitize_title( $title ), // The name (slug) for your post.
	'post_status'  => 'publish',                // Set the status of the new post.
	'post_title'   => $title,                   // The title of your post.
	'post_type'    => 'HTML Parsed Item',       // You may want to insert a regular post, page, link, a menu item or some custom post type.
	'tags_input'   => 'tag'                     // For tags.
);

// $post_id = wp_insert_post( $post );

/*
			'ASIN',
		 	'amazon_price',
			'amazon_old_price_old',
			'category_URL',
			'comments_count',
			'comments_URL',
			'product_URL',
		 	'marketplace_price_new',
		 	'marketplace_price_used',
			'rating',
			'thumbnail_URL
*/

?>

<?php if ( !is_user_logged_in() ) { ?>
    
    <h1>iLife Mobi</h1>
    <p>Page not found.</p>
    
<?php } else { ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header-amazon-com' ) ); ?>

<?php $html = new WP_HTML_Parser; ?>
<?php $html->save_HTML_with_URL("http://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=bikes"); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>

<?php

$new_tag_name = "title";
echo "<p><u>Title</u>: " . $html->get_HTML_content_within_tag("title") . "</p>";
echo "<p>--------------------------</p>";


$new_tag_name = "div";
$new_attribute_name = "class";
$new_attribute_value = "rslt";
$new_offset = 0;
if ($position = $html->get_tag_start_position_with_attribute_name_and_value($new_tag_name, $new_attribute_name, $new_attribute_value, $new_offset))
{
	echo "<p><u>Tag Name</u>: " . $new_tag_name . "</p>";
	echo "<p><u>Attribute Name</u>: " . $new_attribute_name . "</p>";
	echo "<p><u>Attribute Value</u>: " . $new_attribute_value . "</p>";
	echo "<p><u>Tag Position</u>: " . $position . "</p>";
	
	$item_html = $html->get_HTML_within_tag($new_tag_name, $position);
	echo "<p>" . $item_html . "</p>";
	
	$item = new WP_HTML_Parser;
	$item->save_HTML( $item_html );
	echo "<p>--------------------------</p>";
	
	echo "<p> ".$item->get_all_HTML()."</p>";
	echo "<p>--------------------------</p>";
	
	$ASIN = $item->get_attribute_value_of_tag('div', 'name');
	echo "<p> ASIN: ".$ASIN."</p>";
} else {
	echo "<p>ERROR: Failure</p>";
}
?>


<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>