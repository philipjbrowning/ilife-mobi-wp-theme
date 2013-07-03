<?php
/**
 * Template Name: PHP Test
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
<p>If there are errors, make sure that the class is public and not set to private, for testing.</p>
<br />
    
    <h1>iLife Mobi</h1>
    <p>Page not found.</p>
    
<?php } else { ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php


$html = new WP_HTML_Parser;

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<p>If there are errors, make sure that the class is public and not set to private, for testing.</p>
<br />


<?php /* ===== TESTING: get_tag_end_position_from_html( $html_block, $tag_name, $html_offset=0 ) ======================================== */ ?>
<br />
<p><u>TESTING: get_tag_end_position_from_html( $html_block, $tag_name, $html_offset=0 )</u></p>
<?php
$sample_URL='http://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=iphone';
echo "<p>sample_URL = ".htmlentities($sample_URL)."</p>";
$save_success = $html->save_HTML_with_URL($sample_URL);
if(!is_wp_error($save_success))
{
	$tag_name = "div";
	$html_offset = 30000;
	
	echo "<p>tag_name = $tag_name</p>";
	echo "<p>html_offset = $html_offset</p>";
	
	$tag_end_position = $html->get_tag_end_position($tag_name, $html_offset);
	
	if(is_numeric($tag_end_position)) {
		echo "<p>tag_end_position = $tag_end_position</p>";
	}
	elseif(is_bool($tag_end_position))
	{
		echo "<p>Did not find the tag</p>";
	}
	elseif(is_wp_error($tag_end_position))
	{
		$codes = $tag_end_position->get_error_codes();
		for($i=0; $i<count($codes); $i++)
		{
			$code = $codes[$i];
			echo "<p>".$tag_end_position->get_error_message($code)."</p>";
		}
	}
	else
	{
		echo "<p>New Error</p>";
	}
}
else // is_wp_error()
{
	$codes = $save_success->get_error_codes();
	for($i=0; $i<count($codes); $i++)
	{
		$code = $codes[$i];
		echo "<p>".$save_success->get_error_message($code)."</p>";
	}
}

?>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>