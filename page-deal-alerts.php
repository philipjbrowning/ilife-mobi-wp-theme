<?php
/**
 * Template Name: Deal Alerts
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
$wpdb->show_errors();

$paged = NULL;
if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
}
elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
}
else {
	$paged = 1;
}
$args = '';
if (is_user_logged_in())
{
	global $wpdb;
	$current_user = wp_get_current_user();
	$args = array(
		'author'         => $current_user->ID,
		'post_type'      => 'deal-alert',
		'posts_per_page' => 20,
		'paged'          => $paged
	);
} else {
	wp_redirect( home_url() ); exit;
}
$my_query = new WP_Query($args);

// Consolidate IDs into an array
$days_of_prices = 14;
$my_query_item_ids = array();
$listed_results = array();
$my_listing_item_ids = array();
foreach ($my_query->posts as $deal_alert_post) {
	$item_id = @get_post_meta($deal_alert_post->ID, 'item_id', true);
	if(!isset($listed_results[$item_id]))
	{
		$listed_results[$item_id] = array('item_ID' => $item_id, "price" => array(), "price_date" => array());
		array_push($my_query_item_ids, $item_id);
	}
	array_push($my_listing_item_ids, $item_id);
}

// Query price history based on distinct IDs
$history_results = get_price_history($my_query_item_ids, $days_of_prices);
foreach ($history_results as $history_item)
{
	// Add item to the bucket(array) of the corresponding item_ID
	array_push($listed_results[$history_item->item_ID]['price'], $history_item->price);
	array_push($listed_results[$history_item->item_ID]['price_date'], $history_item->price_date);
}

// Reverse order of the arrays. Before, most recent is first.
foreach ( $listed_results as $item_result ) 
{	
	$item_result['price'] = array_reverse($item_result['price']);
	$item_result['price_date'] = array_reverse($item_result['price_date']);
	
	// Create GET arguments
	$arguments = "?item_ID=".$item_result['item_ID'];
	foreach ($item_result['price'] as $current_price)
	{
		$arguments .= "&price[]=".urlencode($current_price);
	}
	foreach ($item_result['price_date'] as $current_price_date)
	{
		$arguments .= "&price_date[]=".urlencode($current_price_date);
	}
	$listed_results[$item_result['item_ID']]['arguments'] = $arguments;
}
?> 
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
					<?php if ( $my_query->have_posts() ): ?>
                    <h2>Your Personal Deal Alerts</h2>	
                    <ol class="width_full">
                    <?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
                        <li class="individual_item">
                            <?php $thumbnail_URL = get_post_meta( $post->ID, 'thumbnail_URL', true ); ?>
                            <article class="individual_item_article <?php if ($thumbnail_URL !== false) { ?>amazon_image<?php } ?>">
                            	<?php if ($thumbnail_URL !== false) { ?>
                                <img id="thumbnail" class="align_right margin_left_20px" src="<?php echo $thumbnail_URL; ?>" />
                                <?php } ?>
								<h3><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
                                <p><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>">Amazon.com</a> has a deal on this item. The price has decreased <?php echo abs(round(@get_post_meta($post->ID, 'actual_change', true), 1)); ?>%. The new price is $<?php echo @get_post_meta($post->ID, 'current_price', true); ?> (was $<?php echo @get_post_meta($post->ID, 'base_price', true); ?>). High price: $<?php echo @get_post_meta($post->ID, 'high_price', true); ?>. Low price: $<?php echo @get_post_meta($post->ID, 'low_price', true); ?>.</p>
                            </article>
                            <aside class="individual_item_history_graph">
								<p><img src="<?php echo get_template_directory_uri(); ?>/jpgraph/history-two-weeks.php<?php echo $listed_results[@get_post_meta($post->ID, 'item_id', true)]['arguments']; ?>"></p>
                            </aside>
                        </li>
                    <?php endwhile; ?>
                    </ol>
                    <div class="navigation text_center width_full"><p><?php posts_nav_link(); ?></p></div>
                    <?php else: ?>
                    <h3>No deal alerts to display.</h3>
                    <?php endif; ?>
                </section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>