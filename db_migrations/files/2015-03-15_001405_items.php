<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Items';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE `items` (
				`itemId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`price` INT(11) NOT NULL,
				`twoHanded` TINYINT(1) NOT NULL DEFAULT "0",
				`improvisational` TINYINT(1) NOT NULL DEFAULT "0",
				`privileged` TINYINT(1) NOT NULL DEFAULT "0",
				`hitPointsDice` INT(11) NOT NULL,
				`hitPointsDiceType` ENUM("d6","d20") NOT NULL COLLATE "utf8_general_ci",
				`hitPoints` INT(11) NOT NULL,
				`breakFactor` INT(11) NOT NULL,
				`initiative` INT(11) NOT NULL,
				`weaponModificator` TEXT NOT NULL COLLATE "utf8_general_ci",
				`weight` INT(11) NOT NULL,
				`deleted` TINYINT(1) NOT NULL DEFAULT "0",
				PRIMARY KEY (`itemId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Achfawar", 30000, 0, 0, 0, 1, "d6", 4, 4, 0, "[{\"attack\":-1,\"parade\":0}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Amazonensäbel", 18000, 0, 0, 0, 1, "d6", 4, 2, 1, "[{\"attack\":0,\"parade\":0}]", 75, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Andergaster", 35000, 1, 0, 0, 3, "d6", 2, 3, -3, "[{\"attack\":0,\"parade\":-2}]", 220, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Anderthalbhänder", 25000, 1, 0, 0, 1, "d6", 5, 1, 1, "[{\"attack\":0,\"parade\":0}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Arbach", 12000, 0, 0, 0, 1, "d6", 4, 2, 0, "[{\"attack\":0,\"parade\":-1}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Baccanaq", 18000, 0, 0, 0, 1, "d6", 4, 5, -1, "[{\"attack\":0,\"parade\":-2}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Barbarenschwert", 20000, 0, 0, 0, 1, "d6", 5, 4, -1, "[{\"attack\":0,\"parade\":-1}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Barbarenstreitaxt", 15000, 1, 0, 0, 3, "d6", 2, 3, -2, "[{\"attack\":-1,\"parade\":-4}]", 250, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Basiliskenzunge", 7000, 0, 0, 0, 1, "d6", 2, 4, -1, "[{\"attack\":0,\"parade\":-1}]", 25, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Bastardschwert", 20000, 1, 0, 0, 1, "d6", 5, 2, 0, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Beil", 2000, 0, 1, 0, 1, "d6", 3, 5, -1, "[{\"attack\":-1,\"parade\":-2}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Bock", 8000, 0, 0, 0, 1, "d6", 2, 0, -1, "[{\"attack\":0,\"parade\":0}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Borndorn", 4000, 0, 0, 0, 1, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Boronssichel", 40000, 1, 0, 0, 2, "d6", 6, 3, -2, "[{\"attack\":0,\"parade\":-3}]", 160, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Brabakbengel", 10000, 0, 0, 0, 1, "d6", 5, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Breitschwert", 12000, 0, 0, 0, 1, "d6", 4, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Buckler", 4000, 0, 0, 0, 1, "d6", 0, 0, -1, "[{\"attack\":-2,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Buckler, vollmetall", 6000, 0, 0, 0, 1, "d6", 1, -2, -1, "[{\"attack\":-2,\"parade\":0}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Byakka", 9000, 0, 0, 0, 1, "d6", 5, 3, -1, "[{\"attack\":0,\"parade\":-2}]", 130, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Degen", 15000, 0, 0, 0, 1, "d6", 3, 3, 2, "[{\"attack\":0,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Dolch", 2000, 0, 0, 0, 1, "d6", 1, 2, 0, "[{\"attack\":0,\"parade\":-1}]", 20, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Doppelkhunchomer", 25000, 1, 0, 0, 1, "d6", 6, 2, -1, "[{\"attack\":0,\"parade\":-1}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Drachenklaue", 35000, 0, 0, 0, 1, "d6", 2, 0, -1, "[{\"attack\":0,\"parade\":0}]", 200, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Drachentöter", 0, 1, 0, 0, 3, "d6", 5, 3, -3, "[{\"attack\":-2,\"parade\":-4}]", 400, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Drachenzahn", 12000, 0, 0, 0, 1, "d6", 2, 0, 0, "[{\"attack\":0,\"parade\":0}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Dreizack", 5000, 0, 1, 0, 1, "d6", 4, 5, 0, "[{\"attack\":0,\"parade\":-1}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Dreschflegel", 1500, 1, 1, 0, 1, "d6", 3, 6, -2, "[{\"attack\":-2,\"parade\":-3}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Dschadra", 12000, 0, 0, 0, 1, "d6", 5, 6, -1, "[{\"attack\":0,\"parade\":-3}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Eberfänger", 6000, 0, 0, 0, 1, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Echsische Axt", 0, 1, 0, 0, 1, "d6", 5, 3, 0, "[{\"attack\":0,\"parade\":-1}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Echsisches Szepter", 0, 0, 0, 0, 1, "d6", 3, 4, -1, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Efferdbart", 8000, 0, 0, 0, 1, "d6", 4, 3, 0, "[{\"attack\":0,\"parade\":-1}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Entermesser", 5000, 0, 0, 0, 1, "d6", 3, 2, 0, "[{\"attack\":0,\"parade\":0}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Fackel", 50, 0, 1, 0, 1, "d6", 0, 8, -2, "[{\"attack\":-2,\"parade\":-3}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Felsspalter", 30000, 1, 0, 0, 2, "d6", 2, 2, -1, "[{\"attack\":0,\"parade\":-2}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Fleischerbeil", 2000, 0, 1, 0, 1, "d6", 2, 2, -1, "[{\"attack\":-2,\"parade\":-3}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Florett", 18000, 0, 0, 0, 1, "d6", 3, 4, 3, "[{\"attack\":1,\"parade\":-1}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Geißel", 1500, 0, 0, 0, 1, "d6", -1, 5, -1, "[{\"attack\":0,\"parade\":-4}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Glefe", 4500, 1, 0, 0, 1, "d6", 4, 5, -1, "[{\"attack\":0,\"parade\":-2}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Großer Sklaventod", 35000, 1, 0, 0, 2, "d6", 4, 3, -2, "[{\"attack\":0,\"parade\":-2}]", 160, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Gruufhai", 12000, 1, 0, 0, 1, "d6", 6, 3, -2, "[{\"attack\":-1,\"parade\":-3}]", 180, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Hakendolch", 9000, 0, 0, 0, 1, "d6", 1, -2, 0, "[{\"attack\":0,\"parade\":1}]", 50, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Hakenspieß", 7000, 1, 0, 0, 1, "d6", 3, 5, 0, "[{\"attack\":-1,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Haumesser", 4000, 0, 1, 0, 1, "d6", 3, 3, -1, "[{\"attack\":0,\"parade\":-2}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Hellebarde", 7500, 1, 0, 0, 1, "d6", 5, 5, 0, "[{\"attack\":0,\"parade\":-1}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Holzfälleraxt", 8000, 1, 1, 0, 2, "d6", 0, 5, -2, "[{\"attack\":-1,\"parade\":-4}]", 160, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Holzspeer", 1000, 0, 0, 0, 1, "d6", 3, 5, 0, "[{\"attack\":-1,\"parade\":-3}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Jagdmesser", 5000, 0, 0, 0, 1, "d6", 2, 3, -1, "[{\"attack\":0,\"parade\":-2}]", 15, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Jagdspieß", 8000, 1, 0, 0, 1, "d6", 6, 3, -1, "[{\"attack\":0,\"parade\":-1}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Jagdspieß, elfisch", 8000, 1, 0, 0, 1, "d6", 6, 2, -1, "[{\"attack\":0,\"parade\":-1}]", 75, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kampfstab", 4000, 1, 0, 0, 1, "d6", 1, 5, 1, "[{\"attack\":0,\"parade\":0}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kettenstab", 12000, 1, 0, 0, 1, "d6", 2, 2, 2, "[{\"attack\":1,\"parade\":0}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Drei-Glieder-Stab", 18000, 0, 0, 0, 1, "d6", 2, 3, 2, "[{\"attack\":1,\"parade\":1}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Keule", 1500, 0, 0, 0, 1, "d6", 2, 3, 0, "[{\"attack\":0,\"parade\":-2}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Khunchomer", 13000, 0, 0, 0, 1, "d6", 4, 2, 0, "[{\"attack\":0,\"parade\":0}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Knochenkeule, klein", 0, 0, 0, 0, 1, "d6", 2, 4, 0, "[{\"attack\":-1,\"parade\":-1}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Knochenkeule, mittel", 0, 0, 0, 0, 1, "d6", 3, 3, 0, "[{\"attack\":0,\"parade\":-1}]", 110, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Knochenkeule, groß", 0, 1, 0, 0, 2, "d6", 2, 2, -2, "[{\"attack\":-1,\"parade\":-3}]", 220, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Knüppel", 100, 0, 0, 0, 1, "d6", 1, 6, 0, "[{\"attack\":0,\"parade\":-2}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Korspieß", 20000, 1, 0, 1, 2, "d6", 2, 3, 0, "[{\"attack\":0,\"parade\":-1}]", 140, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kriegsfächer", 25000, 0, 0, 0, 1, "d6", 2, 3, 0, "[{\"attack\":0,\"parade\":1}]", 50, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kriegsflegel", 5000, 1, 0, 0, 1, "d6", 6, 5, -1, "[{\"attack\":-1,\"parade\":-2}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kriegshammer", 12000, 1, 0, 0, 2, "d6", 3, 2, -2, "[{\"attack\":-1,\"parade\":-3}]", 180, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kriegslanze", 12000, 1, 1, 0, 1, "d6", 2, 5, -2, "[{\"attack\":-2,\"parade\":-4}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kurzschwert", 8000, 0, 0, 0, 1, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Kusliker Säbel", 16000, 0, 0, 0, 1, "d6", 3, 1, 1, "[{\"attack\":0,\"parade\":0}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Langdolch", 4500, 0, 0, 0, 1, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":0}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Lindwurmschläger", 12000, 0, 0, 0, 1, "d6", 4, 1, -1, "[{\"attack\":0,\"parade\":-1}]", 95, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Linkhand", 9000, 0, 0, 0, 1, "d6", 1, 0, 0, "[{\"attack\":0,\"parade\":1}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierdegen", 15000, 0, 0, 0, 1, "d6", 2, 4, 1, "[{\"attack\":0,\"parade\":-2}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierrapier", 20000, 0, 0, 1, 1, "d6", 3, 4, 1, "[{\"attack\":0,\"parade\":-1}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierstab", 0, 1, 0, 1, 1, "d6", 1, 0, 0, "[{\"attack\":-1,\"parade\":-1}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierstab mit Kristallkugel", 0, 1, 0, 1, 1, "d6", 1, 0, -2, "[{\"attack\":-1,\"parade\":-2}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierstab, kurz", 0, 0, 0, 1, 1, "d6", 0, 0, 0, "[{\"attack\":-1,\"parade\":-1}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Magierstab, sehr kurz", 0, 0, 0, 1, 1, "d6", -1, 0, -1, "[{\"attack\":-1,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Mengbilar", 20000, 0, 0, 0, 1, "d6", 1, 7, -2, "[{\"attack\":0,\"parade\":-3}]", 20, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Menschenfänger", 20000, 1, 0, 0, 0, "d6", 0, 4, -2, "[{\"attack\":-4,\"parade\":-3}]", 200, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Messer", 1000, 0, 0, 0, 1, "d6", 0, 4, -2, "[{\"attack\":-2,\"parade\":-3}]", 10, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Molokdeschnaja", 9000, 0, 0, 0, 1, "d6", 4, 3, 0, "[{\"attack\":0,\"parade\":0}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Morgenstern", 10000, 0, 0, 0, 1, "d6", 5, 2, -1, "[{\"attack\":-1,\"parade\":-2}]", 140, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Nachtwind", 50000, 1, 0, 0, 1, "d6", 4, 0, 2, "[{\"attack\":0,\"parade\":0}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Neethaner Langaxt", 16000, 1, 0, 0, 2, "d6", 2, 5, -2, "[{\"attack\":-1,\"parade\":-3}]", 160, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Neunschwänzige", 6000, 0, 0, 0, 1, "d6", 1, 5, -1, "[{\"attack\":-1,\"parade\":-4}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Ochsenherde", 25000, 0, 0, 0, 3, "d6", 3, 3, -3, "[{\"attack\":-2,\"parade\":-4}]", 300, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Ogerfänger", 15000, 0, 0, 0, 1, "d6", 2, 4, 0, "[{\"attack\":0,\"parade\":-2}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Ogerschelle", 18000, 0, 0, 0, 2, "d6", 2, 3, -2, "[{\"attack\":-1,\"parade\":-3}]", 240, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Orchidee", 18000, 0, 0, 0, 1, "d6", 1, 3, 0, "[{\"attack\":-1,\"parade\":-2}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Orknase", 7500, 1, 0, 0, 1, "d6", 5, 4, -1, "[{\"attack\":0,\"parade\":-1}]", 110, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Pailos", 30000, 1, 0, 0, 2, "d6", 4, 3, -2, "[{\"attack\":-1,\"parade\":-3}]", 180, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Panzerarm", 14000, 0, 0, 0, 1, "d6", 2, -2, -1, "[{\"attack\":0,\"parade\":0}]", 220, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Panzerstecher", 12000, 0, 0, 0, 1, "d6", 4, 0, 0, "[{\"attack\":-1,\"parade\":-1}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Partisane", 8000, 1, 0, 0, 1, "d6", 5, 4, 0, "[{\"attack\":0,\"parade\":-2}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Peitsche", 2500, 0, 0, 0, 1, "d6", 0, 4, 0, "[{\"attack\":0,\"parade\":0}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Pike", 5000, 1, 0, 0, 1, "d6", 5, 6, -2, "[{\"attack\":-1,\"parade\":-2}]", 180, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Rabenschnabel", 13000, 0, 0, 0, 1, "d6", 4, 3, 0, "[{\"attack\":0,\"parade\":0}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Rapier", 12000, 0, 0, 0, 1, "d6", 3, 2, 1, "[{\"attack\":0,\"parade\":0}]", 45, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Reißer", 0, 0, 0, 0, 2, "d6", 4, 4, 0, "[{\"attack\":0,\"parade\":-2}]", 110, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Richtschwert", 0, 1, 1, 1, 3, "d6", 4, 5, -3, "[{\"attack\":-2,\"parade\":-4}]", 200, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Robbentöter", 20000, 0, 0, 0, 1, "d6", 3, 2, 0, "[{\"attack\":0,\"parade\":0}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Rondrakamm", 0, 1, 0, 1, 2, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":0}]", 130, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Runaskraja", 12000, 0, 0, 1, 1, "d6", 3, 4, 0, "[{\"attack\":0,\"parade\":0}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Säbel", 10000, 0, 0, 0, 1, "d6", 3, 2, 1, "[{\"attack\":0,\"parade\":0}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sägefischschwert", 0, 0, 0, 0, 1, "d6", 2, 5, -1, "[{\"attack\":-2,\"parade\":1}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Scheibendolch", 6000, 0, 0, 0, 1, "d6", 2, 0, 0, "[{\"attack\":0,\"parade\":-3}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Schlagring", 2500, 0, 0, 0, 1, "d6", 2, 0, 0, "[{\"attack\":-1,\"parade\":-2}]", 20, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Schmiedehammer", 0, 0, 0, 1, 1, "d6", 4, 1, -1, "[{\"attack\":-1,\"parade\":-1}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Schnitter", 12000, 1, 0, 0, 1, "d6", 5, 4, 0, "[{\"attack\":0,\"parade\":0}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Schwerer Dolch", 4000, 0, 0, 0, 1, "d6", 2, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Schwert", 18000, 0, 0, 0, 1, "d6", 4, 1, 0, "[{\"attack\":0,\"parade\":0}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sense", 3000, 1, 1, 0, 1, "d6", 3, 7, -2, "[{\"attack\":-2,\"parade\":-4}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sichel", 2500, 0, 1, 0, 1, "d6", 2, 6, -2, "[{\"attack\":-2,\"parade\":-2}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sklaventod", 25000, 0, 0, 0, 1, "d6", 4, 3, 0, "[{\"attack\":0,\"parade\":0}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Skraja", 5000, 0, 0, 0, 1, "d6", 3, 4, 0, "[{\"attack\":0,\"parade\":0}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sonnenszepter", 0, 0, 0, 1, 1, "d6", 3, 1, 0, "[{\"attack\":-1,\"parade\":-1}]", 90, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Speer", 3000, 1, 0, 0, 1, "d6", 5, 5, -1, "[{\"attack\":0,\"parade\":-2}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Spitzhacke", 2000, 1, 1, 0, 1, "d6", 6, 5, -3, "[{\"attack\":-2,\"parade\":-4}]", 200, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Stockdegen", 18000, 0, 0, 0, 1, "d6", 3, 4, 0, "[{\"attack\":-1,\"parade\":-3}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Stoßspeer", 10000, 1, 0, 0, 2, "d6", 2, 3, -1, "[{\"attack\":0,\"parade\":-1}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Streitaxt", 5000, 0, 0, 0, 1, "d6", 4, 2, 0, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Streitkolben", 5000, 0, 0, 0, 1, "d6", 4, 1, 0, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Stuhlbein", 0, 0, 1, 0, 1, "d6", 0, 8, -1, "[{\"attack\":-1,\"parade\":-1}]", 40, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Sturmsense", 48000, 1, 0, 0, 1, "d6", 4, 5, -1, "[{\"attack\":-1,\"parade\":-2}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Turnierlanze", 5000, 1, 1, 0, 1, "d6", 2, 8, -2, "[{\"attack\":-2,\"parade\":-4}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Turnierschwert", 8000, 0, 0, 0, 1, "d6", 3, 3, 0, "[{\"attack\":0,\"parade\":0}]", 60, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Tuzakmesser", 40000, 1, 0, 0, 1, "d6", 6, 1, 1, "[{\"attack\":0,\"parade\":0}]", 100, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Veteranenhand", 25000, 0, 0, 0, 1, "d6", 2, 4, -1, "[{\"attack\":0,\"parade\":-1}]", 70, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Vorschlaghammer", 3000, 1, 1, 0, 1, "d6", 5, 5, -3, "[{\"attack\":-2,\"parade\":-4}]", 250, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Vulkanglasdolch", 0, 0, 1, 0, 1, "d6", -1, 6, -2, "[{\"attack\":-2,\"parade\":-3}]", 30, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Waqqif", 6000, 0, 0, 0, 1, "d6", 2, 2, -2, "[{\"attack\":-1,\"parade\":-3}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Warunker Hammer", 15000, 1, 0, 0, 1, "d6", 6, 2, -1, "[{\"attack\":0,\"parade\":-1}]", 150, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wolfsmesser", 25000, 0, 0, 0, 1, "d6", 3, 1, 1, "[{\"attack\":0,\"parade\":0}]", 50, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurfbeil", 3500, 0, 1, 0, 1, "d6", 3, 2, -1, "[{\"attack\":0,\"parade\":-2}]", 50, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurfdolch", 3000, 0, 1, 0, 1, "d6", 1, 2, -1, "[{\"attack\":-1,\"parade\":-2}]", 20, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurfkeule", 1800, 0, 1, 0, 1, "d6", 2, 3, -1, "[{\"attack\":-1,\"parade\":-1}]", 35, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurfmesser", 1500, 0, 1, 0, 1, "d6", -1, 2, -2, "[{\"attack\":-2,\"parade\":-3}]", 10, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurfspeer", 3000, 0, 1, 0, 1, "d6", 3, 4, -2, "[{\"attack\":-1,\"parade\":-3}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Wurmspieß", 12000, 1, 0, 0, 1, "d6", 5, 2, 0, "[{\"attack\":0,\"parade\":-2}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Zweihänder", 25000, 1, 0, 1, 2, "d6", 4, 2, -1, "[{\"attack\":0,\"parade\":-1}]", 160, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Zweililien", 20000, 1, 0, 0, 1, "d6", 3, 4, 1, "[{\"attack\":1,\"parade\":-1}]", 80, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Zwergenschlägel", 15000, 1, 0, 0, 1, "d6", 5, 1, -1, "[{\"attack\":0,\"parade\":-1}]", 120, 0)
		');

		$results[] = query_raw('
			INSERT INTO `items` (`name`, `price`, `twoHanded`, `improvisational`, `privileged`, `hitPointsDice`, `hitPointsDiceType`, `hitPoints`, `breakFactor`, `initiative`, `weaponModificator`, `weight`, `deleted`) VALUES ("Zwergenskraja", 10000, 0, 0, 0, 1, "d6", 3, 1, 0, "[{\"attack\":0,\"parade\":0}]", 80, 0)
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ADD COLUMN `itemId` INT(10) UNSIGNED NOT NULL AFTER `name`,
				DROP COLUMN `basePrice`,
				DROP COLUMN `twoHanded`,
				DROP COLUMN `improvisational`,
				DROP COLUMN `baseHitPointsDice`,
				DROP COLUMN `baseHitPointsDiceType`,
				DROP COLUMN `baseHitPoints`,
				DROP COLUMN `baseBreakFactor`,
				DROP COLUMN `baseInitiative`,
				DROP COLUMN `baseForceModificator`,
				DROP COLUMN `weight`
		');

		$results[] = query_raw('
			UPDATE blueprints, items
			SET blueprints.itemId = items.itemId
			WHERE blueprints.name LIKE CONCAT("%", items.name, "%")
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ADD CONSTRAINT `blueprints_item` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON UPDATE CASCADE ON DELETE CASCADE
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "item", "Gegenstand", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "items", "Gegenstände", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addItem", "Gegenstand hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noItemsFound", "Es wurden keine Gegenstände gefunden.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "initiative", "Initiative", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "privileged", "Privilegiert", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				ADD COLUMN `basePrice` INT(10) NOT NULL AFTER `itemTypeId`,
				ADD COLUMN `twoHanded` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `basePrice`,
				ADD COLUMN `improvisational` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `twoHanded`,
				ADD COLUMN `baseHitPointsDice` INT NOT NULL AFTER `improvisational`,
				ADD COLUMN `baseHitPointsDiceType` ENUM("d6","d20") NOT NULL COLLATE "utf8_general_ci" AFTER `baseHitPointsDice`,
				ADD COLUMN `baseHitPoints` INT NOT NULL AFTER `baseHitPointsDiceType`,
				ADD COLUMN `baseBreakFactor` INT NOT NULL AFTER `baseHitPoints`,
				ADD COLUMN `baseInitiative` INT NOT NULL AFTER `baseBreakFactor`,
				ADD COLUMN `baseForceModificator` TEXT NOT NULL COLLATE "utf8_general_ci" AFTER `baseInitiative`,
				ADD COLUMN `weight` INT NOT NULL AFTER `baseForceModificator`
		');

		$results[] = query_raw('
			UPDATE blueprints, items
			SET blueprints.basePrice = items.price,
				blueprints.twoHanded = items.twoHanded,
				blueprints.improvisational = items.improvisational,
				blueprints.baseHitPointsDice = items.hitPointsDice,
				blueprints.baseHitPointsDiceType = items.hitPointsDiceType,
				blueprints.baseHitPoints = items.hitPoints,
				blueprints.baseBreakFactor = items.breakFactor,
				blueprints.baseInitiative = items.initiative,
				blueprints.baseForceModificator = items.weaponModificator,
				blueprints.weight = items.weight
			WHERE blueprints.itemId = items.itemId
		');

		$results[] = query_raw('
			ALTER TABLE `blueprints`
				DROP COLUMN `itemId`,
				DROP FOREIGN KEY `blueprints_item`
		');

		$results[] = query_raw('
			DROP TABLE `items`
		');

		$results[] = query_raw('
			DELETE FROM translations
			WHERE `key` = "item"
				OR `key` = "items"
				OR `key` = "addItem"
				OR `key` = "noItemsFound"
				OR `key` = "initiative"
				OR `key` = "privileged"
		');

		return !in_array(false, $results);

	}

);