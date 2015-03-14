$.widget('dsabs.materialSelect', {
	options: {
		appendForceModificatorSelectTo: '',
		data: {},
		addLink: null,
		selectName: 'material',
		percentageName: 'percentage',
		forceModificatorName: 'materialForceModificator',
		target: 'tbody',
		templates: {
			tableRow: $('<tr><td class="material"></td><td class="percentage"></td><td></td></tr>'),
			select: $('<select></select>'),
			percentageInput: $('<input class="percentage" type="number" min="1" max="100" /><span>&nbsp;%<span>'),
			removeLink: $('<a class="removeRow" href="#">X</a>'),
			materialForceModificatorInput: $('<input class="materialForceModificator" type="hidden" />'),
			forceModificatorSelectPopup: $('<div style="display: none;"><form method="post" action="index.php"><select></select><br /><input type="submit" value="Ok" /></form></div>')
		}
	},
	_create: function() {
		var self = this;

		this._config = {
			rowCount: 0
		};
		this._addOptions();
		this._buildRow();
		this._addRow();
		$(this.options.addLink).on('click.ms', function() {
			self._addRow();
		});
		this.element.show();
	},
	_addOptions: function() {
		var self = this;

		$.each(this.options.data, function(index, material) {
			var option = $('<option></option>'),
				forceModificators = {};
			option.attr('value', material.id);
			option.text(material.name);

			$.each(material.materialAssets, function(index, asset) {
				forceModificators[asset.percentage] = asset.forceModificator;
			});
			option.data('forceModificator', forceModificators);

			self.options.templates.select.append(option);
		});
	},
	_buildRow: function() {
		var self = this;
		this.options.templates.tableRow.children('.material').append(this.options.templates.select);
		this.options.templates.tableRow.children('.percentage').append(this.options.templates.materialForceModificatorInput);
		this.options.templates.percentageInput.on('change', function() {
			var $this = $(this),
				forceModificator = $this.parent().parent().children('.material').children('select').children('option:selected').data('forceModificator');
			for (var percentage in forceModificator)
			{
				var modificators = forceModificator[percentage];

				if ($this.val() >= percentage)
				{
					if (modificators.length > 1)
					{
						var popup = self.options.templates.forceModificatorSelectPopup.clone();

						$.each(modificators, function(index, modificator) {
							var option = $('<option></option>');
							option.attr('value', modificator.attack + '/' + modificator.parade);
							option.text(modificator.attack + '/' + modificator.parade);

							popup.children('form').children('select').append(option);
							popup.dialog({
								modal: true,
								autoOpen: true,
								closeOnEscape: false,
								dialogClass: 'no-close',
								appendTo: '',
								open: function() {
									var dialog = $(this);
									dialog.children('form').submit(function(e) {
										e.preventDefault();
										$this.parent().children('input[type=hidden]').val($(this).val());
										dialog.dialog('close');
									});
								},
								close: function() {
									$(this).dialog('destroy');
								}
							});
						});
					}
					else if (modificators.lenght > 0)
					{
						$this.parent().children('input[type=hidden]').val(modificators[0].attack + '/' + modificators[0].parade);
					}
				}
			}
		});
		this.options.templates.tableRow.children('.percentage').append(this.options.templates.percentageInput);
		this.options.templates.removeLink.on('click.ms', function() {
			$(this).parent().parent().remove();
		});
		this.options.templates.tableRow.children('td:last').append(this.options.templates.removeLink);
	},
	_addRow: function() {
		var row = this.options.templates.tableRow.clone(true);
		row.children('.material').children('select').attr('name', this.options.selectName + '[' + this._config.rowCount + ']');
		row.children('.percentage').children('.percentage').attr('name', this.options.percentageName + '[' + this._config.rowCount + ']');
		row.children('.percentage').children('.materialForceModificator').attr('name', this.options.forceModificatorName + '[' + this._config.rowCount + ']');
		this.element.children(this.options.target).append(row);
		this._config.rowCount++;
		this.element.show();
	}
});