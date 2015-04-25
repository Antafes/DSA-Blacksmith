<?php
namespace Page;

/**
 * Description of Characters
 *
 * @author Neithan
 */
class Characters extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('characters');
	}

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
	 * @param \Model\Character $character
	 */
	protected function removeCharacter($character)
	{
		$character->remove();
		redirect('index.php?page=Characters');
	}
}
