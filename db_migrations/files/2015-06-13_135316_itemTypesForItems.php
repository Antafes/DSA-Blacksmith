<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'add itemTypes for items';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				ADD COLUMN `itemType` ENUM("meleeWeapon","rangedWeapon","shield","armor","projectile") NOT NULL DEFAULT "meleeWeapon" AFTER `name`
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				CHANGE COLUMN `type` `type` ENUM("meleeWeapon","rangedWeapon","shield","armor","projectile") NOT NULL DEFAULT "meleeWeapon" COLLATE "utf8_general_ci" AFTER `name`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "meleeWeapon", "Nahkampfwaffe", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "rangedWeapon", "Fernkampfwaffe", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "shield", "Schild", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "projectile", "Projektil", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "type", "Typ", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				DROP COLUMN `itemType`
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				CHANGE COLUMN `type` `type` ENUM("weapon","shield","armor","projectile") NOT NULL DEFAULT "weapon" COLLATE "utf8_general_ci" AFTER `name`
		');

		$results[] = query_raw('
			DELETE FROM `translations`
			WHERE `key` IN ("meleeWeapon", "rangedWeapon", "shield", "projectile", "type")
		');

		return !in_array(false, $results);

	}

);