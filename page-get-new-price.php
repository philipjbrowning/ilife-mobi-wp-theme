<?php
/**
 * Template Name: Get New Price
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


/**
 * Retrieves a price from Amazon.com, returning the value.
 *
 * @parameters:  [string] Amazon Sales Inquiry Number (ASIN)
 * @return:      [float] price, if the ASIN is found
 *               [bool] false, if the ASIN is not found
 */
function get_new_price($item_ASIN)
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
		$from = $html->get_tag_start_position_with_attribute_name_and_value('li', 'class', 'newp');
		$to = $html->get_tag_end_position( 'li', $from );
		$price_html = new WP_HTML_Parser();
		$price_html->save_HTML($html->get_the_HTML($from, $to));
		
		// Disect price
		$tag_name = 'span';
		$price_from = $price_html->get_tag_start_position($tag_name);
		$price_to = $price_html->get_tag_end_position( $tag_name, $price_from );
		$price_span = $price_html->get_the_HTML($price_from, $price_to);
		
		$price_start = stripos($price_span, '$') + 1; // +1 to remove $
		$price_end = stripos($price_span, '<', $price_start);
		return substr($price_span, $price_start, $price_end - $price_start);
	}
	// Query days inactive and add 1
	return false;
}


?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
                	<h2><?php the_title(); ?></h2>
<?php
$results = $wpdb->get_results('
	SELECT ID, item_author, item_ASIN, item_title, current_price, base_price, min_price, max_price, percent_change, thumbnail_URL, item_URL, days_inactive
	FROM '.$wpdb->prefix.'items_of_interest'
);
if ($results !== false) {
?>
					<h3>Retrieving Price information</h3>
					<table style="width:100%">
                    	<tr>
                        	<th style="text-align:left">ID</th>
                            <th style="text-align:left">item_ASIN</th>
                            <th style="text-align:left">New Price</th>
                        </tr>
<?php
	foreach ( $results as $result ) 
	{
		$price = get_new_price($result->item_ASIN);
?>
						<tr>
                        	<td><?php echo $result->ID; ?></td>
                        	<td><?php echo $result->item_ASIN; ?></td>
                        	<td>$<?php echo $price; ?></td>
        				</tr>
<?php
	}
?>
					</table>
<?php
} else {
	echo "<p>No results</p>\n";
}
?>			
                </section> <!-- /#main -->
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>