<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Material weapon modificator';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "chooseWeaponModificator", "Waffenmodifikator auswählen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "atPa", "AT/PA", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DELETE FROM `translations`
			WHERE `key` IN ("chooseWeaponModificator", "atPa")
		');

		return !in_array(false, $results);

	}

);