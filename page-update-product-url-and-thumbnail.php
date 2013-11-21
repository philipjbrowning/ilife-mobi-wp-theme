<?php
/**
 * Template Name: Thumbnail and Item URL
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
                    <h2>Add Thumbnail URL and Item URL</h2>
                    <?php while (have_posts()) : the_post(); ?>
                        <h3><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <time datetime="<?php the_time(); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
                        <?php the_content(); ?>
                    <?php endwhile;?>
                    <?php else: ?>
                    <h3>No deal alerts to display.</h3>
                    <?php endif; ?>
                </section> <!-- /#main -->
				
                <section id="other" class="margin_left_200px">
					<h2>Show Current Thumbnail and Item URLs</h2>
                    
       <?php 
$deal_alerts = $wpdb->get_results('
	SELECT ID, item_author, item_ASIN, item_title, item_URL, thumbnail_URL, days_inactive
	FROM '.$wpdb->prefix.'items_of_interest'
);
if ($deal_alerts !== false)
{
	echo "\n\n<p>Retrieving Price information\n------------------------</p>\n";
	foreach ( $deal_alerts as $deal_alert ) 
	{
		echo "<p>ID = ".$deal_alert->ID."</p>";
		echo "<p>item_author = ".$deal_alert->item_author."</p>";
		echo "<p>item_ASIN = ".$deal_alert->item_ASIN."</p>";
		echo "<p>item_title = ".$deal_alert->item_title."</p>";
		echo "<p>item_URL = ".$deal_alert->item_URL."</p>";
		echo "<p>thumbnail_URL = ".$deal_alert->thumbnail_URL."</p>";
		echo "<p>days_inactive = ".$deal_alert->days_inactive."</p>";
		echo "<p>--------------------------------</p>";
	}
}
?>
                </section>
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>