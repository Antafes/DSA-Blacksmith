{include file="header.tpl"}
<div class="itemTypes">
	<div class="submenu">
		<a class="button" id="addItemType" href="#">{$translator->gt('addItemType')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="itemType">{$translator->gt('itemType')}</th>
				<th class="type">{$translator->gt('type')}</th>
				<th class="talentPoints">{$translator->gt('talentPoints')}</th>
				<th class="time">{$translator->gt('time')}</th>
				<th class="options"></th>
			</tr>
		</thead>
		<tbody>
			{foreach $itemTypeListing->getList() as $itemType}
				<tr class="{cycle values="odd,even"}">
					<td class="itemType">{$itemType->getName()}</td>
					<td class="type">{$translator->gt($itemType->getType())}</td>
					<td class="talentPoints">{$itemType->getTalentPoints()}</td>
					<td class="time">{$itemType->getTime()|number_format:2:',':'.'} {$translator->gt('tu')}</td>
					<td class="options">
                        <a class="edit" href="index.php?page=ItemTypes&amp;action=edit&amp;id={$itemType->getItemTypeId()}" data-data-url="index.php?page=ItemTypes&action=get&id={$itemType->getItemTypeId()}">E</a>
                        <a class="remove" href="index.php?page=ItemTypes&amp;action=remove&amp;id={$itemType->getItemTypeId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="4">{$translator->gt('noItemTypesFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addItemTypePopup" style="display: none;" data-title="{$translator->gt('addItemType')}">
		<form>
			<table class="addItemTypes collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->gt('itemType')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('type')}</td>
						<td>
							<select class="type" name="type">
								<option value="meleeWeapon">{$translator->gt('meleeWeapon')}</option>
								<option value="rangedWeapon">{$translator->gt('rangedWeapon')}</option>
								<option value="shield">{$translator->gt('shield')}</option>
								<option value="armor">{$translator->gt('armor')}</option>
								<option value="projectile">{$translator->gt('projectile')}</option>
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('talentPoints')}</td>
						<td>
							<input type="number" step="0.01" name="talentPoints" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('time')}</td>
						<td>
							<input type="number" step="0.01" name="time" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->gt('addItemType')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{include file="footer.tpl"}