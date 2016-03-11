/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
(function($) {
    $.widget('dsabs.popupEdit', {
        options: {
            popup: null,
            submitText: 'Submit',

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

            this._config = {
                targetUrl: this._getTarget(),
                dataUrl: this._checkUrl(this.element.data('dataUrl'))
            };

            this._addListener();
        },

        /**
         * Get the ajax target.
         *
         * @return {String}
         */
        _getTarget: function () {
            var url = document.createElement('a');

            if (this.element.attr('href'))
            {
                url.href = this.element.attr('href');
            }

            if (this.element.attr('src'))
            {
                url.href = this.element.attr('src');
            }

            if (url.href === '')
            {
                console.error('No target found!');
            }

            return this._checkUrl(url);
        },

        /**
         * Check whether the url already contains the ajax parameter.
         *
         * @param {mixed} url
         *
         * @return {String}
         */
        _checkUrl: function (url) {
            var urlCheck;

            if (typeof url === 'undefined')
            {
                return;
            }

            if (typeof url === 'string')
            {
                urlCheck = document.createElement('a');
                urlCheck.href = url;
            }
            else
            {
                urlCheck = url;
            }

            if (urlCheck.search.search(this.options.ajaxParameter) === -1)
            {
                if (urlCheck.search === '')
                {
                    urlCheck.search = '?' + this.options.ajaxParameter + '=1';
                }
                else
                {
                    urlCheck.search += '&' + this.options.ajaxParameter + '=1';
                }
            }

            return urlCheck.href;
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
                        open: $.proxy(this._openCallback, this),
                        close: this._closeCallback
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
					row, i;

				for (i = 0; i < rawData.length; i++)
				{
					row = rawData[i];
					data[row.name] = row.value;
				}

				$.post(this._config.targetUrl, {data: data}, function (response) {
                    document.location.reload();
				}, 'json');
			}, this));
		},

        /**
         * Close callback for the jQuery UI dialog.
         *
         * @return {void}
         */
		_closeCallback: function() {
			$(this).find('input:not([type=submit])').val('');
			$(this).children('form').off('submit');
            $(this).dialog('destroy');
		},

        /**
         * Success callback for the ajax request.
         * Fills the form with the retrieved data.
         *
         * @param {object} element
         * @param {object} results
         *
         * @return {void}
         */
        _successCallback: function (element, results) {
            $(element).children('form').find('input, select').each(function (index, element) {
                if (results[$(element).attr('name')])
                {
                    $(element).val(results[$(element).attr('name')]);
                }
            });
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
        },

        /**
         * Destroy the widget and unregister the onclick and ontouch event listener.
         *
         * @return {void}
         */
        _destroy: function () {
            this.element.off('click.pe touch.pe');
        }
    });
}(jQuery));