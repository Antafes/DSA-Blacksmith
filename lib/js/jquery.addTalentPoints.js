/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
(function ($) {
    $.fn.addTalentPoints = function () {
        return this.each(function () {
            var content,
                talents = $(this).data('talents');
            content = $('<form style="display: none;" method="post" action="ajax/addCrafting.php"></form>');
            content.append('<table><tbody></tbody></table>');

            if ($.isEmptyObject(talents) === false)
            {
                for (var key in talents)
                {
                    content.children('table').children('tbody').append('<tr><td>' + talents[key] + '</td><td><input type="number" name="talentPoints[' + key + ']" /></td></tr>');
                }

                content.children('table').children('tbody').append('<tr><td><input type="hidden" name="craftingId" /><input type="submit" value="' + window.translations.add + '" /></td></tr>');
            }
            else
            {
                content.children('table').children('tbody').append('<tr><td>' + window.translations.noTalentPointsToAdd + '</td></tr>')
            }

            $(this).popup({
                content: content,
                dialog: {
                    title: window.translations.addTalentPoints,
                    open: function () {
                        $(this).find('input[type=hidden]').val(parseInt($(this).data('link').data('id'), 10));
                        $(this).on('submit', function (e) {
                            e.preventDefault();
                            $(this).off('submit');
                            var data = {},
                                rawData = $(this).serializeArray(),
                                row, i, name,
                                nameRegex = /(.*?)\[(.*?)\]/;

                            for (i = 0; i < rawData.length; i++)
                            {
                                row = rawData[i];

                                if (nameRegex.test(row.name))
                                {
                                    name = nameRegex.exec(row.name);

                                    if (typeof data[name[1]] !== 'object')
                                    {
                                        data[name[1]] = {};
                                    }

                                    data[name[1]][name[2]] = row.value;
                                }
                                else
                                {
                                    data[row.name] = row.value;
                                }
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
    };
}(jQuery));