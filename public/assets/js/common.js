$(function() {
	$.ajaxSetup({
		'cache': false
	});
	
	$("a.confirm").click(function(e) {
		e.preventDefault();
		var location = $(this).attr('href');
		
		var msg = "Are you sure?";
		if ($(this).data('msg')) {
			msg = $(this).data('msg');
		}
		
		bootbox.confirm(msg, "Cancel", "Yes", function (confirmed) {
			if (confirmed) {
				window.location.replace(location);
			}
		});
	});
});
