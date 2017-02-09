/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$(function() {
    $.fn.ajaxCheckbox = function (options) {
        return this.each(function () {
            var targetUrl = document.createElement('a');
            targetUrl.href = options.target;

            if ($(this).data('id'))
            {
                if (targetUrl.search === '')
                {
                    targetUrl.search = '?id=' + $(this).data('id');
                }
                else
                {
                    targetUrl.search += '&id=' + $(this).data('id');
                }
            }

            $(this).ajax({
                target: targetUrl.href,
                sendCallback: function (element) {
                    return {
                        public: $(element).prop('checked') ? 1 : 0
                    };
                },
                success: function (element, results) {
                    if (results.checkbox === 'set')
                    {
                        $(element).prop('checked', true);
                    }
                    else
                    {
                        $(element).prop('checked', false);
                    }

                    if (typeof options.success === 'function')
                    {
                        options.success(results);
                    }
                }
            });
        });
    };
});