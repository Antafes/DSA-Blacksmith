{include file="header.tpl"}
<div class="materials">
	<div class="submenu">
		<a class="button" id="addMaterial" href="#">{$translator->gt('addMaterial')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="material">{$translator->gt('material')}</th>
				<th class="materialType">{$translator->gt('materialType')}</th>
				<th class="percentage">{$translator->gt('percentage')}</th>
				<th class="timeFactor">{$translator->gt('timeFactor')}</th>
				<th class="priceFactor">{$translator->gt('priceFactor')}</th>
				<th class="priceWeight">{$translator->gt('priceWeight')}</th>
				<th class="proof">{$translator->gt('proof')}</th>
				<th class="breakFactor">{$translator->gt('breakFactor')}</th>
				<th class="hitPoints">{$translator->gt('hitPoints')}</th>
				<th class="armor">{$translator->gt('armor')}</th>
				<th class="weaponModificator">{$translator->gt('weaponModificator')}</th>
				<th class="additional">{$translator->gt('additional')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $materialListing->getList() as $material}
				{cycle values="odd,even" assign="rowClass"}
				<tr class="{$rowClass}">
					{assign var="assetCount" value=$material->getMaterialAssetArray()|count}
					<td class="material"{if $assetCount > 1} rowspan="{$assetCount}"{/if}>{$material->getName()}</td>
					<td class="materialType"{if $assetCount > 1} rowspan="{$assetCount}"{/if}>{$material->getMaterialType()}</td>
					{foreach $material->getMaterialAssetArray() as $materialAsset}
						<td class="timeFactor">{$materialAsset.percentage}&nbsp;%</td>
						<td class="timeFactor">{$materialAsset.timeFactor|number_format:2:',':'.'}</td>
						<td class="priceFactor">{$materialAsset.priceFactor|number_format:2:',':'.'}</td>
						<td class="priceWeight">{$materialAsset.priceWeight}</td>
						<td class="proof">{$materialAsset.proof}</td>
						<td class="breakFactor">{$materialAsset.breakFactor}</td>
						<td class="hitPoints">{$materialAsset.hitPoints}</td>
						<td class="armor">{$materialAsset.armor}</td>
						<td class="weaponModificator">
							{foreach $materialAsset.weaponModificator as $modificator}
								{$modificator.attack} / {$modificator.parade}{if $modificator@index < $modificator@total - 1} {$translator->gt('or')} {/if}
							{foreachelse}
								-
							{/foreach}
						</td>
						{if $materialAsset@first}
							<td class="additional"{if $assetCount > 1} rowspan="{$assetCount}"{/if}>
								{foreach $material->getAdditional() as $key => $value}
									{$key}: {$value}
								{foreachelse}
									-
								{/foreach}
							</td>
							<td{if $assetCount > 1} rowspan="{$assetCount}"{/if}>
								<a href="index.php?page=Materials&remove={$material->getMaterialId()}">X</a>
							</td>
						{/if}
						{if $materialAsset@last == false}
							</tr>
							<tr class="{$rowClass}">
						{/if}
					{foreachelse}
						<td class="timeFactor">-</td>
						<td class="timeFactor">-</td>
						<td class="priceFactor">-</td>
						<td class="priceWeight">-</td>
						<td class="proof">-</td>
						<td class="breakFactor">-</td>
						<td class="hitPoints">-</td>
						<td class="armor">-</td>
						<td class="weaponModificator">-</td>
						<td class="additional"{if $assetCount > 1} rowspan="{$assetCount}"{/if}>
							{foreach $material->getAdditional() as $key => $value}
								{$key}: {$value}
							{foreachelse}
								-
							{/foreach}
						</td>
						<td{if $assetCount > 1} rowspan="{$assetCount}"{/if}>
							<a href="index.php?page=Materials&remove={$material->getMaterialId()}">X</a>
						</td>
					{/foreach}
				</tr>
			{foreachelse}
				<tr>
					<td colspan="8">{$translator->gt('noMaterialsFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addMaterialPopup" style="display: none;" data-title="{$translator->gt('addMaterial')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addMaterial collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->gt('material')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('materialType')}</td>
						<td class="materialType">
							<select name="materialTypeId">
								{foreach $materialTypeListing->getList() as $materialType}
									<option value="{$materialType->getMaterialTypeId()}">{$materialType->getName()}</option>
								{/foreach}
							</select>
							<a id="addMaterialType" href="#">
								<img width="20" height="20" src="images/black_plus.png" />
							</a>
						</td>
					</tr>
					<tr>
						<td>{$translator->gt('additional')}</td>
						<td>
							<textarea name="additional"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<a href="#" id="addMaterialAssetRow">
				{$translator->gt('addMaterialAssetRow')}
			</a>
			<table id="materialAssets" class="addMaterialAsset collapse">
				<thead>
					<tr>
						<td class="percentage">{$translator->gt('percentage')}</td>
						<td class="timeFactor">{$translator->gt('timeFactor')}</td>
						<td class="priceFactor">{$translator->gt('priceFactor')}</td>
						<td class="priceWeight">{$translator->gt('priceWeight')}</td>
						<td class="proof">{$translator->gt('proof')}</td>
						<td class="breakFactor">{$translator->gt('breakFactor')}</td>
						<td class="hitPoints">{$translator->gt('hitPoints')}</td>
						<td class="armor">{$translator->gt('armor')}</td>
						<td class="weaponModificator">
							{$translator->gt('weaponModificator')}<br />
							<span class="help" title="{$translator->gt('weaponModificatorHelp')}"></span>
						</td>
						<td></td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<input type="submit" value="{$translator->gt('addMaterial')}" />
		</form>
	</div>
	<div id="addMaterialTypePopup" style="display: none;" data-title="{$translator->gt('addMaterialType')}">
		<form method="post" action="ajax/addMaterialType.php">
			{$translator->gt('materialType')}
			<input type="text" name="materialType" /><br />
			<input type="submit" value="{$translator->gt('addMaterialType')}" />
		</form>
	</div>
	<script type="text/javascript">
		window.currencies = {$currencyList};
	</script>
</div>
{include file="footer.tpl"}