<?php
/**
 * Template Name: Testing
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
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
                	<?php 
						query_posts(array( 
							'post_type' => 'deal-alert',
							'showposts' => 10 
						) );  
					?>
					<?php if ( have_posts() ): ?>
                    <h2>Top Deals and Coupons</h2>	
                    <ol class="width_full">
                    <?php while (have_posts()) : the_post(); ?>
                    	<li class="individual_item">
                            <article class="individual_item_article">
                                <h3><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
                                <p>The price has <?php if (@get_post_meta($post->ID, 'actual_change', true) >= 0.00) { ?>increased<?php } else { ?>decreased<?php } ?> <?php echo number_format(((float)@get_post_meta($post->ID, 'current_price', true) - (float)@get_post_meta($post->ID, 'base_price', true)),2,'.',''); ?>%. The new price is $<?php echo @get_post_meta($post->ID, 'current_price', true); ?>. The high price for this item was $<?php echo @get_post_meta($post->ID, 'high_price', true); ?>, and the low price was $<?php echo @get_post_meta($post->ID, 'low_price', true); ?>.</p>
                            </article>
                        </li>
                    <?php endwhile;?>
                    </ol>
                    <div class="navigation text_center width_full"><p><?php posts_nav_link(); ?></p></div>
                    <?php else: ?>
                    <h3>No deal alerts to display.</h3>
                    <?php endif; ?>
                </section> <!-- /#main -->
				
                <section>

<?php                   
/**
 * Retrieves a price from Amazon.com, returning the value.
 *
 * @parameters:  [string] Amazon Sales Inquiry Number (ASIN)
 * @return:      [float] price, if the ASIN is found
 *               [bool] false, if the ASIN is not found
 */
function get_item_link($item_ASIN)
{
	$html = new WP_HTML_Parser();
	$html->save_HTML_with_URL('http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords='.$item_ASIN);
	$tag_name = 'div';
	$attribute_name = 'id';
	$attribute_value = 'atfResults';
	$html->set_options(array('remove_comments'=>true, 'remove_header'=>true, 'remove_script'=>false, 'remove_style'=>true, 'remove_whitespace'=>false));
	$from = $html->get_tag_start_position_with_attribute_name_and_value($tag_name, $attribute_name, $attribute_value);
	
	if (!$from === false) // Results exist
	{
		$to = $html->get_tag_end_position( $tag_name, $from );
		$html->str_crop( $from, $to );
		
		//
		$from = $html->get_tag_start_position_with_attribute_name_and_value('h3', 'class', 'newaps');
		$to = $html->get_tag_end_position( 'h3', $from );
		$atfResults_html = new WP_HTML_Parser();
		$atfResults_html->save_HTML($html->get_the_HTML($from, $to));
		
		// Disect item link
		$h3_html = $atfResults_html->get_raw_HTML();
		$needle = "href=";
		$from = stripos($h3_html, $needle);
		$single_quote = stripos($h3_html, "'", $from);
		$double_quote = stripos($h3_html, '"', $from);
		$quote_type = '';
		if (($single_quote !== false) && ($double_quote !== false))
		{
			if($single_quote < $double_quote)
			{
				$from = $single_quote;
				$quote_type = 'single';
			}
			else
			{
				$from = $double_quote;
				$quote_type = 'double';
			}
		}
		elseif (($single_quote !== false) && ($double_quote === false))
		{
			$from = $single_quote;
			$quote_type = 'single';
		}
		elseif (($single_quote === false) && ($double_quote !== false))
		{
			$from = $double_quote;
			$quote_type = 'double';
		}
		else
		{
			return false; // Error, no quotes around the URL.
		}
		if ($quote_type == 'single')
		{
			$to = stripos($h3_html, "'", $from+1);
		}
		if ($quote_type == 'double')
		{
			$to = stripos($h3_html, '"', $from+1);
		}
		return "http://www.amazon.com".substr($h3_html, $from+1, $to-$from-1);
	}
	
	// Query days inactive and add 1
	return false;
}
?>

                    <h2>Get the item url</h2>
                    <?php $ASIN = 'B009W8YQ6K'; ?>
                    <p>ASIN: <?php echo $ASIN; ?></p>
                    <p>LINK: <?php echo get_item_link($ASIN); ?></p>
                    <?php update_post_meta(3067, 'link', 'http://www.amazon.com/Apple-MC707LL-Wi-Fi-Black-Generation/dp/B00746UR2E/ref=sr_1_1?ie=UTF8&qid=1380221556&sr=8-1&keywords=B00746UR2E'); ?> 
                </section>
                
                <section>
                <h2>View all items</h2>
<?php 
$deal_alerts = $wpdb->get_results('
	SELECT ID, item_author, item_ASIN, item_title, base_price, min_price, max_price, percent_change, thumbnail_URL
	FROM '.$wpdb->prefix.'items_of_interest
	WHERE days_inactive < 7'
);
if ($deal_alerts !== false)
{
	echo "\n\n<p>Retrieving Price information\n------------------------</p>\n";
	foreach ( $deal_alerts as $deal_alert ) 
	{
		echo "<p>ID = ".$deal_alert->ID."</p>";
		echo "<p>item_author = ".$deal_alert->item_author."</p>";
		echo "<p>item_ASIN = ".$deal_alert->item_ASIN."</p>";
		echo "<p>item_title = ".$deal_alert->item_title."</p>";
		echo "<p>base_price = ".$deal_alert->base_price."</p>";
		echo "<p>min_price = ".$deal_alert->min_price."</p>";
		echo "<p>max_price= ".$deal_alert->max_price."</p>";
		echo "<p>percent_change = ".$deal_alert->percent_change."</p>";
		echo "<p>link = ".$deal_alert->thumbnail_URL."</p>";
		echo "<p>--------------------------------</p>";
	}
}
?>
<?php $deal_alerts = $wpdb->query('
	DELETE FROM '.$wpdb->prefix.'items_of_interest
	WHERE ID == 423'
);
?>
                </section>
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>