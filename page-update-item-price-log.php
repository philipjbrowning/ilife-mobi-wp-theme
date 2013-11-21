<?php
/**
 * Template Name: Update Item Price Log
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

function update_item_price_log($item_ID, $new_price, $new_date)
{
	global $wpdb;
	// Save price information to the price log
	$result = $wpdb->insert(
		$wpdb->prefix.'item_price_log', 
		array(
			'ID'             => NULL,               // Integer
			'item_ID'        => $item_ID,           // Integer
			'price'          => $new_price,         // Decimal (9,2)
			'price_date'     => date($new_date),    // Date
			'price_date_gmt' => gmdate($new_date),  // Date
		), 
		array(
			'%d', // ID
			'%d', // item_ID
			'%f', // item_info->price
			'%s', // price_date
			'%s', // price_date_gmt
		) 
	);
	return $result;
}

function delete_item_price_log_entry($ID)
{
	global $wpdb;
	$result = $wpdb->delete(
		$wpdb->prefix.'item_price_log',
		array(
			'ID' => $ID
		), array(
			'%d'
		)
	);
	return $result;
}

$add_item_result_text = "";
$remove_item_result_text = "";
if ($_POST)
{
	if ($_POST['add_item'] == "Add")
	{
		$result = update_item_price_log($_POST['item_ID'], $_POST['new_price'], $_POST['new_date']);
		if ($result !== false ) {
			$add_item_result_text = "Success Adding item_ID " . $_POST['item_ID'];
		} else {
			$add_item_result_text = "Failure Adding item_ID " . $_POST['item_ID'];
		}
	}
	else if ($_POST['remove_item'] == "Remove")
	{
		$result = delete_item_price_log_entry($_POST['ID']);
		if ($result !== false ) {
			$remove_item_result_text = "Success removing ID #" . $_POST['ID'];
		} else {
			$remove_item_result_text = "Failure removing ID #" . $_POST['ID'];
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
                    <form id="add_item_form" method="post" action="">
                    	<p>Item ID: <input type="text" id="item_ID" name="item_ID" /></p>
                    	<p>New Price: <input type="text" id="new_price" name="new_price" /></p>
                    	<p>New Date: <input type="text" id="new_date" name="new_date" /></p>
                        <p><input type="submit" id="add_item" name="add_item" value="Add" /></p>
                    </form><br />
                    <p><?php echo $add_item_result_text; ?></p>
                    <br />
                    
                    <form id="remove_item_form" method="post" action="">
                    	<p>ID: <input type="text" id="ID" name="ID" /></p>
                        <p><input type="submit" id="remove_item" name="remove_item" value="Remove" /></p>
                    </form><br />
                    <p><?php echo $remove_item_result_text; ?></p>
                    <br />
<?php
$deal_alerts = $wpdb->get_results('
	SELECT ID, item_ID, price, price_date
	FROM '.$wpdb->prefix.'item_price_log 
	ORDER BY ID ASC'
);
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
                    	<td colspan="4">No Results</td>
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