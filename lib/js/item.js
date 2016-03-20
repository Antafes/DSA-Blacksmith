/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
	$('#addItem').popupEdit({
        popup: '#addItemPopup',
        submitText: window.translations.addItem,
        dialog: {
            title: window.translations.addItem
        }
    });
    $('.edit').popupEdit({
        popup: '#addItemPopup',
        submitText: window.translations.editItem,
        dialog: {
            title: window.translations.editItem,
            width: 600,
            open: function() {
                $('#itemTypeSelect').on('change', function () {
                    var tableRows = $('.addItem').children('tbody').children(),
                        rowClass = 'odd';
                    tableRows.not('.name, .itemType').removeClass('odd even').hide();
                    $.each(window.columsPerItemType[$(this).val()], function (key, value) {
                        if (key === 'name')
                        {
                            return true;
                        }

                        tableRows.filter('.' + key).show();
                    });
                    tableRows.each(function () {
                        if (!$(this).is(':visible'))
                        {
                            return true;
                        }

                        $(this).addClass(rowClass);

                        if (rowClass === 'odd')
                        {
                            rowClass = 'even';
                        }
                        else
                        {
                            rowClass = 'odd';
                        }
                    });
                });
                $('#itemTypeSelect').trigger('change');
            },
            close: function () {
                $('#itemTypeSelect').off('change');
            }
        }
    });
});