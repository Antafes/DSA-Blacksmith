<?php
/**
 * SQL statements for the first information shown on the index page.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

    'description' => function () {
        return 'Running craftings on the index page';
    },

    'up' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "runningCraftings", "Laufende Herstellungen", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noCraftingRunning", "Aktuell sind keine Herstellungen am laufen.", 0)
        ');

        return !in_array(false, $results);

    },

    'down' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            DELETE FROM `translations`
            WHERE `key` = "runningCraftings"
                OR `key` = "noCraftingRunning"
        ');

        return !in_array(false, $results);

    }

);