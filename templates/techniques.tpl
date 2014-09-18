{include file="header.tpl"}
<div id="techniques">
	<div class="submenu">
		<a class="button" id="addTechnique" href="#">{$translator->getTranslation('addTechnique')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="name">{$translator->getTranslation('technique')}</th>
				<th class="timeFactor">{$translator->getTranslation('timeFactor')}</th>
				<th class="priceFactor">{$translator->getTranslation('priceFactor')}</th>
				<th class="proof">{$translator->getTranslation('proof')}</th>
				<th class="breakFactor">{$translator->getTranslation('breakFactor')}</th>
				<th class="hitPoints">{$translator->getTranslation('hitPoints')}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $techniqueListing->getList() as $technique}
				<tr class="{cycle values="odd,even"}">
					<td class="technique">{$technique->getName()}</td>
					<td class="timeFactor">{$technique->getTimeFactor()|number_format:2:',':'.'}</td>
					<td class="priceFactor">{$technique->getPriceFactor()|number_format:2:',':'.'}</td>
					<td class="proof">{$technique->getProof()}</td>
					<td class="breakFactor">{$technique->getBreakFactor()}</td>
					<td class="hitPoints">{$technique->getHitPoints()}</td>
					<td>
						<a href="index.php?page=Techniques&amp;remove={$technique->getTechniqueId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">{$translator->getTranslation('noTechniquesFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addTechniquePopup" style="display: none;" data-title="{$translator->getTranslation('addTechnique')}">
		<form method="post" action="ajax/addMaterial.php">
			<table class="addTechnique collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->getTranslation('technique')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('timeFactor')}</td>
						<td>
							<input type="number" step="0.01" name="timeFactor" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('priceFactor')}</td>
						<td>
							<input type="number" step="0.01" name="priceFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('proof')}</td>
						<td>
							<input type="number" name="proof" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('breakFactor')}</td>
						<td>
							<input type="number" name="breakFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('hitPoints')}</td>
						<td>
							<input type="number" name="hitPoints" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->getTranslation('noOtherAllowed')}</td>
						<td>
							<input type="checkbox" name="noOtherAllowed" value="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->getTranslation('unsellable')}</td>
						<td>
							<input type="checkbox" name="unsellable" value="1" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->getTranslation('addTechnique')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{include file="footer.tpl"}