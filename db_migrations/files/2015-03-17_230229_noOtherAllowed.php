<?php
/**
 * SQL statements for the no other technique allowed translations.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

    'description' => function () {
        return 'Check for no other allowed flag on techniques';
    },

    'up' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "noOtherAllowedInfo", "<p>Es können keine anderen Techniken mit der ausgewählten Technik kombiniert werden.</p>\r\n<p>Sollen alle anderen Techniken aus der Liste entfernt werden?</p>", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "ok", "Ok", 0)
        ');

        $results[] = query_raw('
            INSERT INTO `translations` (`languageId`, `key`, `value`, `deleted`) VALUES (1, "cancel", "Abbrechen", 0)
        ');

        return !in_array(false, $results);

    },

    'down' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            DELETE FROM translations
            WHERE `key` = "noOtherAllowedInfo"
                OR `key` = "ok"
                OR `key` = "cancel"
        ');

        return !in_array(false, $results);

    }

);