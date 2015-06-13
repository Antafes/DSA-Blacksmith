{include file="header.tpl"}
<div id="index">
	<fieldset class="box">
		<legend>{$translator->gt('runningCraftings')}</legend>
		<table class="collapse">
			<thead>
				<tr>
					<th class="craftingName">{$translator->gt('name')}</th>
					<th class="craftingCharacter">{$translator->gt('character')}</th>
					<th class="craftingBlueprint">{$translator->gt('blueprint')}</th>
					<th class="craftingHandicap">{$translator->gt('proof')}</th>
					<th class="craftingGainedTalentPoints">{$translator->gt('gainedTalentPoints')}</th>
					<th class="craftingTotalTalentPoints">{$translator->gt('totalTalentPoints')}</th>
					<th class="craftingEstimatedFinishingTime">{$translator->gt('estimatedFinishingTime')}</th>
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
						<td class="craftingGainedTalentPoints" title="{$crafting.gainedTalentPointsInfo}">
							<a href="#" class="addTalentPoints" data-id="{$crafting.craftingId}" data-talents="{$crafting.talents|json_encode|escape}">{$crafting.totalGainedTalentPoints}</a>
						</td>
						<td class="craftingTotalTalentPoints" title="{$crafting.talentPointsInfo}">
							{if $crafting.totalGainedTalentPoints > 0}
								{$crafting.totalTalentPointsInfo}
							{else}
								{$crafting.totalTalentPoints}
							{/if}
						</td>
						<td class="craftingEstimatedFinishingTime">{$crafting.estimatedFinishingTime}</td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="7">{$translator->gt('noCraftingRunning')}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</fieldset>
</div>
{include file="footer.tpl"}