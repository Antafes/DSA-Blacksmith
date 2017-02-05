<?php
$DB_MIGRATION = array(
    'description' => function () {
        return 'Craft projectiles';
    },
    'up' => function ($migration_metadata) {
        $results = array();

        $results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `blueprints`
                ADD COLUMN `projectileForItemId` INT UNSIGNED NULL DEFAULT NULL AFTER `itemTypeId`,
                ADD CONSTRAINT `blueprints_projectileItem` FOREIGN KEY (`projectileForItemId`) REFERENCES `items` (`itemId`) ON UPDATE CASCADE ON DELETE CASCADE
        ');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "projectileForItem", "Fernkampfwaffe", 0)
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "decimalPoint", ",", 0)
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "thousandsSeparator", ".", 0)
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			UPDATE `translations` SET `key`="missingSpecialTools" WHERE `key`="missingSpecialTool"
		');

        return !in_array(false, $results);
    },
    'down' => function ($migration_metadata) {
        $results = array();

		$results[] = SmartWork\Utility\Database::query_raw('
            ALTER TABLE `blueprints`
                DROP COLUMN `projectileForItemId`,
                DROP INDEX `blueprints_projectileItem`,
                DROP FOREIGN KEY `blueprints_projectileItem`
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			DELETE FROM `translations` WHERE `key`IN ("projectileForItem", "decimalPoint", "thousandsSeparator")
		');

		$results[] = SmartWork\Utility\Database::query_raw('
			UPDATE `translations` SET `key`="missingSpecialTool" WHERE `key`="missingSpecialTools"
		');

        return !in_array(false, $results);
    }
);
