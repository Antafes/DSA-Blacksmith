<?php
/**
 * Get the crafting for the given id.
 *
 * @package ajax
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$crafting = \Model\Crafting::loadById($_POST['id']);

echo json_encode($crafting->getAsArray());