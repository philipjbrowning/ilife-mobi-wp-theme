/*
 *
 */

jQuery(document).ready(function($)
{
	// An update deal alert button is clicked from the settings page
	$('.delete_item').click(function() {
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
			var item_ID = this.id.slice(12); // The length of 'delete_item_' = 12;
			var existing_deal_alert = {
				ID             : item_ID,
				item_author    : $('#item_author').val(),
				item_ASIN      : $('#item_ASIN_'+item_ID).val(),
				item_title     : $('#item_title_'+item_ID).val(),
				percent_change : $('#percent_change_'+item_ID).val(),
				plugins_url    : $('#plugins_url').val()
			};
			delete_deal_alert(existing_deal_alert, delete_deal_alert_response);
		}
		return false;
	})
	
	
	// A delete deal alert button is clicked from the settings page
	$('.update_item').click(function() {
		var item_ID = this.id.slice(12); // The length of 'update_item_' = 12;
		var existing_deal_alert = {
			ID             : item_ID,
			item_author    : $('#item_author').val(),
			item_ASIN      : $('#item_ASIN_'+item_ID).val(),
			item_title     : $('#item_title_'+item_ID).val(),
			percent_change : $('#percent_change_'+item_ID).val(),
			plugins_url    : $('#plugins_url').val()
		};
		update_deal_alert(existing_deal_alert, update_deal_alert_response);
		return false;
	});
});


function delete_deal_alert_response(result, existing_deal_alert)
{
	// Remove the item from the table
	if (result == 'Success') {
		// Create growl-like notification alert
		create("default", { title:'Delete Successful', text:existing_deal_alert['item_title']});
		// iOS Notification style DIV showing deleted
		jQuery('#item_' + existing_deal_alert['ID']).hide(500, function() {
			jQuery('#item_' + existing_deal_alert['ID']).remove();
		});
	} else {
		// Create growl-like notification alert
		create("default", { title:'Delete Failed', text:'Try again later.'});
	}
}


function reload_settings_table()
{
	
}


function update_deal_alert_response(result, existing_deal_alert)
{
	// Remove the item from the table
	if (result == 'Success') {
		// Create growl-like notification alert
		create("default", { title:'Update Successful', text:existing_deal_alert['item_title']});
	} else {
		// Create growl-like notification alert
		create("default", { title:'Update Failed', text:'Try again later.'});
	}
}