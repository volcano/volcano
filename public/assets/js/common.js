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
	
	/* Functions */
	titleize = function(string)
	{
		var parts = string.split(/[_ -]/);
		
		$.each(parts, function (key, value) {
			parts[key] = value.charAt(0).toUpperCase() + value.slice(1)
		});
		
		return parts.join(' ');
	}
});
