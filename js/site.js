/**
 * The JQuery for the website
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
jQuery(document).ready(function($) {
	// Set up some variables with needed values
	var settings = {
		list_container_attribute_name  : $('#list_container_attribute_name').val(),
		list_container_attribute_value : $('#list_container_attribute_value').val(),
		list_container_tag_name        : $('#list_container_tag_name').val(),
		list_item_attribute_name       : $('#list_item_attribute_name').val(),
		list_item_attribute_value      : $('#list_item_attribute_value').val(),
		list_item_tag_name             : $('#list_item_tag_name').val(),
		remove_comments                : $('#remove_comments').attr('checked'),
		remove_header                  : $('#remove_header').attr('checked'),
		remove_script                  : $('#remove_script').attr('checked'),
		remove_style                   : $('#remove_style').attr('checked'),
		remove_whitespace              : $('#remove_whitespace').attr('checked'),
		search_submit                  : $('#search_submit').val(),
		url_variables                  : new Object(),
		website_URL                    : $('#website_URL').val(),
	};
	
	var ajax_loader = '<img id="loader" src="http://ilife.mobi/wp-content/themes/ilife-mobi-wp-theme/images/ajax-loader.gif" alt="Loading..." />';
	
	// URL Variables
	$("input[id^=variable_]").each(function(index, element) {
		settings['url_variables'][this.id] = $(element).val(); // get within settings
		console.log(this.id + " = " + settings['url_variables'][this.id]);
	});
	
	//
	$('.form_change').change(function() {
		if (this.id != 'website_URL')
		{
			// Show the ajax loader
			$('#code_results').html(ajax_loader);
		}
		
		if (this.id.substring(0, 9) == "variable_") {
			settings['url_variables'][this.id] = $(this).val();
			change_url(settings);
		} else {
			var get_results;
			switch (this.id)
			{
				case 'list_container_attribute_name':
					settings[this.id] = $(this).val();
					get_attribute_name_list(settings, get_attribute_name_list_results);
					break;
				case 'list_container_attribute_value':
					settings[this.id] = $(this).val();
					get_attribute_value_list(settings, get_attribute_value_list_results);
					break;
				case 'list_container_tag_name':
					settings[this.id] = $(this).val();
					get_tag_name_list(settings, get_tag_name_list_results);
					break;
				case 'list_item_attribute_name':
					settings[this.id] = $(this).val();
					get_attribute_name_list(settings, get_attribute_name_list_results);
					break;
				case 'list_item_value_name':
					settings[this.id] = $(this).val();
					get_attribute_value_list(settings, get_attribute_value_list_results);
					break;
				case 'list_item_tag_name':
					settings[this.id] = $(this).val();
					get_tag_name_list(settings, get_tag_name_list_results);
					break;
				case 'remove_comments': settings[this.id] = $(this).attr('checked'); change_options(settings, change_options_results); break;
				case 'remove_header': settings[this.id] = $(this).attr('checked'); change_options(settings, change_options_results); break;
				case 'remove_script': settings[this.id] = $(this).attr('checked'); change_options(settings, change_options_results); break;
				case 'remove_style': settings[this.id] = $(this).attr('checked'); change_options(settings, change_options_results); break;
				case 'remove_whitespace': settings[this.id] = $(this).attr('checked'); change_options(settings, change_options_results); break;
				case 'search_submit': settings[this.id] = $(this).val(); change_url(settings, change_url_results); break;
				case 'website_URL': settings[this.id] = $(this).val(); break;
				default: return; break;
			}
		}
		
		// TEST OUTPUT
		if (this.id.substring(0, 9) == "variable_") {
			console.log(this.id + " = " + settings['url_variables'][this.id]);
		} else {
			console.log(this.id + " = " + settings[this.id]);
		}
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
		var list_container_attribute_name  = $('#list_container_attribute_name').val(),
			list_container_attribute_value = $('#list_container_attribute_value').val(),
			list_container_tag_name        = $('#list_container_tag_name').val(),
			list_item_attribute_name       = $('#list_item_attribute_name').val(),
			list_item_attribute_value      = $('#list_item_attribute_value').val(),
			list_item_tag_name             = $('#list_item_tag_name').val(),
		    remove_comments                = $('#remove_comments').attr('checked'),
			remove_header                  = $('#remove_header').attr('checked'),
			remove_script                  = $('#remove_script').attr('checked'),
			remove_style                   = $('#remove_style').attr('checked'),
			remove_whitespace              = $('#remove_whitespace').attr('checked'),
			search_submit                  = $('#search_submit').val(),
			url_variables                  = new Object(),
			website_URL                    = $('#website_URL').val(),
			ajax_loader = '<img id="loader" src="http://ilife.mobi/wp-content/themes/ilife-mobi-wp-theme/images/ajax-loader.gif" alt="Loading..." />';
		
		
		
		// Show the ajax loader
		$('#code_results').html(ajax_loader);
		
		$.get('wp-content/themes/ilife-mobi-wp-theme/internal/search_URL_top.php', {
			list_container_attribute_name: list_container_attribute_name,
			list_container_attribute_value: list_container_attribute_value,
			list_container_tag_name: list_container_tag_name,
			list_item_attribute_name: list_item_attribute_name,
			list_item_attribute_value: list_item_attribute_value,
			list_item_tag_name: list_item_tag_name,
			remove_comments: remove_comments,
			remove_header: remove_header,
			remove_script: remove_script,
			remove_style: remove_style,
			remove_whitespace: remove_whitespace,
			search_submit: search_submit,
			url_variables: url_variables,
			website_URL: website_URL
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

function change_options_results(data)
{
	console.log('#4 [change_options_results] data = ' + data);
	jQuery(document).ready(function($) {
		$('#code_results').html(data);
	});
}

function change_url_results(data)
{
	console.log('#4 [change_url_results] data = ' + data);
	// Hide Ajax Loader
	$('#loader').hide();
}

function get_attribute_name_list_results(data)
{
	console.log('#4 [get_attribute_name_list_results] data = ' + data);
	// Hide Ajax Loader
	$('#loader').hide();
}

function get_attribute_value_list_results(data)
{
	console.log('#4 [get_attribute_value_list_results] data = ' + data);
	// Hide Ajax Loader
	$('#loader').hide();
}

function get_tag_name_list_results(data)
{
	console.log('#4 [get_tag_name_list_results] data = ' + data);
	// Hide Ajax Loader
	$('#loader').hide();
}