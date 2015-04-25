/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function () {
	var content;
	content = $('<form style="display: none;" method="post" action="ajax/addCrafting.php"></form>');
	content.append('<table><tbody></tbody></table>');
	content.children('table').children('tbody').append('<tr><td>' + window.translations.talentPoints + '</td><td><input type="number" name="talentPoints" /></td></tr>');
	content.children('table').children('tbody').append('<tr><td><input type="hidden" name="craftingId" /><input type="submit" value="' + window.translations.add + '" /></td></tr>');
	$('.addTalentPoints').popup({
		content: content,
		dialog: {
			title: window.translations.addTalentPoints,
			open: function () {
				$(this).find('input[type=hidden]').val(parseInt($(this).data('link').data('id'), 10));
				$(this).on('submit', function (e) {
					e.preventDefault();
					var data = {},
						rawData = $(this).serializeArray(),
						row, i;

					for (i = 0; i < rawData.length; i++)
					{
						row = rawData[i];
						data[row.name] = row.value;
					}

					$.post('ajax/addTalentPoints.php', {data: data}, function (response) {
						if (response.ok === true)
						{
							document.location.reload();
						}
					}, 'json');
				});
			}
		}
	});
});