<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Projectiles';
    },
    'up' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `items`
                ADD COLUMN `proofModificator` INT(11) NOT NULL DEFAULT "0" AFTER `physicalStrengthRequirement`
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "proofModificator", "Probenmodifikator", 0)
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `items`
                DROP COLUMN `proofModificator`
		');

		$results[] = SmartWork\Utility\Database::query_raw('
            DELETE FROM translations WHERE `key` IN ("proofModificator")
		');

        return !in_array(false, $results);
    }
);
