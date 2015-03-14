{include file="header.tpl"}
<div id="index">
	<fieldset class="box">
		<legend>{$translator->getTranslation('runningCraftings')}</legend>
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
					</tr>
				{foreachelse}
					<tr>
						<td colspan="7">{$translator->getTranslation('noCraftingRunning')}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</fieldset>
</div>
{include file="footer.tpl"}