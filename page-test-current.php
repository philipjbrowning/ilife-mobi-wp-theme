<?php
/**
 * Template Name: Test Current Price
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
                	<?php if ( have_posts() ): ?>
                    <h2>Test Current Price</h2>
                    <?php the_content(); ?>
                    <?php endif; ?>
<?php
$results = $wpdb->get_results("SELECT ID, item_ID, price, price_date
		  					   FROM ".$wpdb->prefix."item_price_log
		  					   WHERE ID IN (
							       SELECT MAX(ID)
								   FROM ".$wpdb->prefix."item_price_log
		  					   	   GROUP BY item_ID
							   )
							   ORDER BY item_ID ASC");
if ($results !== false) {
?>
					<table style="width:100%">
                    	<tr>
                        	<th style="text-align:left">ID</th>
                            <th style="text-align:left">Item ID</th>
                            <th style="text-align:left">Price</th>
                            <th style="text-align:left">Date</th>
                        </tr>
<?php
	foreach ( $results as $result ) 
	{
?>
						<tr>
                        	<td><?php echo $result->ID; ?></td>
                        	<td><?php echo $result->item_ID; ?></td>
                        	<td><?php echo $result->price; ?></td>
                        	<td><?php echo $result->price_date; ?></td>
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