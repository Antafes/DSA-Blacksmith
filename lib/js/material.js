/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
	$('#addMaterial').popupEdit({
        popup: '#addMaterialPopup',
        submitText: window.translations.addMaterial,
        dialog: {
            title: window.translations.addMaterial,
            width: 1050,
            open: function () {
                $('#materialAssets').materialAsset({
                    addLink: $('#addMaterialAssetRow'),
                    currencies: window.currencies
                });
            },
            close: function (event) {
                var element = $(event.target);
                element.find('select').val($(this).find('select').children(':first').attr('value'));
                $('#materialAssets').materialAsset('destroy');
            }
        }
    });
    $('.edit').popupEdit({
        popup: '#addMaterialPopup',
        submitText: window.translations.editMaterial,
        ajax: {
            success: function (results) {
                $('#materialAssets').materialAsset({
                    addLink: $('#addMaterialAssetRow'),
                    currencies: window.currencies,
                    values: results.materialAssets
                });
            }
        },
        dialog: {
            title: window.translations.editMaterial,
            width: 1050,
            close: function (event) {
                var element = $(event.target);
                element.find('select').val($(this).find('select').children(':first').attr('value'));
                $('#materialAssets').materialAsset('destroy');
            }
        }
    });
	$('#addMaterialType').on('click', function(e) {
		e.preventDefault();
		$('#addMaterialTypePopup').dialog('open');
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