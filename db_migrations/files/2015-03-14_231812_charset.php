<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Charset adjustments';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ALTER `name` DROP DEFAULT,
				ALTER `baseHitPointsDiceType` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `userid`,
				CHANGE COLUMN `baseHitPointsDiceType` `baseHitPointsDiceType` ENUM("d6","d20") NOT NULL COLLATE "utf8_general_ci" AFTER `baseHitPointsDice`,
				CHANGE COLUMN `baseForceModificator` `baseForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `baseInitiative`,
				CHANGE COLUMN `materialForceModificator` `materialForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `weight`,
				CHANGE COLUMN `upgradeForceModificator` `upgradeForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `upgradeInitiative`
		');

		$results[] = query_raw('
			ALTER TABLE `characters`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `characters`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `lastUpdate`
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `characterId`,
				CHANGE COLUMN `notes` `notes` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `name`
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				ALTER `name` DROP DEFAULT,
				ALTER `type` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `itemTypeId`,
				CHANGE COLUMN `type` `type` ENUM("weapon","shield","armor","projectile") NOT NULL COLLATE "utf8_general_ci" AFTER `name`
		');

		$results[] = query_raw('
			ALTER TABLE `materialAssets`
				CHANGE COLUMN `forceModificator` `forceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `armor`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `materialId`,
				CHANGE COLUMN `additional` `additional` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `materialTypeId`
		');

		$results[] = query_raw('
			ALTER TABLE `materialTypes`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `materialTypes`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `materialTypeId`
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `techniqueId`
		');

		$results[] = query_raw('
			ALTER TABLE `users`
				ALTER `email` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `users`
				CHANGE COLUMN `email` `email` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci" AFTER `password`
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ALTER `name` DROP DEFAULT,
				ALTER `baseHitPointsDiceType` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `userid`,
				CHANGE COLUMN `baseHitPointsDiceType` `baseHitPointsDiceType` ENUM("d6","d20") NOT NULL COLLATE "utf8_bin" AFTER `baseHitPointsDice`,
				CHANGE COLUMN `baseForceModificator` `baseForceModificator` TEXT NOT NULL COLLATE "utf8_bin" AFTER `baseInitiative`,
				CHANGE COLUMN `materialForceModificator` `materialForceModificator` TEXT NOT NULL COLLATE "utf8_bin" AFTER `weight`,
				CHANGE COLUMN `upgradeForceModificator` `upgradeForceModificator` TEXT NOT NULL COLLATE "utf8_bin" AFTER `upgradeInitiative`
		');

		$results[] = query_raw('
			ALTER TABLE `characters`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `characters`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `lastUpdate`
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `craftings`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `characterId`,
				CHANGE COLUMN `notes` `notes` TEXT NOT NULL COLLATE "utf8_bin" AFTER `name`
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				ALTER `name` DROP DEFAULT,
				ALTER `type` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `itemTypes`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `itemTypeId`,
				CHANGE COLUMN `type` `type` ENUM("weapon","shield","armor","projectile") NOT NULL COLLATE "utf8_bin" AFTER `name`
		');

		$results[] = query_raw('
			ALTER TABLE `materialAssets`
				CHANGE COLUMN `forceModificator` `forceModificator` TEXT NOT NULL COLLATE "utf8_bin" AFTER `armor`
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `materials`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `materialId`,
				CHANGE COLUMN `additional` `additional` TEXT NOT NULL COLLATE "utf8_bin" AFTER `materialTypeId`
		');

		$results[] = query_raw('
			ALTER TABLE `materialTypes`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `materialTypes`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `materialTypeId`
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				ALTER `name` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `techniques`
				CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `techniqueId`
		');

		$results[] = query_raw('
			ALTER TABLE `users`
				ALTER `email` DROP DEFAULT
		');

		$results[] = query_raw('
			ALTER TABLE `users`
				CHANGE COLUMN `email` `email` VARCHAR(255) NOT NULL COLLATE "utf8_bin" AFTER `password`
		');

		return !in_array(false, $results);

	}

);