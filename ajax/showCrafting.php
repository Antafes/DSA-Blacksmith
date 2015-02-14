<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$crafting = \Model\Crafting::loadById($_POST['id']);

echo json_encode($crafting->getAsArray());