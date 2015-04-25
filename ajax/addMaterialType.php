<?php
/**
 * Add a new material type.
 *
 * @package ajax
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$response = \Model\MaterialType::create(array('name' => $_POST['name']));

if ($response)
{
	$response['ok'] = true;
	echo json_encode($response);
	die();
}

echo json_encode(array('ok' => false));