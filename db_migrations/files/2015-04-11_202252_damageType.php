<?php
/**
 * SQL statements for the damage type of weapons.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

	'description' => function () {
		return 'Damage types for items and blueprints';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				ADD COLUMN `damageType` ENUM("damage","stamina") NOT NULL DEFAULT "damage" COLLATE "utf8_general_ci" AFTER `hitPoints`
		');

		$results[] = query_raw('
			UPDATE items SET damageType = "stamina"
			WHERE name IN ("Buckler", "Buckler, vollmetall", "Schlagring", "Turnierlanze", "Turnierschwert")
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ADD COLUMN `damageType` ENUM("damage","stamina") NOT NULL DEFAULT "damage" COLLATE "utf8_general_ci" AFTER `itemTypeId`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "(S)", "(A)", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "damageType", "Schadenstyp", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "damage", "Schaden", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "stamina", "Ausdauer", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `items`
				DROP COLUMN `damageType`
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				DROP COLUMN `damageType`
		');

		$results[] = query_raw('
			DELETE FROM `translations` WHERE `key` IN ("(S)", "damageType", "damage", "stamina")
		');

		return !in_array(false, $results);

	}

);