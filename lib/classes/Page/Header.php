<?php
namespace Page;

/**
 * Description of EsHeader
 *
 * @author Neithan
 */
class Header extends \Page
{
	/**
	 * @param \Template $template
	 */
	public function __construct($template)
	{
		$this->template = $template;
	}

	public function process()
	{
		// Add CSS files
		$this->template->loadCss('header');
		$this->template->loadCss('common');
		$this->template->loadCss('main');
		$this->template->loadCss('jquery-ui-1.11.0.custom');

		// Add JS files
		$this->template->loadJs('jquery-2.1.1');
		$this->template->loadJs('jquery-ui-1.11.0.custom');
		$this->template->loadJs('jquery.popup');

		// Add the language entries for JavaScripts
		$this->template->assign('translations', json_encode($this->template->getTranslator()->getAsArray()));

		$this->createMenu();
	}

	protected function createMenu()
	{
		if ($_SESSION['userId'])
		{
			$user = \User::getUserById($_SESSION['userId']);
			$this->template->assign('isAdmin', $user->getAdmin());
		}
	}
}
