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
				<th class="priceFactor">{$translator->getTranslation('priceFactor')}</th>
				<th class="priceWeight">{$translator->getTranslation('priceWeight')}</th>
				<th class="proof">{$translator->getTranslation('proof')}</th>
				<th class="breakFactor">{$translator->getTranslation('breakFactor')}</th>
				<th class="armor">{$translator->getTranslation('armor')}</th>
				<th class="additional">{$translator->getTranslation('additional')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $materialListing->getList() as $material}
				<tr class="{cycle values="odd,even"}">
					<td class="material">{$material->getName()}</td>
					<td class="materialType">{$material->getMaterialType()}</td>
					<td class="priceFactor">{$material->getPriceFactor()|number_format:2:',':'.'}</td>
					<td class="priceWeight">{$material->getPriceWeight()}</td>
					<td class="proof">{$material->getProof()}</td>
					<td class="breakFactor">{$material->getBreakFactor()}</td>
					<td class="armor">{$material->getArmor()}</td>
					<td class="additional">
						{foreach $material->getAdditional() as $key => $value}
							{$key}: {$value}
						{foreachelse}
							-
						{/foreach}
					</td>
					<td>
						<a href="index.php?page=Materials&remove={$material->getMaterialId()}">X</a>
					</td>
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
					<tr class="odd">
						<td>{$translator->getTranslation('priceFactor')}</td>
						<td>
							<input type="number" step="0.01" name="priceFactor">
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('priceWeight')}</td>
						<td>
							<input class="priceWeight" type="number" name="priceWeight">
							<select class="currency" name="currency">
								{foreach $currencyList as $currencyShort => $currency}
									<option value="{$currencyShort}">{$currency.name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('proof')}</td>
						<td>
							<input type="number" name="proof">
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('breakFactor')}</td>
						<td>
							<input type="number" name="breakFactor">
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('armor')}</td>
						<td>
							<input type="number" name="armor">
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('additional')}</td>
						<td>
							<textarea name="additional"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->getTranslation('addMaterial')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="addMaterialTypePopup" style="display: none;" data-title="{$translator->getTranslation('addMaterialType')}">
		<form method="post" action="ajax/addMaterialType.php">
			{$translator->getTranslation('materialType')}
			<input type="text" name="materialType" /><br />
			<input type="submit" value="{$translator->getTranslation('addMaterialType')}" />
		</form>
	</div>
</div>
{include file="footer.tpl"}