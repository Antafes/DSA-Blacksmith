<?php
/**
 * Add a new blueprint into the database.
 *
 * @package ajax
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
require_once(__DIR__.'/../lib/system/config.default.php');
require_once(__DIR__.'/../lib/system/util/mysql.php');

session_start();

$response = \Model\Blueprint::create(array_merge(array('userId' => $_SESSION['userId']), $_POST['data']));

echo json_encode(array('ok' => $response));