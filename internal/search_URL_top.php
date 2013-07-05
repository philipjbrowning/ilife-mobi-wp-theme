<?php 
// Include the wp-load'er
$path = $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
include_once($path);

if (!empty($_GET)) {
// Save $_GET variables
	$list_container_tag_name = false;
	$list_item_tag_name      = false;
	$remove_comments    = false;
	$remove_header      = false;
	$remove_script      = false;
	$remove_style       = false;
	$remove_whitespace  = false;
	$search_keyword     = '';
	$website_URL        = $_GET['website_URL'];
	
	if (isset($_GET['list_container_tag_name']))
	{
		$list_container_tag_name = $_GET['list_container_tag_name'];
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
	if (isset($_GET['search_keyword']))
	{
		$search_keyword = $_GET['search_keyword'];
	}
	if (isset($_GET['remove_whitespace']))
	{
		$remove_whitespace = true;
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
	
	// Plugin is activated
	$html = new WP_HTML_Parser;
	$options_result = $html->set_options($remove_comments, $remove_header, $remove_script, $remove_style, $remove_whitespace);
	$html->save_HTML_with_URL( $website_URL );
?>
<pre><?php print_r( $html->get_all_HTML() ); ?></pre>
<?php
}
else
{
	echo "<p>ERROR</p>";
}
?>
