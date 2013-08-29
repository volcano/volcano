$(function() {
	$('#add-meta').on('click', function () {
		var element = $('#meta-fields').find('.control-group.hide:first');
		
		if (element.length) {
			element.removeClass('hide');
		} else {
			$('#add-meta').addClass('hide');
		}
	});
});
