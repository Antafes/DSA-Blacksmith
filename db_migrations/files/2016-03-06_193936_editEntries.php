<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Edit entries';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editItemType", "Gegenstandstyp bearbeiten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "unkownError", "Ein unbekannter Fehler ist aufgetreten.", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
            DELETE FROM translations WHERE `key` IN ("editItemType", "unkownError")
		');

		return !in_array(false, $results);

	}

);