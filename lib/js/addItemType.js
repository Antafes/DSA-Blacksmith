$(function() {
	$('#addItemType').on('click', function(e) {
		e.preventDefault();
		$('#addItemTypePopup').dialog('open');
	});
	$('#addItemTypePopup').dialog({
		title: $('#addItemTypePopup').data('title'),
		modal: true,
		autoOpen: false,
		width: 450,
		open: function() {
			$(this).children('form').on('submit', function(e) {
				e.preventDefault();
				var data = {},
					rawData = $(this).serializeArray(),
					row, i;

				for (i = 0; i < rawData.length; i++)
				{
					row = rawData[i];
					data[row.name] = row.value;
				}

				$.post('ajax/addItemType.php', {data: data}, function (response) {
					if (response.ok === true)
					{
						document.location.reload();
					}
				}, 'json');
			});
		},
		close: function() {
			$(this).find('input:not([type=submit])').val('');
			$(this).children('form').off('submit');
		}
	});
});