<?php
/**
 * Template Name: Testing
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
?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header' ) ); ?>

<form id="select_URL" name="select_URL" action="<?php echo home_url(); ?>" method="get">

<!-- =========================================================================================== -->
<div id="main_top" class="bg_grey">
	
    <div id="logo_top" class="align_left height_50">
        <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
    </div>
    <div id="search_input_top" class="align_left height_50">
        <input type="url" id="website_URL" class="line_height_24 search_input" name="website_URL" placeholder="Enter a URL (e.g. http://www.amazon.com)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter a URL (e.g. http://www.amazon.com)'" value="" required />
    </div>
    <div id="search_buttons_top" class="align_left height_50">
        <input type="submit" id="search_submit" name="search_submit" value="Parse" />
    </div>
    <div id="links_top" class="align_left height_50">
        <p><input type="button" id="button_testing" name="button_testing" value="Testing" /></p>
        <input type="hidden" id="remove_comments" class="" name="remove_comments" checked="checked" />
        <input type="hidden" id="remove_header" class="" name="remove_header" checked="checked" />
        <input type="hidden" id="remove_script" class="" name="remove_script" checked="checked" />
        <input type="hidden" id="remove_style" class="" name="remove_style" checked="checked" />
        <input type="hidden" id="remove_whitespace" class="" name="remove_whitespace" />
    </div>
	
</div> <!-- End of #main_top -->
<!-- =========================================================================================== -->

</form>

<!-- =========================================================================================== -->
<div id="test_results">
	
    <!-- ======================================================================================= -->
	<div id="test_result_<?php echo $post->ID; ?>" class="align_left margin_left_160 results_left">
    	
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
        <?php endwhile; ?>
        
	</div>
	<!-- ======================================================================================= -->
	
    <!-- ======================================================================================= -->
	<div id="sidebar" class="align_left width_250px">
    	
        <h2><?php the_title(); ?></h2>
    	<ul>
        <?php 
        $args = array(
            'depth'        => 0,
            'show_date'    => '',
            'date_format'  => get_option('date_format'),
            'child_of'     => 459,
            'exclude'      => '',
            'include'      => '',
            'title_li'     => __('Pages'),
            'echo'         => 1,
            'authors'      => '',
            'sort_column'  => 'menu_order, post_title',
            'link_before'  => '',
            'link_after'   => '',
            'walker'       => '',
            'post_type'    => 'page',
                'post_status'  => 'publish' 
        );
        wp_list_pages( $args );
        ?>
        <li><a href="http://ilife.mobi/?page_id=395">PHP Test</a></li>
        </ul>
    
    </div> <!-- End of #search_results -->
	<!-- =========================================================================================== -->


</div> <!-- End of #test_results -->
<!-- =========================================================================================== -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>