{include file="header.tpl"}
<div id="craftings">
	<div class="submenu">
		<a class="button" id="addCrafting" href="#">{$translator->getTranslation('addCrafting')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="craftingName">{$translator->getTranslation('name')}</th>
				<th class="craftingCharacter">{$translator->getTranslation('character')}</th>
				<th class="craftingBlueprint">{$translator->getTranslation('blueprint')}</th>
				<th class="craftingHandicap">{$translator->getTranslation('proof')}</th>
				<th class="craftingGainedTalentPoints">{$translator->getTranslation('gainedTalentPoints')}</th>
				<th class="craftingTotalTalentPoints">{$translator->getTranslation('totalTalentPoints')}</th>
				<th class="craftingEstimatedFinishingTime">{$translator->getTranslation('estimatedFinishingTime')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$craftings->getAsArray() item='crafting'}
				<tr class="{cycle values="odd,even"}{if $crafting.done == true} done{/if}">
					<td class="craftingName">
						<a href="#" class="showCraftingLink" data-id="{$crafting.blueprint->getBlueprintId()}">{$crafting.name}</a>
					</td>
					<td class="craftingCharacter">{$crafting.character->getName()}</td>
					<td class="craftingBlueprint">{$crafting.blueprint->getName()}</td>
					<td class="craftingHandicap">{$crafting.handicap}</td>
					<td class="craftingGainedTalentPoints">
						<a href="#" class="addTalentPoints" data-id="{$crafting.craftingId}">{$crafting.gainedTalentPoints}</a>
					</td>
					<td class="craftingTotalTalentPoints">
						{if $crafting.gainedTalentPoints > 0}
							{$crafting.totalTalentPoints - $crafting.gainedTalentPoints} ({$crafting.totalTalentPoints})
						{else}
							{$crafting.totalTalentPoints}
						{/if}
					</td>
					<td class="craftingEstimatedFinishingTime">{$crafting.estimatedFinishingTime}</td>
					<td>
						<a href="index.php?page=Craftings&amp;remove={$crafting.craftingId}">X</a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addCraftingPopup" style="display: none;" data-title="{$translator->getTranslation('addCrafting')}">
		<form method="post" action="ajax/addCrafting.php">
			<table class="addItemTypes collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->getTranslation('character')}</td>
						<td>
							<select name="characterId">
								{foreach from=$characters->getAsArray() item='character'}
									<option value="{$character.characterId}">{$character.name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('blueprint')}</td>
						<td>
							<select name="blueprintId">
								{foreach from=$blueprints->getAsArray() item='blueprint'}
									<option value="{$blueprint.id}">{$blueprint.name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('name')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('notes')}</td>
						<td>
							<textarea name="notes" cols="60" rows="10"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->getTranslation('addCrafting')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="showCraftingPopup" style="display: none;" data-title="{$translator->getTranslation('showCrafting')}">
		<table class="showCrafting collapse">
			<thead>
				<tr>
					<th class="name">{$translator->getTranslation('name')}</th>
					<th class="hitPoints">{$translator->getTranslation('hp')}</th>
					<th class="weight">{$translator->getTranslation('weight')}</th>
					<th class="breakFactor">{$translator->getTranslation('bf')}</th>
					<th class="initiative">{$translator->getTranslation('ini')}</th>
					<th class="price">{$translator->getTranslation('price')}</th>
					<th class="forceModificator">{$translator->getTranslation('fm')}</th>
					<th class="notes">{$translator->getTranslation('notes')}</th>
					<th class="time">{$translator->getTranslation('time')}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="name"></td>
					<td class="hitPoints"></td>
					<td class="weight"></td>
					<td class="breakFactor"></td>
					<td class="initiative"></td>
					<td class="price"></td>
					<td class="forceModificator"></td>
					<td class="notes"></td>
					<td class="time"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
{include file="footer.tpl"}