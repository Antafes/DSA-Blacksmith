/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$.widget('dsabs.materialAsset', {
    options: {
        addLink: null,
        currencies: {},
        values: [{
            percentage: '',
            timeFactor: '',
            priceFactor: '',
            priceWeight: '',
            proof: '',
            breakFactor: '',
            hitPoints: '',
            armor: '',
            weaponModificator: ''
        }],
        target: 'tbody',
        fieldNames: {
            idField: 'materialAssetId',
            percentage: 'percentage',
            timeFactor: 'timeFactor',
            priceFactor: 'priceFactor',
            priceWeight: 'priceWeight',
            priceWeightCurrency: 'currency',
            proof: 'proof',
            breakFactor: 'breakFactor',
            hitPoints: 'hitPoints',
            armor: 'armor',
            weaponModificator: 'weaponModificator'
        },
        templates: {
            tableRow: $('<tr><td class="percentage"></td><td class="timeFactor"></td><td class="priceFactor"></td><td class="priceWeight"></td><td class="proof"></td><td class="breakFactor"></td><td class="hitPoints"></td><td class="armor"></td><td class="weaponModificator"></td><td></td></tr>'),
            idField: $('<input type="hidden" />'),
            percentageField: $('<input type="number" min="1" max="100" />'),
            timeFactorField: $('<input type="number" step="0.01" min="1" />'),
            priceFactorField: $('<input type="number" step="0.01" />'),
            priceWeightField: $('<input class="priceWeight" type="number" />'),
            priceWeightCurrencyField: $('<select class="currency"></select>'),
            proofField: $('<input type="number" />'),
            breakFactorField: $('<input type="number" />'),
            hitPointsField: $('<input type="number" />'),
            armorField: $('<input type="number" />'),
            weaponModificatorField: $('<textarea></textarea>'),
            removeLink: $('<a class="removeRow" href="#">X</a>')
        }
    },
    _create: function() {
        this._config = {
            rowCount: 0,
            rows: []
        };
        this._buildCurrencySelect();
        this._buildRow();
        this._setValues();
        $(this.options.addLink).on('click.ms', $.proxy(function() {
            this._addRow();
        }, this));
        this.element.show();
    },
    _buildCurrencySelect: function() {
        $.each(this.options.currencies, $.proxy(function(key, currency) {
            var option = $('<option></option>');
            option.attr('value', key);
            option.text(currency.name);

            this.options.templates.priceWeightCurrencyField.append(option);
        }, this));
    },
    _buildRow: function() {
        this.options.templates.tableRow.children('.percentage').append(this.options.templates.percentageField);
        this.options.templates.tableRow.children('.timeFactor').append(this.options.templates.timeFactorField);
        this.options.templates.tableRow.children('.priceFactor').append(this.options.templates.priceFactorField);
        this.options.templates.tableRow.children('.priceWeight').append(this.options.templates.priceWeightField);
        this.options.templates.tableRow.children('.priceWeight').append(this.options.templates.priceWeightCurrencyField);
        this.options.templates.tableRow.children('.proof').append(this.options.templates.proofField);
        this.options.templates.tableRow.children('.breakFactor').append(this.options.templates.breakFactorField);
        this.options.templates.tableRow.children('.hitPoints').append(this.options.templates.hitPointsField);
        this.options.templates.tableRow.children('.armor').append(this.options.templates.armorField);
        this.options.templates.tableRow.children('.weaponModificator').append(this.options.templates.weaponModificatorField);
        this.options.templates.removeLink.on('click.ms', function() {
            $(this).parent().parent().remove();
        });
        this.options.templates.tableRow.children('td:last').append(this.options.templates.removeLink);
        this.options.templates.tableRow.children('td:last').append(this.options.templates.idField);
    },
    _addRow: function() {
        var row = this.options.templates.tableRow.clone(true);
        row.children('.percentage').children(':input').attr('name', this.options.fieldNames.percentage + '[' + this._config.rowCount + ']');
        row.children('.timeFactor').children(':input').attr('name', this.options.fieldNames.timeFactor + '[' + this._config.rowCount + ']');
        row.children('.priceFactor').children(':input').attr('name', this.options.fieldNames.priceFactor + '[' + this._config.rowCount + ']');
        row.children('.priceWeight').children('input').attr('name', this.options.fieldNames.priceWeight + '[' + this._config.rowCount + ']');
        row.children('.priceWeight').children('select').attr('name', this.options.fieldNames.priceWeightCurrency + '[' + this._config.rowCount + ']');
        row.children('.proof').children(':input').attr('name', this.options.fieldNames.proof + '[' + this._config.rowCount + ']');
        row.children('.breakFactor').children(':input').attr('name', this.options.fieldNames.breakFactor + '[' + this._config.rowCount + ']');
        row.children('.hitPoints').children(':input').attr('name', this.options.fieldNames.hitPoints + '[' + this._config.rowCount + ']');
        row.children('.armor').children(':input').attr('name', this.options.fieldNames.armor + '[' + this._config.rowCount + ']');
        row.children('.weaponModificator').children(':input').attr('name', this.options.fieldNames.weaponModificator + '[' + this._config.rowCount + ']');
        row.children('td:last').children(':input').attr('name', this.options.fieldNames.idField + '[' + this._config.rowCount + ']');
        this.element.children(this.options.target).append(row);
        this._config.rows[this._config.rowCount] = row;
        this._config.rowCount++;
        this.element.show();

        return row;
    },
    _setValues: function () {
        for (var i = 0; i < this.options.values.length; i++)
        {
            var row = this._addRow(),
                idElement = row.children('td:last').children(':input');

            idElement.val(this.options.values[i].materialAssetId);

            for (var key in this.options.values[i])
            {
                if (key === 'materialAssetId') {
                    continue;
                }

                var element = row.children('.' + key).children(':input'),
                    element2,
                    value = this.options.values[i][key],
                    splittedValue;

                if (key === 'priceWeight')
                {
                    element = row.children('.' + key).children('input');
                    element2 = row.children('.' + key).children('select');
                }

                if (element.length === 0)
                {
                    continue;
                }

                if (element2 && element2.length > 0)
                {
                    splittedValue = value.split(' ');
                    element2.val('S');
                    value = splittedValue[0];
                    element2 = null;
                }

                if (typeof value === 'object' && value !== null)
                {
                    element.val(this._formatWeaponModificator(value));
                }
                else
                {
                    element.val(value);
                }
            }
        }
    },
    _formatWeaponModificator: function (values) {
        var result = '',
            or = window.translations.or;

        for (var i = 0; i < values.length; i++)
        {
            result += values[i].attack + '/' + values[i].parade + ' ' + or + ' ';
        }

        return result.substr(0, result.length - (2 + or.length));
    },
    _destroy: function () {
        for (var i = 0; i < this._config.rows.length; i++)
        {
            this._config.rows[i].remove();
        }
        this._config.rows = [];

        $(this.options.addLink).off('click.ms');
    }
});