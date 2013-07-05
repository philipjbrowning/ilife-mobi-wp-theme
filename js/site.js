
jQuery(document).ready(function($) {
	
	//
	$('.form_change').change(function() {
    	$('#select_URL').submit();
	});
	
	$('#button_testing').click(function() {
		window.location = "?page_id=459";
	});
});

