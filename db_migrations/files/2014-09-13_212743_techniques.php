<?php
/**
 * SQL statements for the techniques page.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

	'description' => function () {
		return 'Techniques';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `techniques` (
				`techniqueId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`timeFactor` DECIMAL(4,2) NOT NULL,
				`priceFactor` DECIMAL(4,2) NOT NULL,
				`proof` INT NOT NULL,
				`breakFactor` INT NOT NULL,
				`hitPoints` INT NOT NULL,
				`forceModificator` TEXT NOT NULL,
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`techniqueId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "technique", "Technik", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "timeFactor", "Zeit (Faktor)", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "hitPoints", "Trefferpunkte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "forceModificator", "Wuchtmodifikator", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addTechnique", "Technik hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noTechniquesFound", "Keine Techniken gefunden", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "forceModificatorHelp", "Werte in folgendem Schema eintragen: TA / PA\r\nWenn zwischen mehreren Modifikatoren gewählt werden soll, können die Wertpaare mit \"||\", \"or\" oder \"oder\" getrennt werden.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "or", "oder", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = query_raw('
			DROP TABLE techniques
		');

		return !!$result;

	}

);