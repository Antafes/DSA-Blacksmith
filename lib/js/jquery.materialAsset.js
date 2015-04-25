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
		target: 'tbody',
		fieldNames: {
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
		var self = this;

		this._config = {
			rowCount: 0
		};
		this._buildCurrencySelect();
		this._buildRow();
		this._addRow();
		$(this.options.addLink).on('click.ms', function() {
			self._addRow();
		});
		this.element.show();
	},
	_buildCurrencySelect: function() {
		var self = this;

		$.each(this.options.currencies, function(key, currency) {
			var option = $('<option></option>');
			option.attr('value', key);
			option.text(currency.name);

			self.options.templates.priceWeightCurrencyField.append(option);
		});
	},
	_buildRow: function() {
		var self = this;
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
		this.element.children(this.options.target).append(row);
		this._config.rowCount++;
		this.element.show();
	}
});