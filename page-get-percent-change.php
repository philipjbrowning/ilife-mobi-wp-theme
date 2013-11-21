<?php
/**
 * Template Name: Get Percent Change
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

function get_percent_change($base_price, $current_price)
{
	if (($base_price < 0) || ($current_price < 0))
	{
		return false;
	}
	if ($base_price == 0)
	{
		return "N/A";
	}
	return ((float)$current_price - (float)$base_price) * 100.0 / (float)$base_price;
}

$get_percent_change_text = "";
$get_percent_change_results = "";
if ($_POST)
{
	if ($_POST['get_percent_change'] == "Get Percent Change")
	{
		$result = get_percent_change($_POST['base_price'], $_POST['current_price']);
		if ($result !== false ) {
			$get_percent_change_text = "Success calculating";
			$get_percent_change_results = $result;
		} else {
			$get_percent_change_text = "Failure calculating";
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
                    <form id="get_percent_change_form" method="post" action="">
                    	<p>Base Price: <input type="text" id="base_price" name="base_price" value="<?php echo @$_POST['base_price']; ?>" /></p>
                    	<p>Current Price: <input type="text" id="current_price" name="current_price" value="<?php echo @$_POST['current_price']; ?>" /></p>
                        <p><input type="submit" id="get_percent_change" name="get_percent_change" value="Get Percent Change" /></p>
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
                    	<td colspan="4">Percent Change = <?php print_r($get_percent_change_results); ?>%</td>
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