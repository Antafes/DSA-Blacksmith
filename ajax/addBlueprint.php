<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

session_start();

$response = \Model\Blueprint::create(array_merge(array('userId' => $_SESSION['userId']), $_POST['data']));

echo json_encode(array('ok' => $response));