/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function () {
    $('.remove').ajax(
        {
            success: function (element) {
                var parent = element.parent().parent().parent(),
                    elements;
                element.parent().parent().remove();
                elements = parent.children();

                elements.each(function (index, element) {
                    if (index % 2 === 0)
                    {
                        $(element).attr('class', 'odd');
                    }
                    else
                    {
                        $(element).attr('class', 'even');
                    }
                });
            }
        }
    );
});
