<?php
/**
 * SQL statements for the material assets.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

	'description' => function () {
		return 'Material assets';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `materialAssets` (
				`materialAssetId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`materialId` INT(10) UNSIGNED NOT NULL,
				`percentage` INT(10) UNSIGNED NOT NULL,
				`timeFactor` DECIMAL(4,2) NOT NULL,
				`priceFactor` DECIMAL(4,2) NOT NULL,
				`priceWeight` INT(10) UNSIGNED NOT NULL,
				`proof` INT(11) NOT NULL,
				`breakFactor` INT(11) NOT NULL,
				`hitPoints` INT(11) NOT NULL,
				`armor` INT(11) NOT NULL,
				`forceModificator` TEXT NOT NULL COLLATE "utf8_bin",
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`materialAssetId`),
				INDEX `materialAsset_materialId` (`materialId`),
				CONSTRAINT `materialAsset_materialId` FOREIGN KEY (`materialId`) REFERENCES `materials` (`materialId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query('
			INSERT INTO materialAssets (materialId, percentage, timeFactor, priceFactor, priceWeight, proof, breakFactor, hitPoints, armor, forceModificator)
				SELECT materialId, "0" AS percentage, timefactor, priceFactor, priceWeight, proof, breakFactor, hitPoints, armor, forceModificator FROM materials
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				DROP COLUMN `timeFactor`,
				DROP COLUMN `priceFactor`,
				DROP COLUMN `priceWeight`,
				DROP COLUMN `proof`,
				DROP COLUMN `breakFactor`,
				DROP COLUMN `hitPoints`,
				DROP COLUMN `armor`,
				DROP COLUMN `forceModificator`
		');

		$results[] = query('
			UPDATE `translations` SET `value`="Werte in folgendem Schema eintragen: TA / PA\r\nWenn zwischen mehreren Modifikatoren gewählt werden soll, können die Wertpaare mit "||", "or" oder "oder" getrennt werden." WHERE  `translationId`=73
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query('
			UPDATE `dsa_blacksmith`.`translations` SET `value`="Werte in folgendem Schema eintragen: TA / PA\r\nWenn zwischen mehreren Modifikatoren gewählt werden soll, können die Wertpaare mit "||", "or" oder "oder" getrennt werden.\r\nFür eine Aktivierung der Modifikatoren ab bestimmten Prozentsätzen, kann der jeweilige Prozentsatz als erster Wert in der Zeile eingetragen und mit "|" von den Modifikatoren getrennt werden." WHERE  `translationId`=73
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ADD COLUMN `timeFactor` DECIMAL(4,2) NOT NULL AFTER `materialTypeId`,
				ADD COLUMN `priceFactor` DECIMAL(4,2) NOT NULL AFTER `timeFactor`,
				ADD COLUMN `priceWeight` INT UNSIGNED NOT NULL AFTER `priceFactor`,
				ADD COLUMN `proof` INT NOT NULL AFTER `priceWeight`,
				ADD COLUMN `breakFactor` INT NOT NULL AFTER `proof`,
				ADD COLUMN `hitPoints` INT UNSIGNED NOT NULL AFTER `breakFactor`,
				ADD COLUMN `armor` INT UNSIGNED NOT NULL AFTER `hitPoints`,
				ADD COLUMN `forceModificator` TEXT NOT NULL AFTER `armor`
		');

		$results[] = query_raw('
			UPDATE materials AS m
			LEFT JOIN materialAssets AS ma ON (ma.`materialId` = m.`materialId`)
			SET m.timeFactor = ma.`timeFactor`,
				m.priceFactor = ma.`priceFactor`,
				m.priceWeight = ma.`priceWeight`,
				m.proof = ma.proof,
				m.breakFactor = ma.`breakFactor`,
				m.hitPoints = ma.`hitPoints`,
				m.armor = ma.armor,
				m.forceModificator = ma.`forceModificator`
		');

		$results[] = query_raw('
			DROP TABLE materialAssets
		');

		return !in_array(false, $results);

	}

);