<?php
/**
 * Template Name: Dealsea.com
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

function prepare_HTML($url)
{
	global $wpdb;
	
	// Saves the HTML code from a $url into the string $new_html
	$new_html = file_get_contents($url);
	$formatted_html = "";
	
	//
	$more_items           = false;
	$item_start           = '<div class="dealbox">';
	$item_id_start        = '<a href="/view-deal/';
	$item_id_end          = '"';
	$item_thumbnail_start = '<img src="';
	$item_thumbnail_end   = '"';
	$item_title_end       = '</a>';
	$item_date_start      = '</strong>, ';
	$item_date_end        = '<div class="posttext">';
	$item_content_start   = $item_date_end;
	$item_content_end     = '</div>';
	
	$i=0;
	
	$formatted_html .= "<p><u>new_html</u> = " . strlen($new_html) . "</p>\n";
	
	// stripos() - Find the position of the first occurrence of a case-insensitive substring in a string
	while ($current_item_start = stripos($new_html, $item_start)) {
		// Strip off all HTML code before this current item
		$new_html = substr($new_html, $current_item_start, (strlen($new_html) - $current_item_start));
		$formatted_html .= "<p><u>new_html</u> = " . strlen($new_html) . "</p>\n";
		$formatted_html .= "<p><u>ID</u> = $i </p>";
		// ------------------------------------------------------------------------------------------
		// $formatted_html .= "<p><u>HTML NEXT</u> = " . htmlspecialchars(substr($new_html, 0, 400)) . "</p>\n";
		// ------------------------------------------------------------------------------------------
		
		// Parse the item's ID number
		$current_item_id_start = stripos($new_html, $item_id_start) + strlen($item_id_start);
		$current_item_id_end   = stripos($new_html, $item_id_end, $current_item_id_start);
		$current_item_id = substr($new_html, $current_item_id_start, ($current_item_id_end - $current_item_id_start));
		$formatted_html .= "<p><u>DEALSEA ID</u> = " . $current_item_id . "</p>\n";
		$new_html = substr($new_html, $current_item_id_end, (strlen($new_html) - $current_item_id_end));
		
		// Parse the item's thumbnail link
		$current_item_thumbnail_start = stripos($new_html, $item_thumbnail_start) + strlen($item_thumbnail_start);
		$current_item_thumbnail_end   = stripos($new_html, $item_thumbnail_end, $current_item_thumbnail_start);
		$current_item_thumbnail = substr($new_html, $current_item_thumbnail_start, ($current_item_thumbnail_end - $current_item_thumbnail_start));
		$formatted_html .= "<p><u>THUMBNAIL URL</u> = " . $current_item_thumbnail . "</p>\n";
		$new_html = substr($new_html, $current_item_thumbnail_end, (strlen($new_html) - $current_item_thumbnail_end));
		
		// Parse the item's title
		$item_title_start = $item_id_start . $current_item_id . '">';
		$current_item_title_start = stripos($new_html, $item_title_start) + strlen($item_title_start);
		$current_item_title_end   = stripos($new_html, $item_title_end, $current_item_title_start);
		$current_item_title = substr($new_html, $current_item_title_start, ($current_item_title_end - $current_item_title_start));
		$formatted_html .= "<p><u>TITLE</u> = " . $current_item_title . "</p>\n";
		$new_html = substr($new_html, $current_item_title_end, (strlen($new_html) - $current_item_title_end));
		
		// Parse the item's date and show if exired or not
		$current_item_date_start = stripos($new_html, $item_date_start) + strlen($item_date_start);
		$current_item_date_end = '';
		$item_expired = stripos($new_html, 'Expired</span>');
		$is_item_expired = false;
		if (!$item_expired || ($item_expired > 70)) {
			$formatted_html .= "<p><u>EXPIRED</u> = false</p>\n";
			$current_item_date_end = stripos($new_html, $item_date_end, $current_item_date_start);
		} else {
			$formatted_html .= "<p><u>EXPIRED</u> = true</p>\n";
			$current_item_date_end = $item_expired;
			$is_item_expired = true;
		}
		$current_item_date = substr($new_html, $current_item_date_start, ($current_item_date_end - $current_item_date_start));
		$formatted_html .= "<p><u>DATE</u> = " . $current_item_date . "</p>\n";
		$new_html = substr($new_html, $current_item_date_end, (strlen($new_html) - $current_item_date_end));
		
		// When the item is expired, no content is diplayed.
		$current_item_content = '';
		if ($is_item_expired == false) {
			// Parse the item's content
			$current_item_content_start = stripos($new_html, $item_content_start) + strlen($item_content_start);
			$current_item_content_end   = stripos($new_html, $item_content_end, $current_item_content_start);
			$current_item_content = substr($new_html, $current_item_content_start, ($current_item_content_end - $current_item_content_start));
			$formatted_html .= "<p><u>CONTENT</u> = " . htmlspecialchars($current_item_content) . "</p>\n";
			$new_html = substr($new_html, $current_item_content_end, (strlen($new_html) - $current_item_content_end));
		}
		
		$query = "SELECT post_id FROM $wpdb->postmeta WHERE meta_value = $current_item_id";
		$results = $wpdb->get_results( $query );
		
		if (count($results) < 1) { // The deal has not been saved to the local database
			
			$formatted_html .= "<p><u>SAVED</u> = false</p>\n";
			// Create post object
			$seconds_per_day = 86400;
			$post_date = date("Y-").date('m-d', strtotime($current_item_date))." ".date("H:i:s", ($current_item_id % $seconds_per_day));
			
			$my_post = array(
		 		'menu_order'    => 0,
		  		'post_author'   => 1,
		  		'post_content'  => $current_item_content,
				'post_date'     => $post_date, // The date post was made on dealsea.com
		  		'post_status'   => 'publish',
		  		'post_title'    => $current_item_title
			);
			
			// Insert the post into the database
			$my_post_id = wp_insert_post( $my_post );
			
			if ($my_post_id == 0) {
				$formatted_html .= "<p><u>SAVE</u> = failure</p>\n";
			} else {
			// Add post metadata
				$unique = true;
				add_post_meta($my_post_id, "dealsea_ID", $current_item_id, $unique);
				add_post_meta($my_post_id, "expired", "false", $unique);
				add_post_meta($my_post_id, "thumbnail_URL", $current_item_thumbnail, $unique);
				$formatted_html .= "<p><u>META SAVED</u> = success on".date("Y-").date('m-d', strtotime($current_item_date))." ".date("H:i:s", ($current_item_id % $seconds_per_day))."</p>\n";
			}
		} else {
			$formatted_html .= "<p><u>SAVED</u> = true</p>\n";
			
			// If the deal has expired
			if ($is_item_expired == true) {
				$my_post_id = $results[0]->post_id;
				update_post_meta($my_post_id, "expired", "true");
			}
		}
		
		$formatted_html .= "<br />";
		$formatted_html .= "\n<!-- =================================================================== -->\n"; // REMOVE LATER
		
		$i++;
	}
	
	return $formatted_html;
}

?>

<?php if ( !is_user_logged_in() ) { ?>
    
    <h1>iLife Mobi</h1>
    <p>This website is under construction. Please come back at a later time.</p>
    
<?php } else { ?>

<?php $html = prepare_HTML('http://dealsea.com'); ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php get_sidebar(); ?>

<div id="search_results" class="align_left width_50">

<?php if ( have_posts() ): ?>
            
<h2>Top Deals & Coupons</h2>

<?php // print_r($html); ?>

<ol>
<?php while ( have_posts() ) : the_post(); ?>
	<li class="li_item">
		<article>
			<h3><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<p><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time></p>
			<?php the_content(); ?>
            <?php comments_popup_link('&raquo; Leave a Comment', '&raquo; 1 Comment', '&raquo; % Comments'); ?>
		</article>
	</li>
<?php endwhile; ?>
</ol>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>

<div class="navigation"><p><?php posts_nav_link(); ?></p></div>

</div> <!-- End of #search_results -->

<div id="ads" class="align_left width_30">
	<p>Ads</p>
</div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>

<?php } // End of is_user_logged_in() ?>