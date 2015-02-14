{include file="header.tpl"}
<div class="itemTypes">
	<div class="submenu">
		<a class="button" id="addItemType" href="#">{$translator->getTranslation('addItemType')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="itemType">{$translator->getTranslation('itemType')}</th>
				<th class="talentPoints">{$translator->getTranslation('talentPoints')}</th>
				<th class="time">{$translator->getTranslation('time')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $itemTypeListing->getList() as $itemType}
				<tr class="{cycle values="odd,even"}">
					<td class="itemType">{$itemType->getName()}</td>
					<td class="talentPoints">{$itemType->getTalentPoints()}</td>
					<td class="time">{$itemType->getTime()|number_format:2:',':'.'} {$translator->getTranslation('tu')}</td>
					<td>
						<a href="index.php?page=ItemTypes&remove={$itemType->getItemTypeId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="4">{$translator->getTranslation('noItemTypesFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addItemTypePopup" style="display: none;" data-title="{$translator->getTranslation('addItemType')}">
		<form method="post" action="ajax/addItemType.php">
			<table class="addItemTypes collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->getTranslation('itemType')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('talentPoints')}</td>
						<td>
							<input type="number" step="0.01" name="talentPoints" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('time')}</td>
						<td>
							<input type="number" step="0.01" name="time" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->getTranslation('addItemType')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{include file="footer.tpl"}