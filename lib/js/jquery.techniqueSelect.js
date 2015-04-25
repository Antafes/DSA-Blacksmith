/**
 * Part of the dsa blacksmith.
 *
 * @package JavaScript
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
$.widget('dsabs.techniqueSelect', {
	options: {
		data: {},
		addLink: null,
		selectName: 'technique',
		target: 'tbody',
		templates: {
			tableRow: $('<tr><td class="technique"></td><td></td></tr>'),
			select: $('<select></select>'),
			removeLink: $('<a class="removeRow" href="#">X</a>')
		}
	},
	_create: function() {
		this._config = {
			rowCount: 0,
			rows: []
		};
		this._addOptions();
		this.options.templates.select.on('change.ts', $.proxy(function (e) {
			var element = $(e.target),
				value = element.val();

			if (element.children('[value=' + value + ']').data('noOtherAllowed') === true)
			{
				if (this._config.rows.length > 1)
				{
					this._showNoOtherAllowedDialog(element.parentsUntil('tr').parent());
				}

				$(this.options.addLink).hide();
			}
			else
			{
				$(this.options.addLink).show();
			}
		}, this));
		this._buildRow();
		$(this.options.addLink).on('click.ts', $.proxy(function() {
			this._addRow();
		}, this));
	},
	_addOptions: function() {
		$.each(this.options.data, $.proxy(function(index, technique) {
			var option = $('<option></option>');
			option.attr('value', technique.id);
			option.text(technique.name);
			option.data('noOtherAllowed', technique.noOtherAllowed);

			this.options.templates.select.append(option);
		}, this));
	},
	_buildRow: function() {
		this.options.templates.tableRow.children('.technique').append(this.options.templates.select);
		this.options.templates.removeLink.on('click.ts touch.ts', $.proxy(function(e) {
			var element = $(e.target),
				row = element.parent().parent(),
				select = row.find('select');

			this._config.rows.splice(this._config.rows.indexOf(row), 1);

			if (select.children('[value=' + select.val() + ']').data('noOtherAllowed') === true)
			{
				$(this.options.addLink).show();
			}

			if (this._config.rows.length === 0)
			{
				this.element.hide();
			}

			row.remove();
		}, this));
		this.options.templates.tableRow.children('td:last').append(this.options.templates.removeLink);
	},
	_addRow: function() {
		var row = this.options.templates.tableRow.clone(true);
		row.children('.technique').children('select').attr('name', this.options.selectName + '[' + this._config.rowCount + ']');
		this.element.children(this.options.target).append(row);
		this._config.rows.push(row);
		this._config.rowCount++;
		this.element.show();
	},
	_showNoOtherAllowedDialog: function (currentRow) {
		var dialog = $('<div>');
		dialog.html(window.translations.noOtherAllowedInfo);
		dialog.dialog({
			autoOpen: true,
			modal: true,
			buttons: [
				{
					text: window.translations.ok,
					click: $.proxy(function (dialog, e) {
						for (var i = 0; i < this._config.rows.length; i++)
						{
							var row = this._config.rows[i];

							if (row.is(currentRow))
							{
								continue;
							}

							row.remove();
						}

						this._config.rows = [currentRow];
						dialog.dialog('close');
					}, this, dialog)
				},
				{
					text: window.translations.cancel,
					click: function () {
						currentRow.find('select').children(':first-child').prop('selected', true);
						$(this).dialog('close');
						$(this.options.addLink).show();
					}
				}
			],
			close: function () {
				$(this).dialog('destroy');
			}
		});
	}
});