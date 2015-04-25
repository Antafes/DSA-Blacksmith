<?php
namespace Page;

/**
 * Description of EsHeader
 *
 * @author Neithan
 */
class Header extends \SmartWork\Page\Header
{
	public function process()
	{
		// Add CSS files
		$this->template->loadCss('header');
		$this->template->loadCss('main');

		// Add JS files
		$this->template->loadJs('jquery.popup');

		parent::process();
	}
}