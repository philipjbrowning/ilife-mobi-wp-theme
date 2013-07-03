<?php
/**
 * Template Name: TEST: Get Tag End Position
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
<p>If there are errors, make sure that the class is public and not set to private, for testing.</p>
<br />
<?php the_content(); ?>
<br />
<?php
$html = new WP_HTML_Parser;
$sample_HTML='<html><body><div class="mine"><div class="theirs" /></div><div class="yours"></div></body></html>';
echo "<p>sample_HTML = ".htmlentities($sample_HTML)."</p>";
$html->save_HTML($sample_HTML);

function test_answer($new_answer)
{
	if(is_numeric($new_answer)) {
		echo "<p>TRUE</p>";
		echo "<p>Value = $new_answer</p>";
	}
	elseif(is_bool($new_answer))
	{
		echo "<p>false</p>";
	}
	else // WP_Error class
	{
		echo "<p>WP_Error</p>";
		echo "<p>";
		print_r($new_answer);
		echo "</p>";
	}
}

// ===== CASE #1 =====
$tag_name = "div";
echo "<br /><p>===== CASE #1 =====</p>";
echo "<p>tag_name = $tag_name</p>";
$answer = $html->get_tag_start_position( $tag_name );
test_answer($answer);

// ===== CASE #2 =====
$tag_name = "div";
echo "<br /><p>===== CASE #2 =====</p>";
echo "<p>tag_name = $tag_name</p>";
$answer = $html->get_tag_end_position_from_html_BETA( $sample_HTML, $tag_name);
test_answer($answer);

// ===== CASE #3 =====
$tag_name = "div";
$sample_HTML='<html><body><div class="mine"><span class="theirs" /></div><div class="yours"></div></body></html>';
echo "<br /><p>===== CASE #3 =====</p>";
echo "<p>sample_HTML = ".htmlentities($sample_HTML)."</p>";
echo "<p>tag_name = $tag_name</p>";
$answer = $html->get_tag_end_position_from_html_BETA( $sample_HTML, $tag_name);
test_answer($answer);

// ===== CASE #4 =====
$sample_HTML='';
$html->save_HTML($sample_HTML);
echo "<br /><p>===== CASE #4 =====</p>";
echo "<p>sample_HTML = ".htmlentities($sample_HTML)."</p>";
$answer = $html->get_tag_start_position( $tag_name );
test_answer($answer);
?>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>