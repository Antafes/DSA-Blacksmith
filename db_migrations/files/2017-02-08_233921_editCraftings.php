<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Edit craftings';
    },
    'up' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editCrafting", "Herstellung bearbeiten", 0)
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "updateWarning", "ACHTUNG, beim Aktualisieren werden alle bisher erworbenen Talentpunkte entfernt!", 0)
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
			DELETE FROM `translations` WHERE `key` IN ("editCrafting", "updateWarning")
		');

        return !in_array(false, $results);
    }
);
