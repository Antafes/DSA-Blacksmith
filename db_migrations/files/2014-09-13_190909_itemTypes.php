<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Item types';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `itemtypes` (
				`itemTypeId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`priceFactor` DECIMAL(4,2) NOT NULL,
				`time` DECIMAL(4,2) NOT NULL,
				`deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
				PRIMARY KEY (`itemTypeId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "itemType", "Gegenstandstyp", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "time", "Zeiteinheiten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addItemType", "Gegenstandstyp hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noItemTypesFound", "Keine Gegenstandstypen gefunden", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = query_raw('
			DROP TABLE itemTypes
		');

		return !!$result;

	}

);