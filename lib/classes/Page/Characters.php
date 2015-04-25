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
 * Class for the characters page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Characters extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	public function __construct()
	{
		parent::__construct('characters');
	}

	/**
	 * Process uploaded files and removing of characters, as well as showing of the characters list.
	 *
	 * @return void
	 */
	public function process()
	{
		if ($_FILES['fileupload']) {
			$file = $_FILES['fileupload']['tmp_name'];
			$heroImport = new \Helper\HeroImport(file_get_contents($file));
			if ($heroImport->import())
			{
				redirect('index.php?page=Characters&success=1');
			}
			else
			{
				redirect('index.php?page=Characters&error=1');
			}
		}

		if ($_GET['remove'])
		{
			$this->removeCharacter(\Model\Character::loadById($_GET['remove']));
		}

		$this->getTemplate()->assign('characters', \Listing\Characters::loadList());
	}

	/**
	 * Remove a character.
	 *
	 * @param \Model\Character $character
	 *
	 * @return void
	 */
	protected function removeCharacter($character)
	{
		$character->remove();
		redirect('index.php?page=Characters');
	}
}
