<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$response = \Model\ItemType::create($_POST['data']);

echo json_encode(array('ok' => $response));