/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
(function($) {
    $.widget('dsabs.popupEdit', $.dsabs.basePopup, {
        options: {
            popup: null,
            submitText: 'Submit',

            ajax: {
                success: function () {},
                error: function () {}
            },

            dialog: {
                modal: true,
                autoOpen: true,
                width: 450
            },

            templates: {
                errorPopup: $('<div id="errorPopup" class="errorPopup"></div>')
            }
        },

        /**
         * Constructor
         *
         * @return {void|boolean}
         */
        _create: function () {
            if (this.options.popup === null)
            {
                console.error('Missing option: popup');
                return false;
            }

            this._super();
            this._config.dialog = {
                open: this.options.dialog.open,
                close: this.options.dialog.close
            };

            this._addListener();
        },

        /**
         * Register the onclick and ontouch event listener.
         *
         * @return {void}
         */
        _addListener: function () {
            this.element.on('click.pe touch.pe', $.proxy(function (event) {
                event.preventDefault();
                this._createPopup();
            }, this));
        },

        /**
         * Create the jQuery UI dialog.
         *
         * @return {void}
         */
        _createPopup: function () {
            if (typeof $(this.options.popup).dialog('instance') !== 'undefined')
            {
                return;
            }

            $(this.options.popup).dialog(
                $.extend(
                    true,
                    this.options.dialog,
                    {
                        create: $.proxy(this._openCallback, this),
                        close: $.proxy(this._closeCallback, this)
                    }
                )
            );
        },

        /**
         * Open callback for the jQuery UI dialog.
         *
         * @return {void}
         */
        _openCallback: function(event) {
            var element = $(event.target);

            if (this._config.dataUrl)
            {
                $.ajax(
                    this._config.dataUrl,
                    {
                        success: $.proxy(function (results) {
                            this._successCallback(element, results.data);
                        }, this),
                        error: $.proxy(function (results) {
                            if (typeof results.error !== 'undefined')
                            {
                                this._error(results.error);
                            }
                            else
                            {
                                this._error(this.window[0].translations.unkownError);
                            }
                        }, this)
                    }
                );
            }

            element.find('.buttonArea').children(':submit').val(this.options.submitText);
            element.children('form').on('submit', $.proxy(function(event) {
                event.preventDefault();
                var data = {},
                    form = $(event.target),
                    rawData = form.serializeArray(),
                    row, i, regexp, matches;

                for (i = 0; i < rawData.length; i++)
                {
                    row = rawData[i];

                    if (row.name.indexOf('[') !== -1) {
                        regexp = /(.*?)\[(.*?)\]/;
                        matches = row.name.match(regexp);

                        if (typeof data[matches[1]] !== 'object') {
                            data[matches[1]] = [];
                        }

                        data[matches[1]][matches[2]] = row.value;
                    } else {
                        data[row.name] = row.value;
                    }
                }

                $.post(this._config.targetUrl, {data: data}, function (response) {
                    document.location.reload();
                }, 'json');
            }, this));

            if (typeof this._config.dialog.open === 'function')
            {
                this._config.dialog.open(event);
            }

            this.adjustRowLayout();
        },

        /**
         * Close callback for the jQuery UI dialog.
         *
         * @return {void}
         */
        _closeCallback: function(event) {
            var element = $(event.target);

            element.find('input:not([type=submit])').val('');
            element.find('input[type=checkbox], input[type=radio]').each(function () {
                $(this).prop('checked', $(this).attr('checked') === 'checked');
            });
            element.children('form').off('submit');
            element.dialog('destroy');

            if (typeof this._config.dialog.close === 'function')
            {
                this._config.dialog.close(event);
            }
        },

        /**
         * Success callback for the ajax request.
         * Fills the form with the retrieved data.
         *
         * @param {object} parent
         * @param {object} results
         *
         * @return {void}
         */
        _successCallback: function (parent, results) {
            $(parent).children('form').find(':input').each(function (index, element) {
                if (results[$(element).attr('name')])
                {
                    if ($(element).is('input[type=checkbox], input[type=radio]'))
                    {
                        $(element).val(1)
                            .prop('checked', results[$(element).attr('name')]);
                    }
                    else
                    {
                        $(element).val(results[$(element).attr('name')]);
                    }
                }
            });
            this.options.ajax.success(results);
        },

        /**
         * Create an error popup.
         *
         * @param {String} errorMessage
         *
         * @return {void}
         */
        _error: function (errorMessage) {
            var popup;

            if ($('#' + this.options.templates.errorPopup.attr('id')).length > 0)
            {
                $('#' + this.options.templates.errorPopup.attr('id')).remove();
            }

            popup = this.options.templates.errorPopup.clone();
            popup.text(errorMessage);
            $('body').append(popup);
            popup.dialog({
                title: this.window[0].translations.error,
                modal: true
            });
            this.options.ajax.success(errorMessage);
        },

        /**
         * Destroy the widget and unregister the onclick and ontouch event listener.
         *
         * @return {void}
         */
        _destroy: function () {
            this.element.off('click.pe touch.pe');
        },

        /**
         * Adjust the row layout with alternating row styles.
         *
         * @returns {void}
         */
        adjustRowLayout: function () {
            $(this.options.popup).find('table:first').children('tbody').children('tr:visible').addClass(function (index, currentClasses) {
                if (currentClasses.indexOf('buttons') !== -1) {
                    return;
                }

                if (index % 2 === 0) {
                    return 'even';
                } else {
                    return 'odd';
                }
            });
        }
    });
}(jQuery));