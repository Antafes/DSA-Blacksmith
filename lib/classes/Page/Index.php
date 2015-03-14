<?php
namespace Page;

/**
 * Description of Index
 *
 * @author Neithan
 */
class Index extends \Page
{
	public function __construct()
	{
		parent::__construct('index');
	}

	public function process()
	{
		$this->getTemplate()->loadJs('jquery.blueprint');
		$this->getTemplate()->loadJs('showCrafting');
		$this->getTemplate()->loadJs('addTalentPoints');
		$craftingsList = \Listing\Craftings::loadList(true);

		$this->getTemplate()->assign('craftings', $craftingsList);
	}
}
