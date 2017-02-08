/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
    $('.blueprintShowLink').popupBlueprint();
    $('#addBlueprint').popupEdit({
        popup: '#addBlueprintPopup',
        submitText: window.translations.addBlueprint,
        dialog: {
            title: window.translations.addBlueprint,
            width: 600,
            open: function() {
                $('#itemSelect').on('change', function () {
                    var selectedOption = $(this).find('option:selected'),
                        itemType = selectedOption.data('itemtype'),
                        itemTypeOptions = $('#itemTypeSelect').children(),
                        firstItemTypeSelected = false,
                        tableRows = $('#addBlueprintPopup').find('.addBlueprint').children('tbody').children(),
                        rowClass = 'odd';

                    if (selectedOption.data('damagetype') === 'stamina')
                    {
                        $('#damageTypeSelect').children('option[value=damage]').prop('disabled', true);
                        $('#damageTypeSelect').val('stamina');
                    }
                    else
                    {
                        $('#damageTypeSelect').children('option[value=damage]').prop('disabled', false);
                    }

                    itemTypeOptions.each(function () {
                        if ($(this).data('type') !== itemType)
                        {
                            $(this).hide();
                        }
                        else
                        {
                            $(this).show();

                            if (!firstItemTypeSelected)
                            {
                                $('#itemTypeSelect').val($(this).attr('value'));
                                firstItemTypeSelected = true;
                            }
                        }
                    });
                    tableRows.not('.name, .items, .itemType').removeClass('odd even').hide();
                    $.each(window.columsPerItemType[selectedOption.data('itemtype')], function (key, value) {
                        tableRows.filter('.' + value).show();
                    });
                    $('#addBlueprint').popupEdit('adjustRowLayout');
                });
                $('#itemSelect').trigger('change');

                $('#materialSelect').materialSelect({
                    appendWeaponModificatorSelectTo: '#addBlueprintPopup',
                    materials: window.materials,
                    talents: window.talents,
                    addLink: $('#addMaterialRow')
                });

                $('#techniqueSelect').techniqueSelect({
                    data: window.techniques,
                    addLink: $('#addTechniqueRow')
                });
            },
            close: function () {
                $(this).find('input:not([type=submit])').val('');
                $('#addMaterialRow').off('click');
                $(this).children('form').off('submit');
                $('#materialSelect').materialSelect('destroy');
                $('#techniqueSelect').techniqueSelect('destroy');
            }
        },
        ajax: {
            success: function () {
                $('#itemTypeSelect').trigger('change');
            }
        }
    });
    $('.edit').popupEdit({
        popup: '#addBlueprintPopup',
        submitText: window.translations.editBlueprint,
        dialog: {
            title: window.translations.editBlueprint,
            width: 600,
            open: function() {
                $('#itemSelect').on('change', function () {
                    var selectedOption = $(this).find('option:selected'),
                        itemType = selectedOption.data('itemtype'),
                        itemTypeOptions = $('#itemTypeSelect').children(),
                        firstItemTypeSelected = false,
                        tableRows = $('#addBlueprintPopup').find('.addBlueprint').children('tbody').children(),
                        rowClass = 'odd';

                    if (selectedOption.data('damagetype') === 'stamina')
                    {
                        $('#damageTypeSelect').children('option[value=damage]').prop('disabled', true);
                        $('#damageTypeSelect').val('stamina');
                    }
                    else
                    {
                        $('#damageTypeSelect').children('option[value=damage]').prop('disabled', false);
                    }

                    itemTypeOptions.each(function () {
                        if ($(this).data('type') !== itemType)
                        {
                            $(this).hide();
                        }
                        else
                        {
                            $(this).show();

                            if (!firstItemTypeSelected)
                            {
                                $('#itemTypeSelect').val($(this).attr('value'));
                                firstItemTypeSelected = true;
                            }
                        }
                    });
                    tableRows.not('.name, .items, .itemType').removeClass('odd even').hide();
                    $.each(window.columsPerItemType[selectedOption.data('itemtype')], function (key, value) {
                        tableRows.filter('.' + value).show();
                    });
                    $('.edit').popupEdit('adjustRowLayout');
                });
                $('#itemSelect').trigger('change');

                $('#materialSelect').materialSelect({
                    appendWeaponModificatorSelectTo: '#addBlueprintPopup',
                    materials: window.materials,
                    talents: window.talents,
                    addLink: $('#addMaterialRow')
                });

                $('#techniqueSelect').techniqueSelect({
                    data: window.techniques,
                    addLink: $('#addTechniqueRow')
                });
            },
            close: function () {
                $(this).find('input:not([type=submit])').val('');
                $('#addMaterialRow').off('click');
                $(this).children('form').off('submit');
                $('#materialSelect').materialSelect('destroy');
                $('#techniqueSelect').techniqueSelect('destroy');
            }
        },
        ajax: {
            success: function (results) {
                $('#itemSelect').trigger('change');
                $('#itemTypeSelect').trigger('change');
                $('#materialSelect').materialSelect('clear');
                $('#techniqueSelect').techniqueSelect('clear');

                $.each(results.materials, function (key, value) {
                    $('#materialSelect').materialSelect('addRow', value);
                });
                $.each(results.techniques, function (key, value) {
                    $('#techniqueSelect').techniqueSelect('addRow', value);
                });
                $('#addBlueprintPopup').find('tr.upgradeWeaponModificator')
                    .find('input.upgradeWeaponModificatorAttack').val(results.upgradeWeaponModificator.attack);
                $('#addBlueprintPopup').find('tr.upgradeWeaponModificator')
                    .find('input.upgradeWeaponModificatorParade').val(results.upgradeWeaponModificator.parade);
            }
        }
    });
});