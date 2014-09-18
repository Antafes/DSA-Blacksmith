<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$blueprint = \Model\Blueprint::loadById($_POST['id']);

echo json_encode($blueprint->getResultingStats());