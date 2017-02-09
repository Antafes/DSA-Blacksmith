<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Blueprint sharing';
    },
    'up' => function ($migration_metadata) {
        $results = array();

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `users`
                ADD COLUMN `showPublicBlueprints` TINYINT(1) NOT NULL DEFAULT "1" AFTER `admin`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `blueprints`
                ADD COLUMN `public` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `reducePhysicalStrengthRequirement`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "public", "Öffentlich", 0)
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "showPublicBlueprints", "Öffentliche Baupläne anzeigen", 0)
        ');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "publicBlueprints", "Öffentliche Baupläne", 0)
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `users`
                DROP COLUMN `showPublicBlueprints`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `blueprints`
                DROP COLUMN `public`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            DELETE FROM `translations` WHERE `key` IN ("public", "showPublicBlueprints", "publicBlueprints")
        ');

        return !in_array(false, $results);
    }
);
