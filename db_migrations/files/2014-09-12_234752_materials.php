<?php
/**
 * SQL statements for the materials page.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

    'description' => function () {
        return 'Materials';
    },

    'up' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            CREATE TABLE `materialTypes` (
                `materialTypeId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
                `deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
                PRIMARY KEY (`materialTypeId`)
            )
            COLLATE="utf8_bin"
            ENGINE=InnoDB
        ');

        $results[] = query_raw('
            CREATE TABLE `materials` (
                `materialId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
                `materialTypeId` INT(10) UNSIGNED NOT NULL,
                `priceFactor` DECIMAL(4,2) NOT NULL,
                `priceWeight` INT(10) UNSIGNED NOT NULL,
                `proof` INT(10) NOT NULL,
                `breakFactor` INT(10) UNSIGNED NOT NULL,
                `armor` INT(10) UNSIGNED NOT NULL,
                `additional` TEXT NOT NULL COLLATE "utf8_bin",
                `deleted` TINYINT(1) NOT NULL DEFAULT "0",
                PRIMARY KEY (`materialId`),
                INDEX `materialType` (`materialTypeId`),
                CONSTRAINT `materialType` FOREIGN KEY (`materialTypeId`) REFERENCES `materialTypes` (`materialTypeId`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE="utf8_bin"
            ENGINE=InnoDB
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "material", "Material", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "materialType", "Art", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "priceFactor", "Preis (Faktor)", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "priceWeight", "Preis (pro Unze)", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "proof", "Probe", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "breakFactor", "Bruchfaktor", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "armor", "Rüstung", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "additional", "zusätzliche Modifikatoren", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noMaterialsFound", "Es wurden keine Materialien gefunden.", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addMaterial", "Material hinzufügen", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "addMaterialType", "Materialart hinzufügen", 0)
        ');

        return !in_array(false, $results);

    },

    'down' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            DROP TABLE materials
        ');

        $results[] = query_raw('
            DROP TABLE materialTypes
        ');

        return !in_array(false, $results);

    }

);