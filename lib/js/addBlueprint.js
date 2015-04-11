$(function() {
	$('#addBlueprint').on('click', function(e) {
		e.preventDefault();
		$('#addBlueprintPopup').dialog('open');
	});
	$('#addBlueprintPopup').dialog({
		title: $('#addBlueprintPopup').data('title'),
		modal: true,
		autoOpen: false,
		width: 600,
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

				$.post('ajax/addBlueprint.php', {data: data}, function (response) {
					if (response.ok === true)
					{
						document.location.reload();
					}
				}, 'json');
			});

			$('#itemSelect').on('change', function () {
				var selectedOption = $(this).children('option:selected');

				if (selectedOption.data('damagetype') === 'stamina')
				{
					$('#damageTypeSelect').children('option[value=damage]').prop('disabled', true);
					$('#damageTypeSelect').val('stamina');
				}
				else
				{
					$('#damageTypeSelect').children('option[value=damage]').prop('disabled', false);
				}
			});

			$('#materialSelect').materialSelect({
				appendWeaponModificatorSelectTo: '#addBlueprintPopup',
				data: window.materials,
				addLink: $('#addMaterialRow')
			});

			$('#techniqueSelect').techniqueSelect({
				data: window.techniques,
				addLink: $('#addTechniqueRow')
			});
		},
		close: function() {
			$(this).find('input:not([type=submit])').val('');
			$('#addMaterialRow').off('click');
			$(this).children('form').off('submit');
		}
	});
});