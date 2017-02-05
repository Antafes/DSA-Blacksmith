{include file="header.tpl"}
<div id="items">
    <div class="submenu">
        <a class="button" id="addItem" href="index.php?page=Items&amp;action=edit&amp;id=new">{$translator->gt('addItem')}</a>
        {foreach $itemsListing->getList() as $itemType => $items}
            <a class="button" href="#{$itemType}">{$translator->gt($itemType)}</a>
        {/foreach}
        <div class="clear"></div>
    </div>
    {foreach $itemsListing->getList() as $itemType => $items}
        <h3 id="{$itemType}">{$translator->gt($itemType)}</h3>
        <table class="collapse items">
            <thead>
                <tr>
                    {foreach $columsPerItemType[$itemType] as $class => $column}
                        <th class="{$class}">{$translator->gt($column.heading)}</th>
                    {/foreach}
                    <th class="options"></th>
                </tr>
            </thead>
            <tbody>
                {foreach $items as $item}
                    {assign var='itemArray' value=$item->getAsArray()}
                    <tr class="{cycle values="odd,even"}">
                        {foreach $columsPerItemType[$itemType] as $class  => $column}
                            <td class="{$class}">{$itemArray[$column.key]}</td>
                        {/foreach}
                        <td class="options">
                            <a class="edit" href="index.php?page=Items&amp;action=edit&amp;id={$itemArray.itemId}" data-data-url="index.php?page=Items&action=get&id={$itemArray.itemId}">E</a>
                            <a class="remove" href="index.php?page=Items&amp;action=remove&amp;id={$itemArray.itemId}">X</a>
                        </td>
                    </tr>
                {foreachelse}
                    <tr>
                        <td colspan="5">{$translator->gt('noItemsFound')}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {/foreach}
    <div id="addItemPopup" style="display: none;" data-title="{$translator->gt('addItem')}">
        <form method="post">
            <table class="addItem collapse">
                <tbody>
                    <tr class="name">
                        <td>{$translator->gt('item')}</td>
                        <td>
                            <input type="text" name="name" />
                        </td>
                    </tr>
                    <tr class="itemType">
                        <td>{$translator->gt('itemType')}</td>
                        <td>
                            <select id="itemTypeSelect" class="itemType" name="itemType">
                                <option value="meleeWeapon">{$translator->gt('meleeWeapon')}</option>
                                <option value="rangedWeapon">{$translator->gt('rangedWeapon')}</option>
                                <option value="shield">{$translator->gt('shield')}</option>
                                <option value="armor">{$translator->gt('armor')}</option>
                                <option value="projectile">{$translator->gt('projectile')}</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="hitPoints">
                        <td>{$translator->gt('hitPoints')}</td>
                        <td>
                            <input class="hitPointsDice" type="number" name="hitPointsDice" />
                            <select class="hitPointsDiceType" name="hitPointsDiceType">
                                <option value="d6">{$translator->gt('d6')}</option>
                                <option value="d20">{$translator->gt('d20')}</option>
                            </select>
                            <input class="hitPoints" type="number" name="hitPoints" />
                        </td>
                    </tr>
                    <tr class="hitPoints">
                        <td>{$translator->gt('damageType')}</td>
                        <td>
                            <select class="damageType" name="damageType">
                                <option value="damage">{$translator->gt('damage')}</option>
                                <option value="stamina">{$translator->gt('stamina')}</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="weight">
                        <td>{$translator->gt('weight')}</td>
                        <td>
                            <input type="number" name="weight" />
                        </td>
                    </tr>
                    <tr class="breakFactor">
                        <td>{$translator->gt('breakFactor')}</td>
                        <td>
                            <input type="number" name="breakFactor" />
                        </td>
                    </tr>
                    <tr class="initiative">
                        <td>{$translator->gt('initiative')}</td>
                        <td>
                            <input type="number" name="initiative" />
                        </td>
                    </tr>
                    <tr class="price">
                        <td>{$translator->gt('price')}</td>
                        <td>
                            <input class="Price" type="number" name="price" />
                            <select class="currency" name="currency">
                                {foreach $currencyList as $currencyShort => $currency}
                                    <option value="{$currencyShort}">{$currency.name}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr class="weaponModificator">
                        <td>{$translator->gt('weaponModificator')}</td>
                        <td>
                            <textarea class="weaponModificator" name="weaponModificator"></textarea>
                        </td>
                    </tr>
                    <tr class="notes">
                        <td>{$translator->gt('twoHanded')}</td>
                        <td>
                            <input type="checkbox" name="twoHanded" value="1" />
                        </td>
                    </tr>
                    <tr class="notes">
                        <td>{$translator->gt('improvisational')}</td>
                        <td>
                            <input type="checkbox" name="improvisational" value="1" />
                        </td>
                    </tr>
                    <tr class="notes">
                        <td>{$translator->gt('privileged')}</td>
                        <td>
                            <input type="checkbox" name="privileged" value="1" />
                        </td>
                    </tr>
                    <tr class="notes">
                        <td>{$translator->gt('throwingWeapon')}</td>
                        <td>
                            <input type="checkbox" name="throwingWeapon" value="1" />
                        </td>
                    </tr>
                    <tr class="physicalStrengthRequirement">
                        <td>{$translator->gt('physicalStrengthRequirement')}</td>
                        <td>
                            <input type="text" name="physicalStrengthRequirement" value="0" />
                        </td>
                    </tr>
                    <tr class="proofModificator">
                        <td>{$translator->gt('proofModificator')}</td>
                        <td>
                            <input type="number" name="proofModificator" value="0" min="0" max="8" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="buttons">
                        <td colspan="2" class="buttonArea">
                            <input type="submit" value="{$translator->gt('addItem')}" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    window.columsPerItemType = {$columsPerItemType|json_encode};
</script>
{include file="footer.tpl"}