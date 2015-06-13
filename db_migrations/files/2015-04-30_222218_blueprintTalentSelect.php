<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'talent selection for blueprints';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `materialsToBlueprints`
				ADD COLUMN `talent` ENUM("bowMaking","precisionMechanics","blacksmith","woodworking","leatherworking","tailoring") NOT NULL AFTER `percentage`
		');

		$results[] = query_raw('
			UPDATE materialsToBlueprints
			SET talent = "blacksmith"
		');

		$results[] = query_raw('
			CREATE TABLE `craftingTalentPoints` (
				`craftingId` INT(10) UNSIGNED NOT NULL,
				`materialId` INT(10) UNSIGNED NOT NULL,
				`blueprintId` INT(10) UNSIGNED NOT NULL,
				`gainedTalentPoints` INT(10) UNSIGNED NOT NULL,
				`deleted` TINYINT(1) NOT NULL,
				INDEX `craftingsToCraftingTalentPoints` (`craftingId`),
				INDEX `materialsToCraftingTalentPoints` (`materialId`, `blueprintId`),
				CONSTRAINT `craftingsToCraftingTalentPoints` FOREIGN KEY (`craftingId`) REFERENCES `craftings` (`craftingId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `materialsToCraftingTalentPoints` FOREIGN KEY (`materialId`, `blueprintId`) REFERENCES `materialsToBlueprints` (`materialId`, `blueprintId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO craftingTalentPoints (craftingId, materialId, blueprintId, gainedTalentPoints, deleted)
			SELECT craftings.craftingId, materialsToBlueprints.materialId, materialsToBlueprints.blueprintId, craftings.gainedTalentPoints, craftings.deleted FROM craftings, materialsToBlueprints WHERE craftings.blueprintId = materialsToBlueprints.blueprintId
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				ADD COLUMN `doneProofs` INT(11) NOT NULL AFTER `planProofModificator`,
				DROP COLUMN `gainedTalentPoints`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "talent", "Talent", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noTalentPointsToAdd", "Es können keine weiteren Talentpunkte hinzugefügt werden.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "productionTime", "Produktionszeit", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "day", "Tag", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `materialsToBlueprints`
				DROP COLUMN `talent`
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				ADD COLUMN `gainedTalentPoints` TINYINT(4) NOT NULL AFTER `planProofModificator`,
				DROP COLUMN `doneProofs`
		');

		$results[] = query_raw('
			UPDATE craftings
			JOIN (SELECT craftingTalentPoints.craftingId, SUM(craftingTalentPoints.gainedTalentPoints) AS sumGainedTalentPoints FROM craftingTalentPoints GROUP BY craftingTalentPoints.craftingId) AS ctp ON ctp.craftingId = craftings.craftingId
			SET craftings.gainedTalentPoints = ctp.sumGainedTalentPoints
		');

		$results[] = query_raw('
			DROP TABLE `craftingTalentPoints`
		');

		$results[] = query_raw('
			DELETE FROM `translations` WHERE `key` IN ("talent", "noTalentPointsToAdd", "productionTime", "day")
		');

		return !in_array(false, $results);

	}

);