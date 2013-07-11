<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
error_reporting(-1);
?>

<?php
if (!empty($_GET)) {
	
	// Save $_GET variables
	$list_container_attribute_name  = false;
	$list_container_attribute_value = false;
	$list_container_tag_name        = false;
	$list_item_attribute_name       = false;
	$list_item_attribute_value      = false;
	$list_item_tag_name             = false;
	$remove_comments                = false;
	$remove_header                  = false;
	$remove_script                  = false;
	$remove_style                   = false;
	$remove_whitespace              = false;
	$search_keyword                 = '';
	$website_URL                    = $_GET['website_URL'];
	
	if (isset($_GET['list_container_attribute_name']))
	{
		$list_container_attribute_name = $_GET['list_container_attribute_name'];
	}
	if (isset($_GET['list_container_attribute_value']))
	{
		$list_container_attribute_value = $_GET['list_container_attribute_value'];
	}
	if (isset($_GET['list_container_tag_name']))
	{
		$list_container_tag_name = $_GET['list_container_tag_name'];
	}
	if (isset($_GET['list_item_attribute_name']))
	{
		$list_item_attribute_name = $_GET['list_item_attribute_name'];
	}
	if (isset($_GET['list_item_attribute_value']))
	{
		$list_item_attribute_value = $_GET['list_item_attribute_value'];
	}
	if (isset($_GET['list_item_tag_name']))
	{
		$list_item_tag_name = $_GET['list_item_tag_name'];
	}
	if (isset($_GET['remove_comments']))
	{
		$remove_comments = true;
	}
	if (isset($_GET['remove_header']))
	{
		$remove_header = true;
	}
	if (isset($_GET['remove_script']))
	{
		$remove_script = true;
	}
	if (isset($_GET['remove_style']))
	{
		$remove_style = true;
	}
	if (isset($_GET['remove_whitespace']))
	{
		$remove_whitespace = true;
	}
	if (isset($_GET['search_keyword']))
	{
		$search_keyword = $_GET['search_keyword'];
	}
	
	// Retrieve any variables in the website URL
	$URL_variables = false;
	$var_start = stripos($website_URL, '?');
	if ($var_start !== false)
	{
		$URL_variables = array();
		$URL_variables_saved = 0;
		// Check if variables are saved
		foreach($_GET as $key => $value) {
			$search_term = "variable_";
			if (stripos($key, $search_term) === 0) // value starts with variables_
			{
				$URL_variables_saved++;
				if ($URL_variables_saved === 1)
				{
					$website_URL = substr($website_URL, 0, $var_start) . '?';
				}
				$URL_variables[substr($key, strlen($search_term))] = rawurldecode($value);
				// ${$key} = rawurlencode($value);
				$website_URL = $website_URL . substr($key, strlen($search_term)) . '=' . rawurlencode($value) . '&';
			}
		}
		if ($URL_variables_saved > 0)
		{
			// Remove last ampersand (&) value
			$website_URL = substr($website_URL, 0, -1);
		}
		else // If no variables are saved in $_GET
		{
			$website_URL_vars = substr($website_URL, $var_start + 1);
			do
			{
				$equal_char = stripos($website_URL_vars, '=');
				if ($equal_char !== false)
				{
					$var_name = substr($website_URL_vars, 0, $equal_char);
					$website_URL_vars = substr($website_URL_vars, $equal_char + 1);
					$ampersand_char = stripos($website_URL_vars, '&');
					if ($ampersand_char !== false)
					{
						$var_value = substr($website_URL_vars, 0, $ampersand_char);
						$website_URL_vars = substr($website_URL_vars, $ampersand_char + 1);
						$URL_variables[$var_name] = rawurldecode($var_value);
						
					} elseif (strlen($website_URL_vars) > 0) {
						// Last variable
						$URL_variables[$var_name] = rawurldecode($website_URL_vars);
					}
				}
			} while ($equal_char !== false && $ampersand_char !== false);
		}
	}
	// Create new Parsed Object
	$html = new WP_HTML_Parser;
	$options_result = $html->set_options($remove_comments, $remove_header, $remove_script, $remove_style, $remove_whitespace);
	
	//
	$html->save_HTML_with_URL( $website_URL );
	echo "<pre>";
	$list_container_tag_names = $html->get_all_tag_names();
	echo "</pre>";
	$list_container_tag_attributes = false;
	$list_container_tag_attribute_values = false;
	if ($list_container_tag_name !== false)
	{
		$list_container_tag_attributes = $html->get_all_attributes_within_tag( $list_container_tag_name );
	}
	// $tag_name = "div";
	// $body_start = $html->get_tag_start_position( $tag_name );
	// $body_end = $html->get_tag_end_position( $tag_name, $body_start );
}

Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header' ) );

if (!empty($_GET)) { // ==================================================================================================================================== 

	Starkers_Utilities::get_template_parts( array( 'parts/shared/header' ) );
?>
    
    <!-- ======================================================================================= -->
    <div id="search_results">
        
        <!-- =================================================================================== -->
        <div id="code_results" class="align_left margin_left_160 results_left">
            <pre><?php print_r( $html->get_all_HTML() ); ?></pre>
        </div>
        <!-- =================================================================================== -->
        
        
        <!-- =================================================================================== -->
        <div id="sidebar" class="align_left width_250px">
            <div id="options_data" class="margin_bottom_20">
                <h2>Data Options</h2>
                <p><input type="checkbox" id="remove_comments" class="form_change" name="remove_comments" <?php if ($remove_comments === true) { ?>checked="checked"<?php } ?> /> Remove comments</p>
                <p><input type="checkbox" id="remove_header" class="form_change" name="remove_header" <?php if ($remove_header === true) { ?>checked="checked"<?php } ?> /> Remove header</p>
                <p><input type="checkbox" id="remove_script" class="form_change" name="remove_script" <?php if ($remove_script === true) { ?>checked="checked"<?php } ?> /> Remove script</p>
                <p><input type="checkbox" id="remove_style" class="form_change" name="remove_style" <?php if ($remove_style === true) { ?>checked="checked"<?php } ?> /> Remove style</p>
                <p><input type="checkbox" id="remove_whitespace" class="form_change" name="remove_whitespace" <?php if ($remove_whitespace === true) { ?>checked="checked"<?php } ?> /> Remove extra whitespace</p>
            </div> <!-- End of #options_data -->
            
            <?php if ($URL_variables !== false) { ?>
            
            <div id="options_url" class="margin_bottom_20">
                <h2>URL Variables</h2>
                <?php foreach ($URL_variables as $key => $value) { ?>
                <p><label for="variable_<?php echo $key; ?>"><?php echo $key; ?>:</label></p>
                <p><input type="text" id="variable_<?php echo $key; ?>" class="form_change variables" name="variable_<?php echo $key; ?>" value="<?php echo $value; ?>" /></p>
                <?php } ?>
            </div> <!-- End of #options_url -->
            
            <?php } // End of if ($URL_variables !== false) ?>
            
            <div id="options_parsing" class="margin_bottom_20">
                <h2>Advanced Parsing</h2>
                <p><label for="list_container_tag_name">List container:</label></p>
                <p>
                <select id="list_container_tag_name" class="form_change" name="list_container_tag_name">
                    <option value=""<?php if (!$list_container_tag_name) { ?> selected="selected"<?php } ?>>Tag</option>
                    <?php foreach ($list_container_tag_names as $value) { ?>
                    <option value="<?php echo $value; ?>" <?php if ($list_container_tag_names === $value) { ?> selected="selected"<?php } ?>>&lt;<?php echo $value; ?>&gt;</option>
                    <?php } ?>
                </select>
                <select id="list_container_attribute_name" class="form_change" name="list_container_attribute_name" disabled="disabled">
                    <option value="">Attribute</option>
                </select>
                <select id="list_container_attribute_value" class="form_change" name="list_container_attribute_value" disabled="disabled">
                    <option value="">Value</option>
                </select>
                </p>
                <p><label for="list_item_tag_name">List Item:</label></p>
                <p>
                <select id="list_item_tag_name" class="form_change" name="list_item_tag_name" disabled="disabled">
                	<option value="">Tag</option>
                </select>
                <select id="list_item_tag_attribute" class="form_change" name="list_item_tag_attribute" disabled="disabled">
                	<option value="">Attribute</option>
                </select>
                <select id="list_item_tag_value" class="form_change" name="list_item_tag_value" disabled="disabled">
                	<option value="">Value</option>
                </select>
                </p>
                
            </div> <!-- End of #options_parsing -->
            
            <?php if ( is_user_logged_in() ) { // --------------------------------------------------- ?>
            
            <div>
                <p>more</p>
            </div> <!-- End of #advanced_parsing -->
            
            <?php  } else { ?> 
            
            <div id="user_login">
                <h2>Advanced Parsing</h2>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </div> <!-- End of #user_login -->
            
            <?php } // End of if ( is_user_logged_in() ) ?>
        </div> <!-- End of #sidebar -->
        <!-- =================================================================================== -->
	
    </div> <!-- End of #search_results -->
    <!-- =================================================================================== -->
    
    </form>
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