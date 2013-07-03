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

<?php if ( !is_user_logged_in() ) { ?>
    
    <h1>iLife Mobi</h1>
    <p>Page not found.</p>
    
<?php } else { ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<br />
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

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>