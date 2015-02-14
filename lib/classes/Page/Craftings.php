<?php
namespace Page;
/**
 * Description of Craftings
 *
 * @author Neithan
 */
class Craftings extends \Page
{
	public function __construct()
	{
		parent::__construct('craftings');
	}

	public function process()
	{
		$this->getTemplate()->loadJs('addCrafting');
		$this->getTemplate()->loadJs('jquery.blueprint');
		$this->getTemplate()->loadJs('showCrafting');
		$this->getTemplate()->loadJs('addTalentPoints');

		$this->getTemplate()->assign('blueprints', \Listing\Blueprints::loadList());
		$this->getTemplate()->assign('characters', \Listing\Characters::loadList());
		$this->getTemplate()->assign('craftings', \Listing\Craftings::loadList());
	}

}
