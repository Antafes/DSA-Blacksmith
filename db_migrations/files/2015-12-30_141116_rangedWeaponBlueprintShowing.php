<?php

$DB_MIGRATION = array(

	'description' => function () {
		return '';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "bonusRangedFightValueNote", "FK", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "reducePhysicalStrengthRequirementNote", "KK", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "improvisationalNote", "i", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "twoHandedNote", "z", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "privilegedNote", "p", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DELETE FROM `translations` WHERE `key` IN ("bonusRangedFightValueNote", "reducePhysicalStrengthRequirementNote", "improvisationalNote", "twoHandedNote", "privilegedNote")
		');

		return !in_array(false, $results);

	}

);