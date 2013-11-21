<?php
/**
 * Template Name: Update Item of Interest
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

function update_item_of_interest($new_item_ID, $new_current_price, $new_base_price, $new_max_price, $new_min_price)
{
	global $wpdb;
	// Save price information to the price log
	$result = $wpdb->update( 
		$wpdb->prefix.'items_of_interest', 
		array( 
			'base_price'    => $new_base_price,     // Decimal (9,2)
			'current_price' => $new_current_price,  // Decimal (9,2) 
			'max_price'     => $new_max_price,      // Decimal (9,2) 
			'min_price'     => $new_min_price       // Decimal (9,2)
		), 
		array( 'ID' => $new_item_ID ), 
		array( 
			'%f',  // base_price
			'%f',  // current_price
			'%f',  // max_price
			'%f',  // min_price
		), 
		array( '%d' ) 
	);
	return $result;
}

$update_item_result_text = "";
if ($_POST)
{
	if ($_POST['update_item'] == "Update Item")
	{
		$result = update_item_of_interest($_POST['item_ID'], $_POST['current_price'], $_POST['base_price'], $_POST['max_price'], $_POST['min_price']);
		if ($result !== false ) {
			$update_item_result_text = "Success Updating item_ID " . $_POST['item_ID'];
		} else {
			$update_item_result_text = "Failure Updating item_ID " . $_POST['item_ID'];
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
                    	<p>ID: <input type="text" id="item_ID" name="item_ID" value="<?php echo @$_POST['item_ID']; ?>" /></p>
                    	<p>Current Price: <input type="text" id="current_price" name="current_price" value="<?php echo @$_POST['current_price']; ?>" /></p>
                    	<p>Base Price: <input type="text" id="base_price" name="base_price" value="<?php echo @$_POST['base_price']; ?>" /></p>
                    	<p>Max Price: <input type="text" id="max_price" name="max_price" value="<?php echo @$_POST['max_price']; ?>" /></p>
                    	<p>Min Price: <input type="text" id="min_price" name="min_price" value="<?php echo @$_POST['min_price']; ?>" /></p>
                        <p><input type="submit" id="update_item" name="update_item" value="Update Item" /></p>
                    </form><br />
                    <p><?php echo $update_item_result_text; ?></p>
                    <br />
<?php
$deal_alerts = $wpdb->get_results('
	SELECT ID, item_ASIN, current_price, base_price, min_price, max_price
	FROM '.$wpdb->prefix.'items_of_interest'
);
if ($deal_alerts !== false) {
?>
					<p>Retrieving Price Log Information<br/>--------------------------------</p>
                    <table style="width:100%">
                    	<tr>
                    		<th style="text-align:left">ID</th>
                    		<th style="text-align:left">item_ASIN</th>
                    		<th style="text-align:left">current_price</th>
                    		<th style="text-align:left">base_price</th>
                    		<th style="text-align:left">max_price</th>
                    		<th style="text-align:left">min_price</th>
                    	</tr>
<?php
	foreach ( $deal_alerts as $deal_alert ) 
	{	
?>
						<tr>
                        	<td><?php echo $deal_alert->ID; ?></td>
                        	<td><?php echo $deal_alert->item_ASIN; ?></td>
                        	<td>$<?php echo $deal_alert->current_price; ?></td>
                        	<td>$<?php echo $deal_alert->base_price; ?></td>
                        	<td>$<?php echo $deal_alert->max_price; ?></td>
                        	<td>$<?php echo $deal_alert->min_price; ?></td>
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