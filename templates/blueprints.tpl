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
				<th class="item">{$translator->getTranslation('item')}</th>
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
					<td class="item">{$blueprint->getItem()->getName()}</td>
					<td class="itemType">{$blueprint->getItemType()->getName()}</td>
					<td class="endPrice">{$blueprint->getEndPrice()}</td>
					<td class="notes">{$blueprint->getItem()->getNotes()}</td>
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
						<td>{$translator->getTranslation('item')}</td>
						<td>
							<select id="itemSelect" name="itemId">
								{foreach $itemListing->getList() as $item}
									<option value="{$item->getItemId()}" data-damagetype="{$item->getDamageType()}">{$item->getName()}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('itemType')}</td>
						<td>
							<select name="itemTypeId">
								{foreach $itemTypeListing->getList() as $itemType}
									<option value="{$itemType->getItemTypeId()}">{$itemType->getName()}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('damageType')}</td>
						<td>
							<select id="damageTypeSelect" class="damageType" name="damageType">
								<option value="damage">{$translator->getTranslation('damage')}</option>
								<option value="stamina">{$translator->getTranslation('stamina')}</option>
							</select>
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