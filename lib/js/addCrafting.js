/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
	$('#addCrafting').on('click', function(e) {
		e.preventDefault();
		$('#addCraftingPopup').dialog('open');
	});
	$('#addCraftingPopup').dialog({
		title: $('#addCraftingPopup').data('title'),
		modal: true,
		autoOpen: false,
		width: 600,
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

				$.post('ajax/addCrafting.php', {data: data}, function (response) {
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