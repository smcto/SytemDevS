$(document).ready(function () {
	$('.textarea_editor1').each(function() {
		$(this).wysihtml5({"image": false, "link": false});
	});
	
	$('.js-switch').each(function() {
		new Switchery($(this)[0], $(this).data());
	});
	
	$('#form_check').change( function() {
		if($(this).is(":checked")) {
			$('.sl-form-container').show(100);
			$('#form_uncheck').attr('name', '');
		}else{
			$('.sl-form-container').hide(100);
			$('#form_uncheck').attr('name', 'form_check');
		}
	});
	
	$('.sl-action').on('click', function(e){
		e.preventDefault();
		var sl_action = $(this).attr('data-action');
		var forms = $('body').find('form');
		
		if(sl_action == 'sl-fin'){
			forms.append('<input type="hidden" name="fin" value="true">');
		}else{
			var url = $('#'+sl_action).attr('href');			
			forms.attr('action', url);
		}
		
		forms.submit();
		
	});
	
	// Affichage seulement l'heure
	$('.sl-horaire').daterangepicker({
		singleDatePicker: true,
		timePicker : true,
		timePicker24Hour : true,
		timePickerIncrement : 1,
		timePickerSeconds : false,
		locale : {
			format : 'HH:mm:ss'
		}
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find(".calendar-table").hide();
	});
	
	// Affichage date + heure
	$('.sl-horaire-date').daterangepicker({
		singleDatePicker: true,
		timePicker : true,
		timePicker24Hour : true,
		timePickerIncrement : 1,
		timePickerSeconds : false,
		locale : {
			format : 'YYYY-MM-DD HH:mm:ss'
		}
    });
	
	$('.fg_numeric_entier').on('input', function(){
		var numeric = parseInt(jQuery.trim(jQuery(this).val()));
		if(typeof numeric != "undefined" && !isNaN(numeric) && numeric != 0)
			jQuery(this).val(numeric);
		else
			jQuery(this).val("");
	});
	
});
