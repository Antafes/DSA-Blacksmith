<?php
/**
 * Add a new item type.
 *
 * @package ajax
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$response = \Model\ItemType::create($_POST['data']);

echo json_encode(array('ok' => $response));