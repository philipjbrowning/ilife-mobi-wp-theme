<?php
/**
 * Template Name: TEST: Save to Database
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
error_reporting(-1);

if (!empty($_GET)) {
	
}

Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header' ) );

if (!empty($_GET)) { // ==================================================================================================================================== 

	Starkers_Utilities::get_template_parts( array( 'parts/shared/header' ) );
?>
    
    <!-- ======================================================================================= -->
    <div id="search_results">
        
        <!-- =================================================================================== -->
        <div id="sidebar" class="align_left margin_left_20 width_250px">
            
            <form>
            <h2>Save Search</h2>
            <p><label for="website_URL">URL:</label></p>
            <p><input type="url" is="website_URL" name="website_URL" /></p>
            </form>
            
        </div> <!-- End of #sidebar -->
        <!-- =================================================================================== -->
        
        
        <!-- =================================================================================== -->
        <div id="code_results" class="align_left margin_left_20 results_left">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			<p>If there are errors, make sure that the class is public and not set to private, for testing.</p>
			<br />
            
            <table id="past_searches">
            <thead>
            	<tr>
                	<th>ID</th>
                    <th>User ID</th>
                    <th>Date</th>
                    <th>GMT Date</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Remove Comments</th>
                    <th>Remove Header</th>
                    <th>Remove Script</th>
                    <th>Remove Style</th>
                    <th>Remove Whitespace</th>
                    <th>Container Tag Name</th>
                    <th>Container Attribute Name</th>
                    <th>Container Attribute Value</th>
                    <th>Item Tag Name</th>
                    <th>Item Attribute Name</th>
                    <th>Item Attribute Value</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="17"><?php echo date('l jS \of F Y h:i:s A'); ?></td>
                </tr>
            </tfoot>
<?php endwhile; ?>
        </div>
        <!-- =================================================================================== -->
        
    </div> <!-- End of #search_results -->
    <!-- =================================================================================== -->
    
<?php 
	Starkers_Utilities::get_template_parts( array( 'parts/shared/footer') );

} else { // No URL entered yet ============================================================================================================================= 

	Starkers_Utilities::get_template_parts( array( 'parts/shared/header-home') ); 
?>
    <!-- ======================================================================================= -->
    <!-- Initial search input on the home page. -->
    <div id="main" class="margin_bottom_60">
        
        <form id="select_URL" name="select_URL" action="" method="get">
        <div id="wrap_main" class="center center_text">
            <div id="logo" class="center">
                <h1><?php bloginfo( 'name' ); ?></h1>
            </div>
            <div id="search_input">
                <input type="url" id="website_URL" class="search_input" name="website_URL" placeholder="Enter a URL (e.g. http://www.amazon.com)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter a URL (e.g. http://www.amazon.com)'" required />
            </div>
            <div id="search_buttons">
                <input type="button" id="button_testing" class="button" name="button_testing" value="Testing" /> <input type="submit" id="search_submit" class="button" name="search_submit" value="Parse" />
            </div>
            <input type="hidden" id="remove_comments" class="" name="remove_comments" checked="checked" />
            <input type="hidden" id="remove_header" class="" name="remove_header" checked="checked" />
            <input type="hidden" id="remove_script" class="" name="remove_script" checked="checked" />
            <input type="hidden" id="remove_style" class="" name="remove_style" checked="checked" />
            <input type="hidden" id="remove_whitespace" class="" name="remove_whitespace" checked="checked" />
        </div> <!-- End of #wrap_main -->
        </form>
        
    </div> <!-- End of #main -->
    <!-- ======================================================================================= -->
<?php 
	Starkers_Utilities::get_template_parts( array( 'parts/shared/footer-home') );

} // End of if (!empty($_GET)) =============================================================================================================================

Starkers_Utilities::get_template_parts( array( 'parts/shared/html-footer') );
?>