<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Page;

/**
 * Class for the techniques page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Techniques extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	public function __construct()
	{
		parent::__construct('techniques');
	}

	/**
	 * Add javascripts, handle removing of techniques and show the list of them.
	 *
	 * @return void
	 */
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
	 * Remove a technique.
	 *
	 * @param \Model\Technique $technique
	 *
	 * @return void
	 */
	public function removeTechnique($technique)
	{
		$technique->remove();
		redirect('index.php?page=Techniques');
	}
}
