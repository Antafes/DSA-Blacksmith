/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
    $('#addTechnique').popupEdit({
        popup: '#addTechniquePopup',
        submitText: window.translations.addTechnique,
        dialog: {
            title: window.translations.addTechnique
        }
    });
    $('.edit').popupEdit({
        popup: '#addTechniquePopup',
        submitText: window.translations.editTechnique,
        dialog: {
            title: window.translations.editTechnique
        }
    });
});