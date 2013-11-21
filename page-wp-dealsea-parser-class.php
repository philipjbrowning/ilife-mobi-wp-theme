<?php
/**
 * Template Name: WP Dealsea Parser Class
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
global $wpdb;
$wpdb->show_errors();
$current_user = wp_get_current_user();
if ( !($current_user instanceof WP_User) ) {
     $current_user->ID = 0;
}

// Create new WP_Dealsea_Parser Object
$html = new WP_Dealsea_Parser;

// Add new Items to the database
$results = $html->update_items_to_database();

?> 
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<h2><?php the_title(); ?></h2>
                    <?php the_content(); ?><br />
                    <pre><?php echo $results; ?></pre>
<?php endwhile; ?>
                </section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>