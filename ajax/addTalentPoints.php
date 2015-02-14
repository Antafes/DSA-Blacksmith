<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

session_start();

$crafting = \Model\Crafting::loadById($_POST['data']['craftingId']);
$crafting->addTalentPoints($_POST['data']['talentPoints']);

if ($crafting->getGainedTalentPoints() >= $crafting->getTotalTalentPoints())
{
	$crafting->done();
}

echo json_encode(array('ok' => true));
