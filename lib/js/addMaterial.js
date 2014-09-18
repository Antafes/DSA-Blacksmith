$(function() {
	$('#addMaterial').on('click', function(e) {
		e.preventDefault();
		$('#addMaterialPopup').dialog('open');
	});
	$('#addMaterialType').on('click', function(e) {
		e.preventDefault();
		$('#addMaterialTypePopup').dialog('open');
	});
	$('#addMaterialPopup').dialog({
		title: $('#addMaterialPopup').data('title'),
		modal: true,
		autoOpen: false,
		width: 450,
		open: function() {
			$(this).children('form').submit(function(e) {
				e.preventDefault();
				var data = {},
					rawData = $(this).serializeArray(),
					row, i;

				for (i = 0; i < rawData.length; i++)
				{
					row = rawData[i];
					data[row.name] = row.value;
				}

				$.post('ajax/addMaterial.php', {data: data}, function (response) {
					if (response.ok === true)
					{
						document.location.reload();
					}
				}, 'json');
			});
		},
		close: function() {
			$(this).find('input, textarea').val('');
			$(this).find('select').val($(this).find('select').children(':first').attr('value'));
		}
	});
	$('#addMaterialTypePopup').dialog({
		title: $('#addMaterialTypePopup').data('title'),
		modal: false,
		autoOpen: false,
		open: function() {
			$(this).children('form').submit(function(e) {
				e.preventDefault();
				var rawData = $(this).serializeArray();

				$.post('ajax/addMaterialType.php', {name: rawData[0].value}, function (response) {
					if (response.ok === true)
					{
						var option = $('<option></option>');
						option.attr('value', response.id);
						option.text(response.name);
						$('.materialType').children('select').append(option);
						$('#addMaterialTypePopup').dialog('close');
					}
				}, 'json');
			});
		},
		close: function() {
			$(this).find('input:not([type=submit])').val('');
		}
	});
});