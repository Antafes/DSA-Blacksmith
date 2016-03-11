/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
    $('#addItemType').popupEdit({
        popup: '#addItemTypePopup',
        submitText: window.translations.addItemType,
        dialog: {
            title: window.translations.addItemType
        }
    });
    $('.edit').popupEdit({
        popup: '#addItemTypePopup',
        submitText: window.translations.editItemType,
        dialog: {
            title: window.translations.editItemType
        }
    });
});