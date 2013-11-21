<?php
/**
 * Template Name: iLife Mobi Class
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

if ($_POST)
{
	echo "<pre>";
	echo "<p>creation_date = " . date('Y-m-d H:i:s') . "</p>";
	echo "<p>creation_date_gmt = " . gmdate('Y-m-d H:i:s') . "</p>";
	echo "<p>item_title = " . $_POST['test_item_title'] . "</p>";
	echo "<p>item_AISN = " . $_POST['test_item_ASIN'] . "</p>";
	echo "<p>percent_change = " . $_POST['percent_change'] . "</p>";
	echo "</pre>";
	$result = $wpdb->insert(
		$wpdb->prefix.'items_of_interest', 
		array(
			'ID' => NULL,
			'item_author' => $current_user->ID,
			'creation_date' => date('Y-m-d H:i:s'),
			'creation_date_gmt' => gmdate('Y-m-d H:i:s'),
			'item_title' => $_POST['test_item_title'], 
			'item_ASIN' => $_POST['test_item_ASIN'] , 
			'percent_change' => $_POST['test_percent_change'] 
		), 
		array(
			'%d',
			'%d',
			'%s', 
			'%s',
			'%s', 
			'%s',
			'%f' 
		) 
	);
	echo "<pre>";
	print_r( $result );
	echo "</pre>";
}

$html = '';
if ($_GET)
{
	$html = new WP_HTML_Parser();
	$html->save_HTML_with_URL('http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords='.$_GET['keywords']);
}
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
<?php endwhile; ?>
					<form id="amazon_search" method="get" action="">
                    <p><label for="keywords">Enter ASIN: </label><input type="text" id="keywords" class="" name="keywords" value="<?php if ($_GET) { echo $_GET['keywords']; } ?>" /></p>
                    <p><input type="submit" name="submit" value="Search" />
                    </form>
<?php if ($_GET) { ?>
                    <h2>Cron Job Setup</h2>
<?php
$tag_name = 'div';
$attribute_name = 'id';
$attribute_value = 'atfResults';
$options = array(
	'remove_comments' => true,
	'remove_header' => true,
	'remove_script' => false,
	'remove_style' => true, // CSS
	'remove_whitespace' => false,
);
$html->set_options( $options );
$from = $html->get_tag_start_position_with_attribute_name_and_value($tag_name, $attribute_name, $attribute_value);
if (!$from === false) // Results exist
{
	$to = $html->get_tag_end_position( $tag_name, $from );
	$html->str_crop( $from, $to );
?>
					<p><b>atfResults:</b> <?php echo $from; ?> to <?php echo $to; ?></p>
                    <?php $html->print_all_HTML();  ?>
<?php
	$tag_name = 'li';
	$attribute_name = 'class';
	$attribute_value = 'newp';
	$from = $html->get_tag_start_position_with_attribute_name_and_value($tag_name, $attribute_name, $attribute_value);
	$to = $html->get_tag_end_position( $tag_name, $from );
	
	// Disect price
	$price_html = new WP_HTML_Parser();
	$price_html->save_HTML($html->get_the_HTML($from, $to));
	$tag_name = 'span';
	$price_from = $price_html->get_tag_start_position($tag_name);
	$price_to = $price_html->get_tag_end_position( $tag_name, $price_from );
	$price_span = $price_html->get_the_HTML($price_from, $price_to);
	
	$price_start = stripos($price_span, '$') + 1; // +1 to remove $
	$price_end = stripos($price_span, '<', $price_start);
	$price = substr($price_span, $price_start, $price_end - $price_start);
?>
					<p><b>Price:</b> <?php echo htmlentities($price); ?></p>
<?php
	$tag_name = 'div';
	$attribute_name = 'class';
	$attribute_value = 'imageContainer';
	$from = $html->get_tag_start_position_with_attribute_name_and_value($tag_name, $attribute_name, $attribute_value);
	$to = $html->get_tag_end_position( $tag_name, $from );
	
	$thumbnail_html = new WP_HTML_Parser();
	$thumbnail_html->save_HTML($html->get_the_HTML($from, $to));
	$tag_name = 'img';
	$attribute_name = 'src';
	$attribute_value = $thumbnail_html->get_attribute_value_of_tag( $tag_name, $attribute_name );
?>
                    <p><b>Thumbnail URL:</b> <?php echo $attribute_value; ?></p>
<?php } else { // No Results
	echo "<p>This item does not exist</p>";
	}
} ?>
                </section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>