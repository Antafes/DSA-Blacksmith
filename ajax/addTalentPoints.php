<?php
/**
 * Add talent points for crafting an item.
 *
 * @package ajax
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
require_once(__DIR__.'/../lib/system/config.default.php');
require_once(__DIR__.'/../lib/system/util/mysql.php');

session_start();

$crafting = \Model\Crafting::loadById($_POST['data']['craftingId']);
$crafting->addTalentPoints($_POST['data']['talentPoints']);

echo json_encode(array('ok' => true));
