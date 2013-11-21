<?php
/**
 * Template Name: View Items of Interest
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
	SELECT ID, item_author, item_ASIN, item_title, current_price, base_price, min_price, max_price, percent_change, thumbnail_URL, item_URL, days_inactive
	FROM '.$wpdb->prefix.'items_of_interest'
);
if ($deal_alerts !== false) {
?>
					<p>Retrieving Price information<br/>--------------------------------</p>
<?php
	foreach ( $deal_alerts as $deal_alert ) 
	{	
?>
					<p>ID = <?php echo $deal_alert->ID; ?></p>
					<p>item_author = <?php echo $deal_alert->item_author; ?></p>
					<p>item_ASIN = <?php echo $deal_alert->item_ASIN; ?></p>
					<p>item_title = <?php echo $deal_alert->item_title; ?></p>
					<p>current_price = $<?php echo $deal_alert->current_price; ?></p>
					<p>base_price = $<?php echo $deal_alert->base_price; ?></p>
					<p>min_price = $<?php echo $deal_alert->min_price; ?></p>
					<p>max_price = $<?php echo $deal_alert->max_price; ?></p>
					<p>percent_change = <?php echo $deal_alert->percent_change; ?>%</p>
					<p>thumbnail_URL = <?php echo $deal_alert->thumbnail_URL; ?></p>
					<p>item_URL = <?php echo $deal_alert->item_URL; ?></p>
					<p>days_inactive = <?php echo $deal_alert->days_inactive; ?></p>
                    <p>--------------------------------</p>
<?php
	}
} else {
?>
					<p>No Results</p>
<?php } ?>			
                </section> <!-- /#main -->
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>