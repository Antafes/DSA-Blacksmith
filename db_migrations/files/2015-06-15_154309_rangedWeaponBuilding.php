<?php

$DB_MIGRATION = array(

    'description' => function () {
        return 'ranged weapon building';
    },

    'up' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            ALTER TABLE `blueprints`
                ADD COLUMN `bonusRangedFightValue` INT NOT NULL AFTER `upgradeWeaponModificator`,
                ADD COLUMN `reducePhysicalStrengthRequirement` INT NOT NULL AFTER `bonusRangedFightValue`
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "bonusRangedFightValue", "Erleichterung der FK-Probe", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "reducePhysicalStrengthRequirement", "Verringerte KK-Voraussetzung", 0)
        ');

        return !in_array(false, $results);

    },

    'down' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            ALTER TABLE `blueprints`
                DROP COLUMN `bonusRangedFightValue`,
                DROP COLUMN `reducePhysicalStrengthRequirement`
        ');

        $results[] = query_raw('
            DELETE FROM `translations` WHERE `key` IN ("bonusRangedFightValue", "reducePhysicalStrengthRequirement")
        ');

        return !in_array(false, $results);

    }

);