<?php
/**
 * Template Name: View Item Price Log
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
                	<h2><?php the_title(); ?></h2>
<?php
$deal_alerts = $wpdb->get_results('
	SELECT ID, item_ID, price, price_date
	FROM '.$wpdb->prefix.'item_price_log 
	ORDER BY item_ID ASC'
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