<?php
/**
 * SQL statements for the crafting page.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

	'description' => function () {
		return 'Crafting';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `craftings` (
				`craftingId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`userId` INT(10) UNSIGNED NOT NULL,
				`blueprintId` INT(10) UNSIGNED NOT NULL,
				`characterId` INT(10) UNSIGNED NOT NULL,
				`name` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`notes` TEXT NOT NULL COLLATE "utf8_bin",
				`gainedTalentPoints` SMALLINT(4) NOT NULL,
				`done` TINYINT(1) NOT NULL,
				`deleted` TINYINT(1) NOT NULL,
				PRIMARY KEY (`craftingId`),
				INDEX `craftings_characterId` (`characterId`),
				INDEX `craftings_blueprintId` (`blueprintId`),
				INDEX `craftings_userId` (`userId`),
				CONSTRAINT `craftings_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `craftings_blueprintId` FOREIGN KEY (`blueprintId`) REFERENCES `blueprints` (`blueprintId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `craftings_characterId` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				ADD COLUMN `type` ENUM("weapon","shield","armor","projectile") NOT NULL AFTER `name`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "craftings", "Herstellungen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addCrafting", "Herstellung hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "character", "Charakter", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "gainedTalentPoints", "Erhaltene Talentpunkte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "totalTalentPoints", "Benötigte Talentpunkte", 0)
		');

		$results[] = query_raw('
			ALTER TABLE `materialsToBlueprints`
				ADD COLUMN `materialAssetId` INT UNSIGNED NOT NULL AFTER `blueprintId`,
				ADD CONSTRAINT `materialsToBlueprints_materialAssetId` FOREIGN KEY (`materialAssetId`) REFERENCES `materialAssets` (`materialAssetId`) ON UPDATE CASCADE ON DELETE CASCADE
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				CHANGE COLUMN `timeFactor` `timeFactor` DECIMAL(5,2) NOT NULL AFTER `name`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "timeFormat", "H:i:s", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "timeFormatShort", "H:i", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "days", "Tage", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "estimatedFinishingTime", "geschätzte Produktionszeit", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "showBlueprint", "Bauplan anzeigen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addTalentPoints", "Talentpunkte hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "add", "Hinzufügen", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DROP TABLE `craftings`
		');

		$results[] = query_raw('
			ALTER TABLE `itemtypes`
				DROP COLUMN `type`
		');

		$results[] = query_raw('
			ALTER TABLE `materialstoblueprints`
				DROP COLUMN `materialAssetId`,
				DROP FOREIGN KEY `materialsToBlueprints_materialAssetId`
		');

		return !in_array(false, $results);

	}

);