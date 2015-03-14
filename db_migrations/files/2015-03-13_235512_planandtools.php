<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Rework the location for the plan and tools bonus';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `craftings`
				ADD COLUMN `toolsProofModificator` INT NOT NULL AFTER `notes`,
				ADD COLUMN `planProofModificator` INT NOT NULL AFTER `toolsProofModificator`
		');

		$results[] = query_raw('
			UPDATE craftings, blueprints
			SET craftings.toolsProofModificator = blueprints.toolsProofModificator,
				craftings.planProofModificator = blueprints.planProofModificator
			WHERE craftings.blueprintId = blueprints.blueprintId
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				DROP COLUMN `toolsProofModificator`,
				DROP COLUMN `planProofModificator`
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "easing", "Erleichterung", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ADD COLUMN `toolsProofModificator` INT NOT NULL AFTER `weight`,
				ADD COLUMN `planProofModificator` INT NOT NULL AFTER `toolsProofModificator`
		');

		$results[] = query_raw('
			UPDATE craftings, blueprints
			SET blueprints.toolsProofModificator = craftings.toolsProofModificator,
				blueprints.planProofModificator = craftings.planProofModificator
			WHERE blueprints.blueprintId = craftings.blueprintId
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				DROP COLUMN `toolsProofModificator`,
				DROP COLUMN `planProofModificator`
		');

		$results[] = query_raw('
			DELETE FROM `translations` WHERE `key` = "easing"
		');

		return !in_array(false, $results);

	}

);