<?php
namespace Page;

/**
 * Description of Techniques
 *
 * @author Neithan
 */
class Techniques extends \Page
{
	public function __construct()
	{
		parent::__construct('techniques');
	}

	public function process()
	{
		$this->template->loadJs('addTechnique');

		$techniqueListing = \Listing\Techniques::loadList();

		if ($_GET['remove'])
		{
			$this->removeTechnique($techniqueListing->getById($_GET['remove']));
		}

		$this->getTemplate()->assign('techniqueListing', $techniqueListing);
	}

	/**
	 * @param \Model\Technique $technique
	 */
	public function removeTechnique($technique)
	{
		$technique->remove();
		redirect('index.php?page=Techniques');
	}
}
