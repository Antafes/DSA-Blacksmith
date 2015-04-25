<?php
/**
 * SQL statements for the characters/heroes page.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

	'description' => function () {
		return 'Characters';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `characters` (
				`characterId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`userId` INT(10) UNSIGNED NOT NULL,
				`key` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`lastUpdate` DATETIME NOT NULL,
				`name` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`bowMaking` INT(11) NOT NULL,
				`precisionMechanics` INT(11) NOT NULL,
				`blacksmith` INT(11) NOT NULL,
				`woodworking` INT(11) NOT NULL,
				`leatherworking` INT(11) NOT NULL,
				`tailoring` INT(11) NOT NULL,
				`deleted` TINYINT(1) NOT NULL DEFAULT "0",
				PRIMARY KEY (`characterId`),
				INDEX `charachters_userId` (`userId`),
				UNIQUE INDEX `userId_key` (`userId`, `key`),
				CONSTRAINT `charachters_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "improvisationalTools", "Improvisierte Werkzeuge", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "missingSpecialTool", "Fehlendes Spezialwerkzeug", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "normalTools", "Normales Werkzeug", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "highQualityTools", "Hochwertiges Werkzeug", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "exceptionallyHighQualityTools", "Außergewöhnlich hochwertiges Werkzeug", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "name", "Name", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "lastUpdate", "Letzte Aktualisierung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "bowMaking", "Bogenbau", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "precisionMechanics", "Feinmechanik", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "blacksmith", "Grobschmied", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "woodworking", "Holzbearbeitung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "leatherworking", "Lederverarbeitung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "tailoring", "Schneiderei", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "dateFormat", "d.m.Y", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addCharacter", "Charakter hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "characterList", "Charakterliste", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "characters", "Charaktere", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "upload", "Hochladen", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DROP TABLE `characters`
		');

		return !in_array(false, $results);

	}

);