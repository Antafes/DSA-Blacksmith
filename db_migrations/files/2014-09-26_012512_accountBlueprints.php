<?php
/**
 * SQL statements for assigning blueprints to an user account.
 *
 * @package sql
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

$DB_MIGRATION = array(

    'description' => function () {
        return 'Account blueprints';
    },

    'up' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            ALTER TABLE `blueprints`
                ADD COLUMN `userid` INT(10) UNSIGNED NOT NULL AFTER `blueprintId`
        ');

        $results[] = query_raw('
            UPDATE blueprints SET userId = 1
        ');

        $results[] = query_raw('
            ALTER TABLE `blueprints`
                ADD CONSTRAINT `blueprints_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE ON DELETE CASCADE
        ');

        return !in_array(false, $results);

    },

    'down' => function ($migration_metadata) {

        $results = array();

        $results[] = query_raw('
            ALTER TABLE `blueprints`
                DROP COLUMN `userid`,
                DROP INDEX `blueprints_user`,
                DROP FOREIGN KEY `blueprints_user`
        ');

        return !in_array(false, $results);

    }

);