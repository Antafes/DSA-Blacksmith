<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Translation tables';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE languages (
				languageId INT UNSIGNED NOT NULL AUTO_INCREMENT,
				language VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				iso2code CHAR(2) NOT NULL COLLATE "utf8_bin",
				deleted TINYINT(1) NOT NULL,
				PRIMARY KEY (`languageId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE translations (
				translationId INT UNSIGNED NOT NULL AUTO_INCREMENT,
				languageId INT UNSIGNED NOT NULL,
				`key` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`value` TEXT NOT NULL COLLATE "utf8_general_ci",
				deleted TINYINT(1) NOT NULL,
				PRIMARY KEY (`translationId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `users` (
				`userId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`password` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`salt` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`email` VARCHAR(255) NOT NULL COLLATE "utf8_bin",
				`active` TINYINT(1) NOT NULL DEFAULT "0",
				`admin` TINYINT(1) NOT NULL DEFAULT "0",
				`deleted` TINYINT(1) NOT NULL,
				PRIMARY KEY (`userId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO `users` (`name`, `password`, `salt`, `email`, `active`, `admin`)
			VALUES ("Admin", "cb2bf6d82e1a5e5eaf78c78e74d8f018", "sdgse5se", "admin@localhost", 1, 1)
		');

		$results[] = query_raw('
			INSERT INTO languages (languageId, language, iso2code)
			VALUES (1, "german", "de"), (2, "english", "en")
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (1, 1, "german", "Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (2, 2, "german", "Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (3, 1, "english", "English", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (4, 2, "english", "English", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (5, 1, "title", "DSA Schmiede", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (6, 2, "title", "DSA Blacksmith", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (7, 1, "index", "Startseite", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (8, 2, "index", "Index", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (9, 1, "materials", "Materialien", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (10, 1, "techniques", "Techniken", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (11, 1, "itemTypes", "Gegenstandstypen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (12, 1, "username", "Benutzername", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (13, 2, "username", "Username", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (14, 1, "password", "Passwort", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (15, 2, "password", "Password", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (16, 1, "login", "Login", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (17, 2, "login", "Login", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (18, 1, "register", "Registrieren", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (19, 2, "register", "Register", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (20, 1, "invalidLogin", "Die eingegebenen Logindaten sind nicht bekannt.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (21, 2, "invalidLogin", "The entered login data are not known.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (22, 1, "emptyLogin", "Bitte fülle alle Felder aus.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (23, 2, "emptyLogin", "Please fill in all fields.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (24, 1, "logout", "Logout", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (25, 2, "logout", "Logout", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (26, 1, "repeatPassword", "Passwort wiederholen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (27, 2, "repeatPassword", "Repeat password", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (28, 1, "registerEmpty", "Bitte fülle alle Felder aus.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (29, 2, "registerEmpty", "Pleas fill in all fields.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (30, 1, "passwordsDontMatch", "Die eingegebenen Passwörter stimmen nicht überein.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (31, 2, "passwordsDontMatch", "The entered passwords don\'t match.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (32, 1, "usernameAlreadyInUse", "Der Benutzername wird bereits verwendet.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (33, 2, "usernameAlreadyInUse", "The username is already in use.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (34, 1, "registrationSuccessful", "Die Registrierung war erfolgreich.<br />Du erhältst eine E-Mail sobald du freigeschalten wurdest.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (35, 2, "registrationSuccessful", "The registration was successful.<br />You will receive an email on activation.", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (36, 1, "admin", "Admin", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (37, 2, "admin", "Admin", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = array();

		$result[] = query_raw('
			DROP TABLE users
		');

		$result[] = query_raw('
			DROP TABLE translations
		');

		$result[] = query_raw('
			DROP TABLE languages
		');

		return !!$result;

	}

);