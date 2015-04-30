{include file="header.tpl"}
<div id="items">
	<div class="submenu">
		<a class="button" id="addItem" href="#">{$translator->gt('addItem')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="item">{$translator->gt('item')}</th>
				<th class="hitPoints">{$translator->gt('hp')}</th>
				<th class="weight">{$translator->gt('weight')}</th>
				<th class="breakFactor">{$translator->gt('bf')}</th>
				<th class="initiative">{$translator->gt('ini')}</th>
				<th class="price">{$translator->gt('price')}</th>
				<th class="weaponModificator">{$translator->gt('wm')}</th>
				<th class="notes">{$translator->gt('notes')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $itemsListing->getList() as $item}
				<tr class="{cycle values="odd,even"}">
					<td class="item">{$item->getName()}</td>
					<td class="hitPoints">{$item->getHitPointsString()}</td>
					<td class="weight">{$item->getWeight()}</td>
					<td class="breakFactor">{$item->getBreakFactor()}</td>
					<td class="initiative">{$item->getInitiative()}</td>
					<td class="price">{$item->getPriceFormatted()}</td>
					<td class="weaponModificator">{$item->getWeaponModificatorFormatted()}</td>
					<td class="notes">{$item->getNotes()}</td>
					<td>
						<a href="index.php?page=Items&amp;remove={$item->getItemId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="5">{$translator->gt('noItemsFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addItemPopup" style="display: none;" data-title="{$translator->gt('addItem')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addItem collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->gt('item')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('hitPoints')}</td>
						<td>
							<input class="hitPointsDice" type="number" name="hitPointsDice" />
							<select class="hitPointsDiceType" name="hitPointsDiceType">
								<option value="d6">{$translator->gt('d6')}</option>
								<option value="d20">{$translator->gt('d20')}</option>
							</select>
							<input class="hitPoints" type="number" name="hitPoints" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('damageType')}</td>
						<td>
							<select class="damageType" name="damageType">
								<option value="damage">{$translator->gt('damage')}</option>
								<option value="stamina">{$translator->gt('stamina')}</option>
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('weight')}</td>
						<td>
							<input type="number" name="weight" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('breakFactor')}</td>
						<td>
							<input type="number" name="breakFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('initiative')}</td>
						<td>
							<input type="number" name="initiative" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('price')}</td>
						<td>
							<input class="Price" type="number" name="price" />
							<select class="currency" name="currency">
								{foreach $currencyList as $currencyShort => $currency}
									<option value="{$currencyShort}">{$currency.name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('weaponModificator')}</td>
						<td>
							<textarea class="weaponModificator" name="weaponModificator"></textarea>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('twoHanded')}</td>
						<td>
							<input type="checkbox" name="twoHanded" value="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('improvisational')}</td>
						<td>
							<input type="checkbox" name="improvisational" value="1" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('privileged')}</td>
						<td>
							<input type="checkbox" name="privileged" value="1" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->gt('addItem')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{include file="footer.tpl"}