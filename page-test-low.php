<?php
/**
 * Template Name: Test Low
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
                    <h2>Test Low Price</h2>
                    <?php the_content(); ?>
                    <?php endif; ?>
<?php
$results = $wpdb->get_results("SELECT item_ID, MIN(price) AS min_price, price_date
		  					   FROM ".$wpdb->prefix."item_price_log
		  					   GROUP BY item_ID
							   ORDER BY item_ID ASC");
if ($results !== false) {
	foreach ( $results as $result ) 
	{
		echo "<p>item_ID = ".$result->item_ID."</p>";
		echo "<p>min_price = $".$result->min_price."</p>";
		echo "<p>price_date = ".$result->price_date."</p>";
		echo "<p>----------------------------------------</p>";
	}
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