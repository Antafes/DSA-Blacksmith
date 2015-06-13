{include file="header.tpl"}
<div id="blueprints">
	<div class="submenu">
		<a class="button" id="addBlueprint" href="#">{$translator->gt('addBlueprint')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="blueprint">{$translator->gt('blueprint')}</th>
				<th class="item">{$translator->gt('item')}</th>
				<th class="itemType">{$translator->gt('itemType')}</th>
				<th class="endPrice">{$translator->gt('endPrice')}</th>
				<th class="notes">{$translator->gt('notes')}</th>
				<th class="options"></th>
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
					<td class="options">
						<a href="index.php?page=Blueprints&amp;remove={$blueprint->getBlueprintId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="5">{$translator->gt('noBlueprintsFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addBlueprintPopup" style="display: none;" data-title="{$translator->gt('addBlueprint')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addBlueprint collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->gt('blueprint')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('item')}</td>
						<td>
							<select id="itemSelect" name="itemId">
								{foreach $itemListing->getList() as $item}
									<option value="{$item->getItemId()}" data-itemtype="{$item->getItemType()}" data-damagetype="{$item->getDamageType()}">{$item->getName()}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('itemType')}</td>
						<td>
							<select id="itemTypeSelect" name="itemTypeId">
								{foreach $itemTypeListing->getList() as $itemType}
									<option value="{$itemType->getItemTypeId()}" data-type="{$itemType->getType()}">{$itemType->getName()}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('damageType')}</td>
						<td>
							<select id="damageTypeSelect" class="damageType" name="damageType">
								<option value="damage">{$translator->gt('damage')}</option>
								<option value="stamina">{$translator->gt('stamina')}</option>
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('materials')}</td>
						<td>
							<a href="#" id="addMaterialRow">{$translator->gt('addMaterialSelect')}</a>
							<table id="materialSelect" class="collapse" style="display: none;">
								<thead>
									<tr>
										<td class="material">{$translator->gt('material')}</td>
										<td class="percentage">{$translator->gt('percentage')}</td>
										<td class="talent">{$translator->gt('talent')}</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('techniques')}</td>
						<td>
							<a href="#" id="addTechniqueRow">{$translator->gt('addTechniqueSelect')}</a>
							<table id="techniqueSelect" class="collapse" style="display: none;">
								<thead>
									<tr>
										<td>{$translator->gt('technique')}</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('upgradeHitPoints')}</td>
						<td>
							<input name="upgradeHitPoints" type="number" min="0" max="3" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('upgradeBreakFactor')}</td>
						<td>
							<input name="upgradeBreakFactor" type="number" min="-7" max="0" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('upgradeInitiative')}</td>
						<td>
							<input name="upgradeInitiative" type="number" min="0" max="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('upgradeWeaponModificator')}</td>
						<td>
							<input class="upgradeWeaponModificator" name="upgradeWeaponModificator[attack]" type="number" min="0" max="1" /> / <input class="upgradeWeaponModificator" name="upgradeWeaponModificator[parade]" type="number" type="number" min="0" max="1" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->gt('addBlueprint')}" />
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
			window.talents = JSON.parse('{$talentList}');
		});
	</script>
</div>
{include file="footer.tpl"}