{include file="header.tpl"}
<div id="characters">
	<div class="addCharacter">
		<h1>{$translator->getTranslation('addCharacter')}</h1>
		<form method="post" action="index.php?page=Characters" enctype="multipart/form-data">
			<input type="file" name="fileupload" accept="application/xml" /><br />
			<input type="Submit" value="{$translator->getTranslation('upload')}" />
		</form>
	</div>
	<div class="characterList">
		<h1>{$translator->getTranslation('characterList')}</h1>
		<table class="collapse">
			<thead>
				<tr>
					<th class="characterName">{$translator->getTranslation('name')}</th>
					<th class="characterLastUpdate">{$translator->getTranslation('lastUpdate')}</th>
					<th class="characterBowMaking">{$translator->getTranslation('bowMaking')}</th>
					<th class="characterPrecisionMechanics">{$translator->getTranslation('precisionMechanics')}</th>
					<th class="characterBlacksmith">{$translator->getTranslation('blacksmith')}</th>
					<th class="characterWoodworking">{$translator->getTranslation('woodworking')}</th>
					<th class="characterLeatherworking">{$translator->getTranslation('leatherworking')}</th>
					<th class="characterTailoring">{$translator->getTranslation('tailoring')}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$characters->getAsArray() item='character'}
					<tr class="{cycle values="odd,even"}">
						<td class="characterName">{$character.name}</td>
						<td class="characterLastUpdate">{$character.lastUpdate->format($translator->getTranslation('dateFormat'))}</td>
						<td class="characterBowMaking">{$character.bowMaking}</td>
						<td class="characterPrecisionMechanics">{$character.precisionMechanics}</td>
						<td class="characterBlacksmith">{$character.blacksmith}</td>
						<td class="characterWoodworking">{$character.woodworking}</td>
						<td class="characterLeatherworking">{$character.leatherworking}</td>
						<td class="characterTailoring">{$character.tailoring}</td>
						<td>
							<a href="index.php?page=Characters&remove={$character.characterId}">X</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>
{include file="footer.tpl"}