{include file="header.tpl"}
<div class="materials">
	<div class="submenu">
		<a class="button" id="addMaterial" href="#">{$translator->getTranslation('addMaterial')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="material">{$translator->getTranslation('material')}</th>
				<th class="materialType">{$translator->getTranslation('materialType')}</th>
				<th class="percentage">{$translator->getTranslation('percentage')}</th>
				<th class="timeFactor">{$translator->getTranslation('timeFactor')}</th>
				<th class="priceFactor">{$translator->getTranslation('priceFactor')}</th>
				<th class="priceWeight">{$translator->getTranslation('priceWeight')}</th>
				<th class="proof">{$translator->getTranslation('proof')}</th>
				<th class="breakFactor">{$translator->getTranslation('breakFactor')}</th>
				<th class="hitPoints">{$translator->getTranslation('hitPoints')}</th>
				<th class="armor">{$translator->getTranslation('armor')}</th>
				<th class="forceModificator">{$translator->getTranslation('forceModificator')}</th>
				<th class="additional">{$translator->getTranslation('additional')}</th>
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
						<td class="forceModificator">
							{foreach $materialAsset.forceModificator as $modificator}
								{$modificator.attack} / {$modificator.parade}{if $modificator@index < $modificator@total - 1} {$translator->getTranslation('or')} {/if}
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
						<td class="forceModificator">-</td>
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
					<td colspan="8">{$translator->getTranslation('noMaterialsFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addMaterialPopup" style="display: none;" data-title="{$translator->getTranslation('addMaterial')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addMaterial collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->getTranslation('material')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('materialType')}</td>
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
						<td>{$translator->getTranslation('additional')}</td>
						<td>
							<textarea name="additional"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<a href="#" id="addMaterialAssetRow">
				{$translator->getTranslation('addMaterialAssetRow')}
			</a>
			<table id="materialAssets" class="addMaterialAsset collapse">
				<thead>
					<tr>
						<td class="percentage">{$translator->getTranslation('percentage')}</td>
						<td class="timeFactor">{$translator->getTranslation('timeFactor')}</td>
						<td class="priceFactor">{$translator->getTranslation('priceFactor')}</td>
						<td class="priceWeight">{$translator->getTranslation('priceWeight')}</td>
						<td class="proof">{$translator->getTranslation('proof')}</td>
						<td class="breakFactor">{$translator->getTranslation('breakFactor')}</td>
						<td class="hitPoints">{$translator->getTranslation('hitPoints')}</td>
						<td class="armor">{$translator->getTranslation('armor')}</td>
						<td class="forceModificator">
							{$translator->getTranslation('forceModificator')}<br />
							<span class="help" title="{$translator->getTranslation('forceModificatorHelp')}"></span>
						</td>
						<td></td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<input type="submit" value="{$translator->getTranslation('addMaterial')}" />
		</form>
	</div>
	<div id="addMaterialTypePopup" style="display: none;" data-title="{$translator->getTranslation('addMaterialType')}">
		<form method="post" action="ajax/addMaterialType.php">
			{$translator->getTranslation('materialType')}
			<input type="text" name="materialType" /><br />
			<input type="submit" value="{$translator->getTranslation('addMaterialType')}" />
		</form>
	</div>
	<script type="text/javascript">
		window.currencies = {$currencyList};
	</script>
</div>
{include file="footer.tpl"}