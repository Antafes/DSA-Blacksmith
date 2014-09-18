$(function() {
	$('#addTechnique').on('click', function(e) {
		e.preventDefault();
		$('#addTechniquePopup').dialog('open');
	});
	$('#addTechniquePopup').dialog({
		title: $('#addTechniquePopup').data('title'),
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

				$.post('ajax/addTechnique.php', {data: data}, function (response) {
					if (response.ok === true)
					{
						document.location.reload();
					}
				}, 'json');
			});
		},
		close: function() {
			$(this).find('input:not([type=submit]), textarea').val('');
		}
	});
});