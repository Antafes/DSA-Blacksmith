$.widget('dsabs.techniqueSelect', {
	options: {
		data: {},
		addLink: null,
		selectName: 'technique',
		target: 'tbody',
		templates: {
			tableRow: $('<tr><td class="material"></td><td></td></tr>'),
			select: $('<select></select>'),
			removeLink: $('<a class="removeRow" href="#">X</a>')
		}
	},
	_create: function() {
		var self = this;

		this._config = {
			rowCount: 0
		};
		this._addOptions();
		this._buildRow();
		$(this.options.addLink).on('click.ts', function() {
			self._addRow();
		});
	},
	_addOptions: function() {
		var self = this;

		$.each(this.options.data, function(index, technique) {
			var option = $('<option></option>');
			option.attr('value', technique.id);
			option.text(technique.name);

			self.options.templates.select.append(option);
		});
	},
	_buildRow: function() {
		var self = this;
		this.options.templates.tableRow.children('.material').append(this.options.templates.select);
		this.options.templates.removeLink.on('click.ts', function() {
			$(this).parent().parent().remove();
		});
		this.options.templates.tableRow.children('td:last').append(this.options.templates.removeLink);
	},
	_addRow: function() {
		var row = this.options.templates.tableRow.clone(true);
		row.children('.material').children('select').attr('name', this.options.selectName + '[' + this._config.rowCount + ']');
		this.element.children(this.options.target).append(row);
		this._config.rowCount++;
		this.element.show();
	}
});