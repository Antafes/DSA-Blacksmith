<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Rename the weapon modificator fields';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				CHANGE COLUMN `materialForceModificator` `materialWeaponModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `itemTypeId`,
				CHANGE COLUMN `upgradeForceModificator` `upgradeWeaponModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `upgradeInitiative`
		');

		$results[] = query_raw('
			ALTER TABLE `materialAssets`
				CHANGE COLUMN `forceModificator` `weaponModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `armor`
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				CHANGE COLUMN `materialWeaponModificator` `materialForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `itemTypeId`,
				CHANGE COLUMN `upgradeWeaponModificator` `upgradeForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `upgradeInitiative`
		');

		$results[] = query_raw('
			ALTER TABLE `materialAssets`
				CHANGE COLUMN `weaponModificator` `forceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `armor`
		');

		return !in_array(false, $results);

	}

);