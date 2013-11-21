<?php
/**
 * Template Name: Get Price History
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

$history_results = false;
$result_text = "";
if ($_GET)
{
	if ($_GET['get_price_history'] == "Get Price History")
	{
		$history_results = get_price_history($_GET['item_IDs'], $_GET['days_of_prices']);
		if ($history_results !== false ) {
			$result_text = "Success retrieving prices.";
		} else {
			$result_text = "Failure retrieving prices.";
		}
	}
}
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
                	<h2><?php the_title(); ?>zzzz</h2>
<?php
$items_of_interest = $wpdb->get_results('
	SELECT ID, item_title
	FROM '.$wpdb->prefix.'items_of_interest'
);
if ($items_of_interest !== false) {
?>
                    <form id="get_price_history_form" method="get" action="">
<?php foreach ($items_of_interest as $item) { ?>
                        <p><input type="checkbox" name="item_IDs[]" value="<?php echo $item->ID ?>" /><?php echo $item->item_title; ?></p>
<?php } ?>
                    	<p>Days of History: <input type="text" id="days_of_prices" name="days_of_prices" value="<?php echo @$_GET['days_of_prices']; ?>" /></p>
                    	<p><input type="submit" id="get_price_history" name="get_price_history" value="Get Price History" /></p>
                    </form><br />
                    <p><?php echo $result_text; ?></p>
                    <br />
<?php } else { ?>
					<p>The are no items saved in the database.</p>
<?php
}

if ($history_results !== false) {
	$listed_results = array();
	foreach ($history_results as $item_history)
	{
		// Create a bucket(array) for each item_ID, if not already created.
		if(!isset($listed_results[$item_history->item_ID]))
		{
			$listed_results[$item_history->item_ID] = array("item_ID" => $item_history->item_ID, "price" => array(), "price_date" => array());
		}
		
		// Add item to the bucket(array) of the corresponding item_ID
		array_push($listed_results[$item_history->item_ID]['price'], $item_history->price);
		array_push($listed_results[$item_history->item_ID]['price_date'], $item_history->price_date);
	}
?>
					<p>Retrieving History Information<br/>--------------------------------</p>
                    <table style="width:100%">
                    	<tr>
                    		<th style="text-align:left">ID</th>
                    		<th style="text-align:left">Item ID</th>
                    		<th style="text-align:left">Price</th>
                    		<th style="text-align:left">Date</th>
                    	</tr>
<?php
	foreach ( $listed_results as $item_result ) 
	{	
		// Reverse order of the arrays. Before, most recent is first.
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
?>
						<tr>
                        	<td><?php echo $history_result->ID; ?></td>
                        	<td><?php echo $history_result->item_ID; ?></td>
                        	<td>$<?php echo $history_result->price; ?></td>
                        	<td><?php echo $history_result->price_date; ?></td>
                        </tr>
                        <tr>
                        	<td colspan="4"><img src="<?php echo get_template_directory_uri(); ?>/jpgraph/history-two-weeks.php<?php echo $arguments; ?>"></td>
                        </tr>
<?php
	}
} else {
?>
					<tr>
                    	<td colspan="4"><?php echo $update_item_result_text; ?></td>
                    </tr>
<?php } ?>			
					</table>
                </section> <!-- /#main -->
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>