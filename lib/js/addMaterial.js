/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
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
		width: 1050,
		open: function() {
			$(this).children('form').on('submit', function(e) {
				e.preventDefault();
				var data = {},
					rawData = $(this).serializeArray(),
					row, i, name;

				for (i = 0; i < rawData.length; i++)
				{
					row = rawData[i];

					if (row.name.indexOf('[') === -1)
					{
						data[row.name] = row.value;
					}
					else
					{
						name = row.name.split('[');

						if (typeof data[name[0]] === 'undefined')
						{
							data[name[0]] = {};
						}

						data[name[0]][name[1].substr(0, name[1].length - 1)] = row.value;
					}
				}

				$.post('ajax/addMaterial.php', {data: data}, function (response) {
					if (response.ok === true)
					{
						document.location.reload();
					}
				}, 'json');
			});

			$('#materialAssets').materialAsset({
				addLink: $('#addMaterialAssetRow'),
				currencies: window.currencies
			});
		},
		close: function() {
			$(this).find('input:not([type=submit]), textarea').val('');
			$(this).find('select').val($(this).find('select').children(':first').attr('value'));
			$(this).children('form').off('submit');
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