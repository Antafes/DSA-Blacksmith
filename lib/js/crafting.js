/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
    $('.showCraftingLink').popupBlueprint();
    $(document).tooltip({
        content: function () {
            $(this).addClass("tooltip");
            return $(this).attr("title").replace(/(?:\r\n|\r|\n)/g, "<br />");
        }
    });
    $(".addTalentPoints").addTalentPoints();
    $('#addCrafting').popupEdit({
        popup: '#addCraftingPopup',
        submitText: window.translations.addCrafting,
        dialog: {
            title: window.translations.addCrafting,
            width: 600
        }
    });
    $('.edit').popupEdit({
        popup: '#addCraftingPopup',
        submitText: window.translations.editCrafting,
        dialog: {
            title: window.translations.editCrafting,
            width: 600,
            open: function () {
                $('#addCraftingPopup').find('.updateWarning').show();
            },
            close: function () {
                $('#addCraftingPopup').find('.updateWarning').hide();
            }
        }
    });
    $('#showPublicBlueprints').ajaxCheckbox({
        target: 'index.php?page=Options&action=showPublicBlueprints',
        success: function (results) {
            $.ajax(
                'index.php?page=Craftings&action=getBlueprints&ajax=1',
                {
                    success: function (results) {
                        var select = $('#addCraftingPopup').find('select[name=blueprintId]');
                        select.children().remove();

                        for (var key in results.data)
                        {
                            if (key === 'public')
                            {
                                break;
                            }

                            var row = results.data[key],
                                option = $('<option></option>');

                            option.attr('value', row.id);
                            option.text(row.name + ' (' + row.item + ')');

                            select.append(option);
                        }

                        if (results.data.public)
                        {
                            var optgroup = $('<optgroup></optgroup>');
                            optgroup.attr({
                                class: 'publicBlueprints',
                                label: window.translations.publicBlueprints
                            });

                            for (var key in results.data.public)
                            {
                                var row = results.data.public[key],
                                    option = $('<option></option>');

                                option.attr('value', row.id);
                                option.text(row.name + ' (' + row.item + ')');

                                optgroup.append(option);
                            }

                            select.append(optgroup);
                        }
                    }
                }
            );
        }
    });
});