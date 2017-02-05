<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Throwing weapons note';
    },
    'up' => function ($migration_metadata) {
        $results = array();

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `items`
                ADD COLUMN `throwingWeapon` TINYINT(1) NOT NULL DEFAULT "0" AFTER `privileged`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "throwingWeaponNote", "w", 0)
        ');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "throwingWeapon", "Wurfwaffe", 0)
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `items`
                DROP COLUMN `throwingWeapon`
        ');

        $results[] = SmartWork\Utility\Database::query_raw('
            DELETE FROM `translations` WHERE `key` IN ("throwingWeaponNote", "throwingWeapon")
        ');

        return !in_array(false, $results);
    }
);
