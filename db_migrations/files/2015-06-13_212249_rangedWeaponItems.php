<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'ranged weapon items';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				ADD COLUMN `physicalStrengthRequirement` INT NOT NULL DEFAULT "0" AFTER `weight`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "physicalStrengthRequirement", "Körperkraftvoraussetzung", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				DROP COLUMN `physicalStrengthRequirement`
		');

		$results[] = query_raw('
			DELETE FROM `translations`
			WHERE `key` IN("physicalStrengthRequirement")
		');

		return !in_array(false, $results);

	}

);