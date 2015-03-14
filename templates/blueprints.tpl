{include file="header.tpl"}
<div id="blueprints">
	<div class="submenu">
		<a class="button" id="addBlueprint" href="#">{$translator->getTranslation('addBlueprint')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="blueprint">{$translator->getTranslation('blueprint')}</th>
				<th class="itemType">{$translator->getTranslation('itemType')}</th>
				<th class="endPrice">{$translator->getTranslation('endPrice')}</th>
				<th class="notes">{$translator->getTranslation('notes')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $blueprintListing->getList() as $blueprint}
				<tr class="{cycle values="odd,even"}">
					<td class="blueprint">
						<a class="blueprintShowLink" href="#" data-id="{$blueprint->getBlueprintId()}">{$blueprint->getName()}</a>
					</td>
					<td class="itemType">{$blueprint->getItemType()->getName()}</td>
					<td class="endPrice">{$blueprint->getEndPrice()}</td>
					<td class="notes">{$blueprint->getNotes()}</td>
					<td>
						<a href="index.php?page=Blueprints&amp;remove={$blueprint->getBlueprintId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="5">{$translator->getTranslation('noBlueprintsFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addBlueprintPopup" style="display: none;" data-title="{$translator->getTranslation('addBlueprint')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addBlueprint collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->getTranslation('blueprint')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('itemType')}</td>
						<td>
							<select name="itemTypeId">
								{foreach $itemTypeListing->getList() as $itemType}
									<option value="{$itemType->getItemTypeId()}">{$itemType->getName()}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('basePrice')}</td>
						<td>
							<input class="basePrice" type="number" name="basePrice" />
							<select class="currency" name="currency">
								{foreach $currencyList as $currencyShort => $currency}
									<option value="{$currencyShort}">{$currency.name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('twoHanded')}</td>
						<td>
							<input type="checkbox" name="twoHanded" value="1" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('improvisational')}</td>
						<td>
							<input type="checkbox" name="improvisational" value="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('baseHitPoints')}</td>
						<td>
							<input class="baseHitPointsDice" type="number" name="baseHitPointsDice" />
							<select class="baseHitPointsDiceType" name="baseHitPointsDiceType">
								<option value="d6">{$translator->getTranslation('d6')}</option>
								<option value="d20">{$translator->getTranslation('d20')}</option>
							</select>
							<input class="baseHitPoints" type="number" name="baseHitPoints" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('baseBreakFactor')}</td>
						<td>
							<input type="number" name="baseBreakFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('baseInitiative')}</td>
						<td>
							<input type="number" name="baseInitiative" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('baseWeaponModificator')}</td>
						<td>
							<textarea class="baseWeaponModificator" name="baseWeaponModificator"></textarea>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('weight')}</td>
						<td>
							<input type="number" name="weight" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('materials')}</td>
						<td>
							<a href="#" id="addMaterialRow">{$translator->getTranslation('addMaterialSelect')}</a>
							<table id="materialSelect" class="collapse" style="display: none;">
								<thead>
									<tr>
										<td class="material">{$translator->getTranslation('material')}</td>
										<td class="percentage">{$translator->getTranslation('percentage')}</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('techniques')}</td>
						<td>
							<a href="#" id="addTechniqueRow">{$translator->getTranslation('addTechniqueSelect')}</a>
							<table id="techniqueSelect" class="collapse" style="display: none;">
								<thead>
									<tr>
										<td>{$translator->getTranslation('technique')}</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('upgradeHitPoints')}</td>
						<td>
							<input name="upgradeHitPoints" type="number" min="0" max="3" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('upgradeBreakFactor')}</td>
						<td>
							<input name="upgradeBreakFactor" type="number" min="-7" max="0" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('upgradeInitiative')}</td>
						<td>
							<input name="upgradeInitiative" type="number" min="0" max="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('upgradeWeaponModificator')}</td>
						<td>
							<input class="upgradeWeaponModificator" name="upgradeWeaponModificator[attack]" type="number" min="0" max="1" /> / <input class="upgradeWeaponModificator" name="upgradeWeaponModificator[parade]" type="number" type="number" min="0" max="1" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->getTranslation('addBlueprint')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<script type="text/javascript">
		$(function() {
			window.materials = JSON.parse('{$materialList}');
			window.techniques = JSON.parse('{$techniqueList}');
		});
	</script>
</div>
{include file="footer.tpl"}