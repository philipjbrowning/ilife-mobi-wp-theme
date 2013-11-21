/*
 *
 */

var settings_submit = false;

jQuery(document).ready(function($) {
	// Uniform CSS styling
	$("input").not(".not_uniform, .admin-bar-search input").uniform();  // Method 2
	$("button").not(".admin-bar-search button").uniform();  // Method 2
	
	// Resize element based on page size
	var new_deal_alert = {
		item_ASIN       : $('#item_ASIN').val(),
		item_author     : $('#item_author').val(),
		item_file       : '',
		item_title      : $('#item_title').val(),
		page_slug       : $('#page_slug').val(),
		percent_change  : $('#percent_change').val(),
		plugins_url     : $('#plugins_url').val(),
		template_url    : $('#template_url').val()
	}
	var user_settings = {
		email_on_add          : $('#email_on_add').is(':checked'),
		email_on_remove       : $('#email_on_remove').is(':checked'),
		email_on_info_update  : $('#email_on_info_update').is(':checked'),
		email_on_price_update : $('#email_on_price_update').is(':checked'),
		item_author           : $('#item_author').val(),
		plugins_url           : $('#plugins_url').val()
	}
	var valid_file = false;
	
	// Changes to the Deal Alert Form
	$('.new_deal_alert_form_change').change(function() {
		switch (this.id)
		{
			case 'item_ASIN':
				new_deal_alert[this.id] = $(this).val();
				break;
			case 'item_file':
				// Check that the file extension is CSV or TXT
				var ext = $(this).val().split('.').pop().toLowerCase();
				if(jQuery.inArray(ext, ['csv','txt']) == -1) {
					create("default", { title:'Invalid File Type', text:'You can only upload CSV or TXT files.'});
					valid_file = false;
				} else {
					valid_file = true;
				}
				break;
			case 'item_title':
				new_deal_alert[this.id] = $(this).val();
				break;
			case 'percent_change':
				new_deal_alert[this.id] = $(this).val();
				break;
			default: return; break;
		}
		deal_alert_form_is_complete();
	});
	
	$('.user_preferences_form_change').change(function() {
		user_settings[this.id] = $('#'+this.id).is(':checked');
	});
	
	// Submit the Deal Alert Form
	$('#new_deal_alert_form').submit(function() {
		if (deal_alert_form_is_complete())
		{
			insert_deal_alert(new_deal_alert, insert_deal_alert_response);
		}
		return false;
	});
	
	$('#update_user_settings').submit(function() {
		if (settings_submit == false)
		{
			settings_submit = true;
			console.log('[site.js] email_on_add = '+user_settings['email_on_add']);
			console.log('[site.js] email_on_remove = '+user_settings['email_on_remove']);
			console.log('[site.js] email_on_info_update = '+user_settings['email_on_info_update']);
			console.log('[site.js] email_on_price_update = '+user_settings['email_on_price_update']);
			console.log('[site.js] item_author = '+user_settings['item_author']);
			console.log('[site.js] plugins_url = '+user_settings['plugins_url']);
			update_user_settings(user_settings, update_user_settings_response);
		}
		return false;
	});
	
	// Input validation for adding a new deal alert from the sidebar
	function deal_alert_form_is_complete()
	{
		var form_is_complete = true;
		if (new_deal_alert['item_ASIN'].length < 10)
		{
			form_is_complete = false;
		}
		if (new_deal_alert['percent_change'] == '')
		{
			form_is_complete = false;
		}
		if (new_deal_alert['item_title'].length < 3)
		{
			form_is_complete = false;
		}
		if ((new_deal_alert['item_file'].length > 6) && (valid_file == true)) { // length(_;_;_;) = 6
			form_is_complete =  true;
		}
		
		// Conclusion of the matter
		if (form_is_complete == true)
		{
			$('#add_item_submit').removeAttr('disabled');
			return true;
		}
		else {
			$('#add_item_submit').attr('disabled','disabled');
			return false;
		}
	}
	
	/* ------------
	-- FILE UPLOADS
	--------------- */
	
	var control = document.getElementById("item_file");
	if(control != null) {
		control.addEventListener("change", function(event) {
		
			// When the control has changed, there are new files
			var files = control.files;
			var file = files[0];
			
			var reader = new FileReader();
			reader.onload = function(event) {
				new_deal_alert['item_file'] = event.target.result;
				deal_alert_form_is_complete();
			};
			
			reader.onerror = function(event) {
				console.error("[site.js] File could not be read! Code " + event.target.error.code);
			};
			
			reader.readAsText(file);
		
		}, false);
	}
	
	/*
	
	*/
	
	/* -------------------------------------------------------------------------
	-- NOTIFICATION CENTER -----------------------------------------------------
	------------------------------------------------------------------------- */
	
	// Initialize widget on a container, passing in all the defaults. The
	// defaults will apply to any notification created within this container,
	// but can be overwritten on notification-by-notification basis.
	$container = $("#container_notify").notify();
	
	
	/* -------------------------------------------------------------------------
	-- WIDTH ADJUSTMENT OF GRAPHS ----------------------------------------------
	------------------------------------------------------------------------- */
	
	$(".individual_item_history_graph img").width( parseInt($("#main").width()));
	$( window ).resize(function() {
		console.log("#main width = " + $("#main").width());
		$(".individual_item_history_graph img").width( parseInt($("#main").width()));
	});
});

function create( template, vars, opts )
{
	return $container.notify("create", template, vars, opts);
}

function insert_deal_alert_response(result, new_deal_alert)
{
	var clear_form = false;
	var reload_settings_table = false;
	
	for (var i=0; i<result.length; i++)
	{
		create("default", { title:result[i]['title'], text:result[i]['message']});
		if (result[i]['result'] == 'Success')
		{
			clear_form = true;
			reload_settings_table = true;
		}
	}
	
	if (clear_form == true)
	{
		// Clear input values on the sidebar
		jQuery('#item_ASIN').val('');
		jQuery('#item_file').val('');
		jQuery('#item_title').val('');
		jQuery('#percent_change').val('');
		
		// Clear local variables
		new_deal_alert['item_ASIN'] = '';
		new_deal_alert['item_file'] = '';
		new_deal_alert['item_title'] = '';
		new_deal_alert['percent_change'] = '';
	}
	
	if (reload_settings_table == true)
	{
		// Update settings table
		if (new_deal_alert['page_slug'] == 'settings')
		{
			jQuery.get(new_deal_alert['template_url'] + '/parts/ajax-php-scripts/load-settings-table.php', {
				item_author : new_deal_alert['item_author']
			}, function(data) {
				// Reload settings table
				jQuery('#settings_form_and_table').html(data);
				jQuery("input").not(".not_uniform").uniform();  // Method 2
				jQuery("button").uniform();  // Method 2
			});
		} else {
			console.log('[site.js] Not the settings page.');
		}
	}
}

function update_user_settings_response(result)
{
	// Remove the item from the table
	if (result == 'Success') {
		// Create growl-like notification alert
		create("default", { title:'Update Successful', text:'User Email Preferences'});
	} else {
		// Create growl-like notification alert
		create("default", { title:'Update Failed', text:'Try again later.'});
	}
	settings_submit = false;
}