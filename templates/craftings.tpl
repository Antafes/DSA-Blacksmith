{include file="header.tpl"}
<div id="craftings">
    <div class="submenu">
        <a class="button" id="addCrafting" href="index.php?page=Craftings&amp;action=edit&amp;id=new">{$translator->gt('addCrafting')}</a>
        <div class="clear"></div>
    </div>
    <table class="collapse">
        <thead>
            <tr>
                <th class="craftingName">{$translator->gt('name')}</th>
                <th class="craftingCharacter">{$translator->gt('character')}</th>
                <th class="craftingBlueprint">{$translator->gt('blueprint')}</th>
                <th class="item">{$translator->gt('item')}</th>
                <th class="craftingHandicap">{$translator->gt('proof')}</th>
                <th class="craftingGainedTalentPoints">{$translator->gt('gainedTalentPoints')}</th>
                <th class="craftingTotalTalentPoints">{$translator->gt('totalTalentPoints')}</th>
                <th class="craftingEstimatedFinishingTime">{$translator->gt('productionTime')}</th>
                <th class="options"></th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$craftings->getAsArray() item='crafting'}
                <tr class="{cycle values="odd,even"}{if $crafting.done == true} done{/if}">
                    <td class="craftingName">
                        <a href="index.php?page=Blueprints&amp;action=stats&amp;id={$crafting.blueprint->getBlueprintId()}" class="showCraftingLink">{$crafting.name}</a>
                    </td>
                    <td class="craftingCharacter">{$crafting.character->getName()}</td>
                    <td class="craftingBlueprint">{$crafting.blueprint->getName()}</td>
                    <td class="item">{$crafting.blueprint->getItem()->getName()}</td>
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
                    <td class="craftingEstimatedFinishingTime">{$crafting.productionTime}</td>
                    <td class="options">
                        <a class="edit" href="index.php?page=Craftings&amp;action=edit&amp;id={$crafting.craftingId}" data-data-url="index.php?page=Craftings&action=get&id={$crafting.craftingId}">E</a>
                        <a class="remove" href="index.php?page=Craftings&amp;action=remove&amp;id={$crafting.craftingId}">X</a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <div id="addCraftingPopup" style="display: none;" data-title="{$translator->gt('addCrafting')}">
        <form method="post" action="ajax/addCrafting.php">
            <table class="addItemTypes collapse">
                <tbody>
                    <tr class="odd">
                        <td>{$translator->gt('character')}</td>
                        <td>
                            <select name="characterId">
                                {foreach from=$characters->getAsArray() item='character'}
                                    <option value="{$character.characterId}">{$character.name}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>{$translator->gt('blueprint')}</td>
                        <td>
                            <select name="blueprintId">
                                {foreach from=$blueprints->getAsArray() item='blueprint'}
                                    <option value="{$blueprint.id}">{$blueprint.name} ({$blueprint.item})</option>
                                {/foreach}
                                {if ($user->getShowPublicBlueprints() && $publicBlueprints->getAsArray())}
                                    <optgroup class="publicBlueprints" label="{$translator->gt('publicBlueprints')}">
                                        {foreach from=$publicBlueprints->getAsArray() item='blueprint'}
                                            <option value="{$blueprint.id}">{$blueprint.name} ({$blueprint.item})</option>
                                        {/foreach}
                                    </optgroup>
                                {/if}
                            </select><br />
                            <label>
                                <input type="checkbox" id="showPublicBlueprints" value="1" {if $user->getShowPublicBlueprints()}checked="checked"{/if} />
                                {$translator->gt(showPublicBlueprints)}
                            </label>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>{$translator->gt('name')}</td>
                        <td>
                            <input type="text" name="name" />
                        </td>
                    </tr>
                    <tr class="even">
                        <td>{$translator->gt('notes')}</td>
                        <td>
                            <textarea name="notes" cols="60" rows="10"></textarea>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>{$translator->gt('toolsProofModificator')}</td>
                        <td>
                            <select name="toolsProofModificator">
                                <option value="-7">{$translator->gt('improvisationalTools')}</option>
                                <option value="-3">{$translator->gt('missingSpecialTools')}</option>
                                <option value="0" selected="selected">{$translator->gt('normalTools')}</option>
                                <option value="3">{$translator->gt('highQualityTools')}</option>
                                <option value="7">{$translator->gt('exceptionallyHighQualityTools')}</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>{$translator->gt('planProofModificator')}</td>
                        <td>
                            <input type="number" name="planProofModificator" min="-7" max="7" title="{$translator->gt('easing')}" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="buttons">
                        <td colspan="2" class="buttonArea">
                            <div class="updateWarning hidden">
                                {$translator->gt('updateWarning')}
                            </div>
                            <input type="submit" value="{$translator->gt('addCrafting')}" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>
{include file="footer.tpl"}