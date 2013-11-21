        <aside id="sidebar" class="align_left margin_right_20px width_180px">
            
            <section id="container_search" class="align_left margin_bottom_20px top_corners_curved width_180px">
<?php get_search_form(); ?>
            </section>

            <section id="add_deal_alert" class="align_left width_180px"> 
<?php if ( is_user_logged_in() ) { // ===== DISPLAY SECTION TO ADD ITEM =================================================================================
			global $wpdb;
			$current_user = wp_get_current_user();
?>
            	<h2>Unused Sidebar</h2>
                </form>
<?php } else { // ===== DISPLAY SECTION TO EXPLAIN HOW ITEMS CAN BE ADDED =============================================================================== ?>
				<h2>Deal Alert</h2>
                <p>On iLife.Mobi, users can enter an AISN number to receive deal alerts on a list of items. In order to use this feature, you must <?php wp_loginout(); ?> or <?php wp_register('', ''); ?>.</p>
<?php } // END OF IF USER LOGGED IN() =================================================================================================================== ?>
            </section> <!-- /#add_deal_alert -->            
        </aside> <!-- /#sidebar -->