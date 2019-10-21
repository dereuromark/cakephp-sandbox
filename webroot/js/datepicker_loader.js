var date_picker_id_counter = 1;

$(document).ready(function() {
	$('.date-picker-container').each(function() {
		var date_picker_day = 'date-picker-control-' + date_picker_id_counter + '-day';
		var date_picker_month = 'date-picker-control-' + date_picker_id_counter + '-month';
		var date_picker_year = 'date-picker-control-' + date_picker_id_counter + '-year';
		var date_picker_button = 'date-picker-control-' + date_picker_id_counter + '-button';

		var name = $(this).find('select').attr('name');
		name = name.substr(0, name.indexOf('['));

		$(this).find('select[name="'+name+'[day]"]').attr('id', date_picker_day);
		$(this).find('select[name="'+name+'[month]"]').attr('id', date_picker_month);
		$(this).find('select[name="'+name+'[year]"]').attr('id', date_picker_year);
		$(this).find('li.hour').attr('id', date_picker_button);

		datePickerController.createDatePicker({
			formElements:{[date_picker_year]:"%Y",[date_picker_month]:"%m",[date_picker_day]:"%d"},
			showWeeks:true,
			statusFormat:"%l, %d%S %F %Y",
			// Fill the entire grid with dates
			fillGrid:true,
			// Disable the selection of dates not within the current month
			// but rendered within the grid (as we used fillGrid:true)
			constrainSelection:true,
			// Set a final opacity of 90%
			finalOpacity:95,
			// Disable Monday (index =0) and Tuesday (index = 1)
			//disabledDays:[1,1,0,0,0,0,0],
			positioned: date_picker_button
			// The function "showEnglishDate" is declared below
			//callbackFunctions:{"create":[showEnglishDate],"dateset":[showEnglishDate]}
		});

		date_picker_id_counter++;
	});

});
