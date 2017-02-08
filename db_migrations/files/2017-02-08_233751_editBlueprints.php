<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Edit blueprints';
    },
    'up' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "editBlueprint", "Bauplan bearbeiten", 0)
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
			DELETE FROM `translations` WHERE `key` IN ("editBlueprint")
		');

        return !in_array(false, $results);
    }
);
