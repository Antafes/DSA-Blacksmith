<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty count modifier plugin
 *
 * Type:     modifier<br>
 * Name:     count<br>
 * Purpose:  count the number of items in an array
 *
 * @author Neithan
 * @param array $data The array to count the items
 * @return integer The amount of items in the array
 */
function smarty_modifier_count($data)
{
	return count($data);
}