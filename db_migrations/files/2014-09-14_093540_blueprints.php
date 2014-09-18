<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Blueprints';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `blueprints` (
				`blueprintId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`itemTypeId` INT(10) UNSIGNED NOT NULL,
				`basePrice` INT(11) NOT NULL,
				`twoHanded` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				`improvisational` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				`baseHitPointsDice` INT(11) NOT NULL,
				`baseHitPointsDiceType` ENUM("d6","d20") NOT NULL COLLATE "utf8_bin",
				`baseHitPoints` INT(11) NOT NULL,
				`baseBreakFactor` INT(11) NOT NULL,
				`baseInitiative` INT(11) NOT NULL,
				`baseForceModificator` TEXT NOT NULL COLLATE "utf8_bin",
				`weight` INT(11) NOT NULL,
				`toolsProofModificator` INT(11) NOT NULL,
				`planProofModificator` INT(11) NOT NULL,
				`materialForceModificator` TEXT NOT NULL COLLATE "utf8_bin",
				`upgradeHitPoints` INT(11) NOT NULL,
				`upgradeBreakFactor` INT(11) NOT NULL,
				`upgradeInitiative` INT(11) NOT NULL,
				`upgradeForceModificator` TEXT NOT NULL COLLATE "utf8_bin",
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`blueprintId`),
				INDEX `blueprints_itemType` (`itemTypeId`),
				CONSTRAINT `blueprints_itemType` FOREIGN KEY (`itemTypeId`) REFERENCES `itemtypes` (`itemTypeId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `materialstoblueprints` (
				`materialId` INT(10) UNSIGNED NOT NULL,
				`blueprintId` INT(10) UNSIGNED NOT NULL,
				`percentage` INT(10) UNSIGNED NOT NULL,
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`materialId`, `blueprintId`),
				INDEX `materialsToBlueprints_blueprintId` (`blueprintId`),
				CONSTRAINT `materialsToBlueprints_blueprintId` FOREIGN KEY (`blueprintId`) REFERENCES `blueprints` (`blueprintId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `materialsToBlueprints_materialId` FOREIGN KEY (`materialId`) REFERENCES `materials` (`materialId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `techniquesToBlueprints` (
				`techniqueId` INT(10) UNSIGNED NOT NULL,
				`blueprintId` INT(10) UNSIGNED NOT NULL,
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`techniqueId`, `blueprintId`),
				CONSTRAINT `techniquesToBlueprints_techniqueId` FOREIGN KEY (`techniqueId`) REFERENCES `techniques` (`techniqueId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `techniquesToBlueprints_blueprintId` FOREIGN KEY (`blueprintId`) REFERENCES `blueprints` (`blueprintId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				ADD COLUMN `noOtherAllowed` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `forceModificator`
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				ADD COLUMN `unsellable` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `noOtherAllowed`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "blueprints", "Baupläne", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "blueprint", "Bauplan", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "endPrice", "Endpreis", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "notes", "Bemerkungen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noBlueprintsFound", "Es wurden keine Baupläne gefunden.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addBlueprint", "Bauplan hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "basePrice", "Grundpreis", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "twoHanded", "Zweihändig", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "improvisational", "Improvisiert", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "baseHitPoints", "Grund-Trefferpunkte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "baseBreakFactor", "Grund-Bruchfaktor", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "baseInitiative", "Grund-Initiative", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "baseForceModificator", "Grund-Wuchtmodifikator", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "weight", "Gewicht (Unzen)", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "toolsProofModificator", "Werkzeug", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "planProofModificator", "Modifikator durch Plan", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "percentage", "Anteil", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addMaterialSelect", "Materialauswahl hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addTechniqueSelect", "Technikauswahl hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "upgradeHitPoints", "Zusätzliche Trefferpunkte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "upgradeBreakFaktor", "Reduzierter Bruchfaktor", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "upgradeInitiative", "Zusätzliche Initiative", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "upgradeForceModificator", "Zusätzlicher Wuchtmodifikator", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "d6", "W6", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "d20", "W20", 0)
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
			DROP COLUMN `forceModificator`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ADD COLUMN `forceModificator` TEXT NOT NULL AFTER `armor`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noOtherAllowed", "Keine weitere Technik erlaubt", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "unsellable", "unverkäuflich", 0)
		');

		$results[] = query_raw('
			UPDATE `dsa_blacksmith`.`translations` SET `value`="Werte in folgendem Schema eintragen: TA / PA\r\nWenn zwischen mehreren Modifikatoren gewählt werden soll, können die Wertpaare mit "||", "or" oder "oder" getrennt werden.\r\nFür eine Aktivierung der Modifikatoren ab bestimmten Prozentsätzen, kann der jeweilige Prozentsatz als erster Wert in der Zeile eingetragen und mit "|" von den Modifikatoren getrennt werden." WHERE  `translationId`=73
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ADD COLUMN `timeFactor` DECIMAL(4,2) NOT NULL AFTER `materialTypeId`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ADD COLUMN `hitPoints` INT(10) UNSIGNED NOT NULL AFTER `breakFactor`
		');

		$results[] = query_raw('
			ALTER TABLE `itemtypes`
			ALTER `priceFactor` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `itemtypes`
				CHANGE COLUMN `priceFactor` `talentPoints` INT NOT NULL AFTER `name`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "talentPoints", "Talentpunkte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "tu", "ZE", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "name", "Name", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "hp", "TP", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "bf", "BF", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "ini", "INI", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "price", "Preis", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "fm", "WM", 0)
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
			ALTER `breakFactor` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				CHANGE COLUMN `breakFactor` `breakFactor` INT(11) NOT NULL AFTER `proof`
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DROP TABLE materialsToBlueprints
		');

		$results[] = query_raw('
			DROP TABLE techniquesToBlueprints
		');

		$results[] = query_raw('
			DROP TABLE blueprints
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
			DROP COLUMN `noOtherAllowed`
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
			DROP COLUMN `unsellable`
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				ADD COLUMN `forceModificator` TEXT NOT NULL AFTER `hitPoints`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
			DROP COLUMN `forceModificator`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
			DROP COLUMN `timeFactor`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
			DROP COLUMN `hitPoints`
		');

		$results[] = query_raw('
			ALTER TABLE `itemtypes`
			ALTER `talentPoints` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `itemtypes`
				CHANGE COLUMN `talentPoints` `priceFactor` DECIMAL(4,2) NOT NULL AFTER `name`
		');

		return !in_array(false, $results);

	}

);