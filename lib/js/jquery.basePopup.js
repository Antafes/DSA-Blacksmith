/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
(function($) {
    $.widget('dsabs.basePopup', {
        options: {
            ajaxParameter: 'ajax'
        },

        /**
         * Constructor
         *
         * @return {void|boolean}
         */
        _create: function () {
            this._config = {
                targetUrl: this._getTarget(),
                dataUrl: this._checkUrl(this.element.data('dataUrl'))
            };
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

            if (url.href === '' || url.href === '#')
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
        }
    });
}(jQuery));