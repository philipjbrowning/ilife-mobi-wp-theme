<?php
/**
 * Template Name: Get High Low Price
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

function get_new_high_low_price($item_ID)
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT item_ID, MAX(price) AS max_price, MIN(price) AS min_price
		  					   FROM ".$wpdb->prefix."item_price_log
							   WHERE item_ID =" . $item_ID);
	return $results[0];
}

$get_prices_result_text = "";
$get_prices_results = "";
if ($_POST)
{
	if ($_POST['get_prices'] == "Get Prices")
	{
		$result = get_new_high_low_price($_POST['item_ID']);
		if ($result !== false ) {
			$get_prices_result_text = "Success searching for item_ID " . $_POST['item_ID'];
			$get_prices_results = $result;
		} else {
			$get_prices_result_text = "Failure searching for  item_ID " . $_POST['item_ID'];
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
                	<h2><?php the_title(); ?></h2>
                    <form id="get_prices_form" method="post" action="">
                    	<p>Item ID: <input type="text" id="item_ID" name="item_ID" /></p>
                        <p><input type="submit" id="get_prices" name="get_prices" value="Get Prices" /></p>
                    </form><br />
                    <p><?php echo $get_prices_result_text; ?></p>
                    <br />
                    
                    <p><input type="button" src="" value="Reset" /></p>
                    <br />
<?php
$deal_alerts = '';
if ($_POST) {
	$deal_alerts = false;
} else {
	$deal_alerts = $wpdb->get_results('
		SELECT ID, item_ID, price, price_date
		FROM '.$wpdb->prefix.'item_price_log 
		ORDER BY ID ASC'
	);
}
if ($deal_alerts !== false) {
?>
					<p>Retrieving Price Log Information<br/>--------------------------------</p>
                    <table style="width:100%">
                    	<tr>
                    		<th style="text-align:left">ID</th>
                    		<th style="text-align:left">item_ID</th>
                    		<th style="text-align:left">price</th>
                    		<th style="text-align:left">price_date</th>
                    	</tr>
<?php
	foreach ( $deal_alerts as $deal_alert ) 
	{	
?>
						<tr>
                        	<td><?php echo $deal_alert->ID; ?></td>
                        	<td><?php echo $deal_alert->item_ID; ?></td>
                        	<td><?php echo $deal_alert->price; ?></td>
                        	<td><?php echo $deal_alert->price_date; ?></td>
                        </tr>
<?php
	}
} else {
?>
					<tr>
                    	<td colspan="4"><pre><?php print_r($get_prices_results); ?></pre></td>
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