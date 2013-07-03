<?php
/**
 * Template Name: TEST: Is Valid Tag Name
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

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<br />
<?php
$html = new WP_HTML_Parser;
$sample_HTML='<html><body><div class="mine"></div></body></html>';
echo "<p>sample_HTML = ".htmlentities($sample_HTML)."</p>";
$html->save_HTML($sample_HTML);


$attribute_name = "class";
echo "<p>attribute_name = $attribute_name</p>";

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
$tag_start = 11;
echo "<br /><p>===== CASE #1 =====</p>";
echo "<p>tag_start = $tag_start</p>";
$answer = $html->tag_has_attribute_name( $attribute_name, $tag_start );
test_answer($answer);

// ===== CASE #2 =====
$tag_start = 12;
echo "<br /><p>===== CASE #2 =====</p>";
echo "<p>tag_start = $tag_start</p>";
$answer = $html->tag_has_attribute_name( $attribute_name, $tag_start );
test_answer($answer);

// ===== CASE #3 =====
$tag_start = 16;
echo "<br /><p>===== CASE #3 =====</p>";
echo "<p>tag_start = $tag_start</p>";
$answer = $html->tag_has_attribute_name( $attribute_name, $tag_start );
test_answer($answer);
?>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>