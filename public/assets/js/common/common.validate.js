/**
 * Form validation defaults.
 */
$(function () {
	if (!$.validator) {
		return;
	}
	
	// Set validator defaults.
	$.validator.setDefaults({ 
		errorElement: 'span',
		errorPlacement: function(error, element) {
			element.closest('.control-group').addClass('error');
			error.addClass('help-inline');
			element.closest('.controls').append(error);
		},
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.control-group').removeClass(validClass).addClass(errorClass);
			$(element).addClass(errorClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.control-group').removeClass(errorClass).addClass(validClass);
		}
	});
	
	// Initialize any forms on the page.
	$('form.form-validate').validate();
});
