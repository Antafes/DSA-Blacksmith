/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
(function ($) {
    $.widget('dsabs.popup', $.dsabs.basePopup, {
        options: {
            content: '',
            dialog: {
                close: function() {
                    $(this).dialog('destroy');
                }
            }
        },
        _create: function () {
            this._super();
            this._addContent();
            this._addListener();
        },
        _addContent: function () {
            $('body').append(this.options.content);
        },
        _addListener: function () {
            this.element.on('click.pop touch.pop', $.proxy(function (e) {
                e.preventDefault();
                this._createContent($.proxy(function () {
                    var options = $.extend(true, this.options.dialog, {
                        modal: true,
                        autoOpen: true
                    });
                    this.options.content.data('link', this.element);
                    this.options.content.dialog(options);
                }, this));
            }, this));
        },
        _createContent: function (callback) {
            if (typeof callback === 'function')
            {
                callback();
            }
        },
        _destroy: function () {
            this.element.off('click.pop');
        }
    });
}(jQuery));