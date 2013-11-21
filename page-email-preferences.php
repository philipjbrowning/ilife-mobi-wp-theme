<?php
/**
 * Template Name: New Deal Alert
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
?> 
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<section id="heading" class="align_left margin_bottom_20px width_full">
                        <form id="update_user_settings" class="" name="update_user_settings" action="" method="get">
                        <h2>Email Preferences</h2>
                        <p><input type="checkbox" id="email_on_add" class="user_preferences_form_change" name="email_on_add"<?php if (get_the_author_meta( 'email_on_add', $current_user->ID) == 'yes') { ?> checked<?php } ?> /> Email when you add deal alerts.</p>
                        <p><input type="checkbox" id="email_on_remove" class="user_preferences_form_change" name="email_on_remove"<?php if (get_the_author_meta( 'email_on_remove', $current_user->ID) == 'yes') { ?> checked<?php } ?> /> Email when you remove deal alerts.</p>
                        <p><input type="checkbox" id="email_on_info_update" class="user_preferences_form_change" name="email_on_info_update"<?php if (get_the_author_meta( 'email_on_info_update', $current_user->ID) == 'yes') { ?> checked<?php } ?> /> Email when you update a deal alert's settings.</p>
                        <p><input type="checkbox" id="email_on_price_update" class="user_preferences_form_change" name="email_on_price_update"<?php if (get_the_author_meta( 'email_on_price_update', $current_user->ID) == 'yes') { ?> checked<?php } ?> /> Email when the price drops below the set percentage limit.</p>
                        <p><input type="submit" id="save_user_settings" class="" name="save_user_settings" value="Save" /></p>
                        <input type="hidden" id="item_author" name="item_author" value="<?php echo $current_user->ID; ?>" />
                        <input type="hidden" id="page_slug" name="page_slug" value="<?php the_slug(); ?>" />
                        <input type="hidden" id="plugins_url" name="plugins_url" value="<?php echo plugins_url(); ?>" />
                        <input type="hidden" id="template_url" name="template_url" value="<?php echo get_template_directory_uri(); ?>" />
                        </form>
                    </section> <!-- /#heading -->
<?php endwhile; ?>
                </section> <!-- /#main -->
                
            </div> <!-- /#content -->
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>