{include file="header.tpl"}
<div id="techniques">
	<div class="submenu">
		<a class="button" id="addTechnique" href="#">{$translator->gt('addTechnique')}</a>
		<div class="clear"></div>
	</div>
	<table class="collapse">
		<thead>
			<tr>
				<th class="name">{$translator->gt('technique')}</th>
				<th class="timeFactor">{$translator->gt('timeFactor')}</th>
				<th class="priceFactor">{$translator->gt('priceFactor')}</th>
				<th class="proof">{$translator->gt('proof')}</th>
				<th class="breakFactor">{$translator->gt('breakFactor')}</th>
				<th class="hitPoints">{$translator->gt('hitPoints')}</th>
				<th class="options"></th>
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
					<td class="options">
                        <a class="edit" href="index.php?page=Techniques&amp;action=edit&amp;id={$technique->getTechniqueId()}" data-data-url="index.php?page=Techniques&amp;action=get&amp;id={$technique->getTechniqueId()}">E</a>
                        <a class="remove" href="index.php?page=Techniques&amp;action=remove&amp;id={$technique->getTechniqueId()}">X</a>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">{$translator->gt('noTechniquesFound')}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<div id="addTechniquePopup" style="display: none;" data-title="{$translator->gt('addTechnique')}">
		<form method="post">
			<table class="addTechnique collapse">
				<tbody>
					<tr class="odd">
						<td>{$translator->gt('technique')}</td>
						<td>
							<input type="text" name="name" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('timeFactor')}</td>
						<td>
							<input type="number" step="0.01" name="timeFactor" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('priceFactor')}</td>
						<td>
							<input type="number" step="0.01" name="priceFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('proof')}</td>
						<td>
							<input type="number" name="proof" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('breakFactor')}</td>
						<td>
							<input type="number" name="breakFactor" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('hitPoints')}</td>
						<td>
							<input type="number" name="hitPoints" />
						</td>
					</tr>
					<tr class="odd">
						<td>{$translator->gt('noOtherAllowed')}</td>
						<td>
							<input type="checkbox" name="noOtherAllowed" value="1" />
						</td>
					</tr>
					<tr class="even">
						<td>{$translator->gt('unsellable')}</td>
						<td>
							<input type="checkbox" name="unsellable" value="1" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttonArea">
							<input type="submit" value="{$translator->gt('addTechnique')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{include file="footer.tpl"}