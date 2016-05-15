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

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editItem", "Gegenstand bearbeiten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editTechnique", "Technik bearbeiten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editMaterial", "Material bearbeiten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addMaterialAssetRow", "Materialeigenschaften hinzufügen", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
            DELETE FROM translations WHERE `key` IN ("editItemType", "unkownError", "editItem", "editTechnique", "editMaterial", "addMaterialAssetRow")
		');

		return !in_array(false, $results);

	}

);