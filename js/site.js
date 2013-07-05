/**
 * The JQuery for the website
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
jQuery(document).ready(function($) {
	
	//
	$('.form_change').change(function() {
		$('#select_URL_top').submit();
	});
	
	$('#button_testing').click(function() {
		window.location = "?page_id=459";
	});
	
	$('#select_URL').submit(function() {
		// alert("SENDING");
		$('#website_URL').css('background-image','url(http://ilife.mobi/wp-content/themes/ilife-mobi-wp-theme/images/ajax-loader-16.gif)');
	});
	
	$('#select_URL_top').submit(function() {
		
		// Set up some variables with needed values
		var list_container_tag_name = $('#list_container_tag_name').val();
			list_item_tag_name      = $('#list_item_tag_name').val();
			website_URL             = $('#website_URL').val(),
		    remove_comments         = $('#remove_comments').attr('checked'),
			remove_header           = $('#remove_header').attr('checked'),
			remove_script           = $('#remove_script').attr('checked'),
			remove_style            = $('#remove_style').attr('checked'),
			remove_whitespace       = $('#remove_whitespace').attr('checked'),
			search_submit           = $('#search_submit').val(),
			url_variables           = new Object(),
			ajax_loader = '<img id="loader" src="http://ilife.mobi/wp-content/themes/ilife-mobi-wp-theme/images/ajax-loader.gif" alt="Loading..." />';
		
		/*
		alert(
			"remove_comments = "+remove_comments+
			"\nremove_header = "+remove_header+
			"\nremove_script = "+remove_script+
			"\nremove_style = "+remove_style+
			"\nremove_whitespace = "+remove_whitespace
		);
		*/
		
		// URL Variables
		$("input[id^=variable_]").each(function(index, element) {
			/* alert(
				"id = "+this.id+
				"\nvalue = "+$(element).val()
			); */
			url_variables[this.id] = $(element).val();
        });
		
		// Show the ajax loader
		$('#code_results').html(ajax_loader);
		
		$.get('wp-content/themes/ilife-mobi-wp-theme/internal/search_URL_top.php', {
			website_URL: website_URL,
			search_submit: search_submit,
			remove_comments: remove_comments,
			remove_header: remove_header,
			remove_script: remove_script,
			remove_style: remove_style,
			remove_whitespace: remove_whitespace,
			url_variables: url_variables,
			list_container_tag_name: list_container_tag_name,
			list_item_tag_name: list_item_tag_name
		}, function(data) {
			// Hide the ajax loader
			$('#loader').hide();
			if (data != false)
			{
				$('#code_results').append(data);
			} else {
				$('#code_results').append("<p><b>ERROR:</b> Could not load data from AJAX function.</p>");
			}
		});
		
		return false; // So that the form will not be submitted through HTML.
	});
});