<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
 
/**
 *  Description:  This function is similar to file(), except that file_get_contents() returns the file in a
 *                string, starting at the specified offset up to maxlen bytes. On failure, file_get_contents()
 *                will return FALSE.
 *  
 *                file_get_contents() is the preferred way to read the contents of a file into a string. It
 *                will use memory mapping techniques if supported by your OS to enhance performance.
 *  
 *  Source:       http://us3.php.net/file_get_contents
 */
 
// Report all PHP errors
error_reporting(-1);

function prepare_HTML($url)
{
	$new_html = file_get_contents($url);

	// stripos() - Find the position of the first occurrence of a case-insensitive substring in a string
	$first_entry_start = stripos($new_html, '<div class="dealbox">');

	// strripos() - Find the position of the last occurrence of a case-insensitive substring in a string
	$last_entry = '</a></span></p><div class="break"></div></span></div>';
	$last_entry_start = strripos($new_html, $last_entry);

	// The length of the html string
	$html_strlen = strlen ($new_html);
	
	// Strip off all html except the individual deal items
	$new_html = substr($new_html, $first_entry_start, ($last_entry_start - $first_entry_start + strlen($last_entry)));
	
	return $new_html;
}

$html = prepare_HTML('http://dealsea.com');

echo "<pre>";
print_r($html);
echo "</pre>";


/*
$haystack = $html;
$needle = '<div class="dealbox">';

// stripos() - Find the position of the first occurrence of a case-insensitive substring in a string
$first_entry_start = stripos( $haystack, $needle );

// strripos() - Find the position of the last occurrence of a case-insensitive substring in a string
$last_entry_start = strripos( $haystack, $needle )

// substr() - Return part of a string
echo substr($haystack, $first_entry_start, count($html) );




// $xml = new SimpleXMLElement(file_get_contents("http://ws.geonames.org/postalCodeSearch?postalcode=".$pc."&country=".$c));
*/
 
/*
function startElement($parser, $name, $attrs) 
{
    global $depth;
    for ($i = 0; $i < $depth[$parser]; $i++) {
        echo "  ";
    }
    echo "$name\n";
    $depth[$parser]++;
	echo "current depth: $depth\n";
}

function endElement($parser, $name) 
{
    global $depth;
    $depth[$parser]--;
	echo "current depth: $depth\n";
}

$xml_parser = xml_parser_create();
echo "<p>xml_parser_create\n";
xml_set_element_handler($xml_parser, "startElement", "endElement");
echo "<p>xml_set_element_handler</p>"; 

while ($data = fread($html, 4096)) {
	echo "<p>while ($data = fread($html, 4096)</p>"; 
    if (!xml_parse($xml_parser, $data, feof($html))) {
	echo "<p>xml_set_element_handler</p>"; 
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}

xml_parser_free($xml_parser);
echo "<p>xml_parser_free</p>"; 
*/

/*
 echo "<pre>";
 print_r( $html );
 echo "</pre>";
*/
?>

<?php if ( !is_user_logged_in() ) { ?>
    
    <h1>iLife Mobi</h1>
    <p>This website is under construction. Please come back at a later time.</p>
    
<?php } else { ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<?php comments_template( '', true ); ?>
<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php } // End of is_user_logged_in() ?>