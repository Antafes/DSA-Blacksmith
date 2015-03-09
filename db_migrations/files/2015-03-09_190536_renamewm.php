<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Rename force modificator';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			UPDATE `translations` SET `key`="weaponModificator", `value`="Waffenmodifikator" WHERE `key`="forceModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="weaponModificatorHelp" WHERE  `key`="forceModificatorHelp"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="baseWeaponModificator", `value`="Grund-Waffenmodifikator" WHERE  `key`="baseForceModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="upgradeWeaponModificator", `value`="Zusätzlicher Waffenmodifikator" WHERE  `key`="upgradeForceModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="wm" WHERE  `key`="fm"
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			UPDATE `translations` SET `key`="forceModificator", `value`="Wuchtmodifikator" WHERE `key`="weaponModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="forceModificatorHelp" WHERE  `key`="weaponModificatorHelp"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="baseForceModificator", `value`="Grund-Wuchtmodifikator" WHERE  `key`="baseWeaponModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="upgradeForceModificator", `value`="Zusätzlicher Wuchtmodifikator" WHERE  `key`="upgradeWeaponModificator"
		');

		$results[] = query_raw('
			UPDATE `translations` SET `key`="fm" WHERE  `key`="wm"
		');

		return !in_array(false, $results);

	}

);