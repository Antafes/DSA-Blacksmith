$(function() {
	$('.blueprintShowLink').popupBlueprint();
//	$('.blueprintShowLink').on('click', function() {
//		var $this = $(this),
//			popup = $('#showBlueprintPopup');
//
//		popup.dialog({
//			title: popup.data('title'),
//			modal: true,
//			autoOpen: true,
//			width: 900,
//			open: function() {
//				$.post('ajax/showBlueprint.php', {id: $this.data('id')}, function (response) {
//					var columns = popup.children('table').children('tbody').children('tr').children('td');
//					columns.filter('.name').text(response.name);
//					columns.filter('.hitPoints').text(response.hitPoints);
//					columns.filter('.weight').text(response.weight);
//					columns.filter('.breakFactor').text(response.breakFactor);
//					columns.filter('.initiative').text(response.initiative);
//					columns.filter('.price').text(response.price);
//					columns.filter('.forceModificator').text(response.forceModificator);
//					columns.filter('.notes').text(response.notes);
//					columns.filter('.time').text(response.time);
//				}, 'json');
//			},
//			close: function() {
//				$(this).dialog('destroy');
//			}
//		});
//	});
});