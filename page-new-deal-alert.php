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
					<section id="heading"> 
						<?php
                        global $wpdb;
                        $current_user = wp_get_current_user();
        				?>
                        <h2>New Deal Alert</h2>          
                        <form id="new_deal_alert_form" action="" method="get">
                        <p><input type="text" id="item_title" class="new_deal_alert_form_change margin_bottom_5px width_180px" name="item_title" value="" placeholder="Name this Item" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name this Item'" /></p>
                        <p><input type="text" id="item_ASIN" class="new_deal_alert_form_change margin_bottom_5px width_180px" name="item_ASIN" value="" placeholder="Enter the ASIN" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter the ASIN'" /></p>
                        <p><input type="number" id="percent_change" class="new_deal_alert_form_change margin_bottom_5px width_180px" name="percent_change" value="" min="0.0" max="10.0" step="0.1" placeholder="Percent Change" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Percent Change'" /></p>
                        <p>--- or ---</p>
                        <p><input type="file" id="item_file" class="new_deal_alert_form_change margin_bottom_5px" name="item_file" accept=".csv, .txt" /></p>
                        <p>The file can be a CSV or TXT file with three columns. Example below<br />&nbsp;</p>
                        <p>Apple iPad 16GB, WiFi, Black; B0013FRNKG; 4.0;</p>
                        <p>Blue Macbook Pro Frosted Rubber Coated Hard Snap Clip On Case Cover; B009SFBHTG; 2.0;</p>
                        <p>Sony MN2SW SmartWatch for Android Phones - Black; B007VG6ZC8; 2.5;</p>
                        <input type="hidden" id="item_author" name="item_author" value="<?php echo $current_user->ID; ?>" />
                        <input type="hidden" id="page_slug" name="page_slug" value="<?php the_slug(); ?>" />
                        <input type="hidden" id="plugins_url" name="plugins_url" value="<?php echo plugins_url(); ?>" />
                        <input type="hidden" id="template_url" name="template_url" value="<?php echo get_template_directory_uri(); ?>" />
                        <p><input type="submit" id="add_item_submit" name="add_item_submit" class="not_uniform" value="Submit" disabled="disabled" /></p>
                        </form>
                    </section> <!-- /#add_deal_alert --> 
<?php endwhile; ?>
                </section> <!-- /#main -->
                
            </div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>