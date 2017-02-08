{include file="header.tpl"}
<div id="blueprints">
    <div class="submenu">
        <a class="button" id="addBlueprint" href="index.php?page=Blueprints&amp;action=edit&amp;id=new">{$translator->gt('addBlueprint')}</a>
        {foreach $blueprintListing->getGroupedList() as $key => $blueprints}
            <a class="button" href="#{$key}">{$translator->gt($key)}</a>
        {/foreach}
        <div class="clear"></div>
    </div>
    {foreach $blueprintListing->getGroupedList() as $key => $blueprints}
        <h3 id="{$key}">{$translator->gt($key)}</h3>
        <table class="collapse">
            <thead>
                <tr>
                    {foreach $columsPerItemType[$key] as $column}
                        <th class="{$column}">{$translator->gt($column)}</th>
                    {/foreach}
                    <th class="options"></th>
                </tr>
            </thead>
            <tbody>
                {foreach $blueprints as $blueprint}
                    <tr class="{cycle values="odd,even"}">
                        {foreach $columsPerItemType[$key] as $column}
                        <td class="{$column}">
                            {if $column == 'blueprint'}
                                <a class="blueprintShowLink" href="index.php?page=Blueprints&amp;action=stats&amp;id={$blueprint.id}">{$blueprint.name}</a>
                            {else}
                                {$translator->gt($blueprint[$column])}
                            {/if}
                        </td>
                        {/foreach}
                        <td class="options">
                            <a class="edit" href="index.php?page=Blueprints&amp;action=edit&amp;id={$blueprint.id}" data-data-url="index.php?page=Blueprints&action=get&id={$blueprint.id}">E</a>
                            <a class="remove" href="index.php?page=Blueprints&amp;action=remove&amp;id={$blueprint.id}">X</a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {foreachelse}
        <div>{$translator->gt('noBlueprintsFound')}</div>
    {/foreach}
    <div id="addBlueprintPopup" style="display: none;" data-title="{$translator->gt('addBlueprint')}">
        <form method="post" action="ajax/addMaterial.php">
            <table class="addBlueprint collapse">
                <tbody>
                    <tr class="name">
                        <td>{$translator->gt('blueprint')}</td>
                        <td>
                            <input type="text" name="name" />
                        </td>
                    </tr>
                    <tr class="items">
                        <td>{$translator->gt('item')}</td>
                        <td>
                            <select id="itemSelect" name="itemId">
                                {foreach $itemListing->getList() as $itemType => $items}
                                    <optgroup label="{$translator->gt($itemType)}">
                                        {foreach $items as $item}
                                            <option value="{$item->getItemId()}" data-itemtype="{$item->getItemType()}" data-damagetype="{$item->getDamageType()}">{$item->getName()}</option>
                                        {/foreach}
                                    </optgroup>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr class="itemType">
                        <td>{$translator->gt('itemType')}</td>
                        <td>
                            <select id="itemTypeSelect" name="itemTypeId">
                                {foreach $itemTypeListing->getList() as $itemType}
                                    <option value="{$itemType->getItemTypeId()}" data-type="{$itemType->getType()}">{$itemType->getName()}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr class="projectileForItem">
                        <td>{$translator->gt('projectileForItem')}</td>
                        <td>
                            <select id="projectileForItemSelect" name="projectileForItemId">
                                {foreach $itemListing->getList('rangedWeapon') as $item}
                                    <option value="{$item->getItemId()}">{$item->getName()}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr class="damageType">
                        <td>{$translator->gt('damageType')}</td>
                        <td>
                            <select id="damageTypeSelect" class="damageType" name="damageType">
                                <option value="damage">{$translator->gt('damage')}</option>
                                <option value="stamina">{$translator->gt('stamina')}</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="materials">
                        <td>{$translator->gt('materials')}</td>
                        <td>
                            <a href="#" id="addMaterialRow">{$translator->gt('addMaterialSelect')}</a>
                            <table id="materialSelect" class="collapse" style="display: none;">
                                <thead>
                                    <tr>
                                        <td class="material">{$translator->gt('material')}</td>
                                        <td class="percentage">{$translator->gt('percentage')}</td>
                                        <td class="talent">{$translator->gt('talent')}</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="techniques">
                        <td>{$translator->gt('techniques')}</td>
                        <td>
                            <a href="#" id="addTechniqueRow">{$translator->gt('addTechniqueSelect')}</a>
                            <table id="techniqueSelect" class="collapse" style="display: none;">
                                <thead>
                                    <tr>
                                        <td>{$translator->gt('technique')}</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="upgradeHitPoints">
                        <td>{$translator->gt('upgradeHitPoints')}</td>
                        <td>
                            <input name="upgradeHitPoints" type="number" min="0" max="3" />
                        </td>
                    </tr>
                    <tr class="upgradeBreakFactor">
                        <td>{$translator->gt('upgradeBreakFactor')}</td>
                        <td>
                            <input name="upgradeBreakFactor" type="number" min="-7" max="0" />
                        </td>
                    </tr>
                    <tr class="upgradeInitiative">
                        <td>{$translator->gt('upgradeInitiative')}</td>
                        <td>
                            <input name="upgradeInitiative" type="number" min="0" max="1" />
                        </td>
                    </tr>
                    <tr class="upgradeWeaponModificator">
                        <td>{$translator->gt('upgradeWeaponModificator')}</td>
                        <td>
                            <input class="upgradeWeaponModificatorAttack" name="upgradeWeaponModificator[attack]" type="number" min="0" max="1" /> / <input class="upgradeWeaponModificatorParade" name="upgradeWeaponModificator[parade]" type="number" type="number" min="0" max="1" />
                        </td>
                    </tr>
                    <tr class="bonusRangedFightValue">
                        <td>{$translator->gt('bonusRangedFightValue')}</td>
                        <td>
                            <input name="bonusRangedFightValue" type="number" min="0" max="2" />
                        </td>
                    </tr>
                    <tr class="reducePhysicalStrengthRequirement">
                        <td>{$translator->gt('reducePhysicalStrengthRequirement')}</td>
                        <td>
                            <input name="reducePhysicalStrengthRequirement" type="number" min="0" max="1" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="buttons">
                        <td colspan="2" class="buttonArea">
                            <input type="submit" value="{$translator->gt('addBlueprint')}" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        window.materials = {$materialList};
        window.techniques = {$techniqueList};
        window.talents = {$talentList};
        window.columsPerItemType = {$columsPerItemType|json_encode};
    </script>
</div>
{include file="footer.tpl"}