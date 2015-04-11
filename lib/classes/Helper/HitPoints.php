<?php
namespace Helper;

/**
 * Description of HitPoints
 *
 * @author Neithan
 */
class HitPoints
{
	public static function getHitPointsString($hitPointsArray)
	{
		$translator = \Translator::getInstance();
		$hitPointsString = $hitPointsArray['hitPointsDice'];
		$hitPointsString .=$translator->getTranslation($hitPointsArray['hitPointsDiceType']);
		$hitPointsString .= sprintf('%+d', $hitPointsArray['hitPoints']);

		if ($hitPointsArray['damageType'] == 'stamina')
		{
			$hitPointsString .= ' ' . $translator->getTranslation('(S)');
		}

		return $hitPointsString;
	}
}
