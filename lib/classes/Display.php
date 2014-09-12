<?php
/**
 * Description of EsPage
 *
 * @author Neithan
 */
class Display
{
	protected $unallowedPages = array(
		'Header',
	);

	/**
	 * Display the given page.
	 *
	 * @param string $pageName
	 */
	public function showPage($pageName)
	{
		$pageName = $this->checkPage($pageName);

		// Create the page itself
		$class = '\\Page\\'.$pageName;
		$page = new $class();

		if ($page->getTemplate())
		{
			// Create the page header
			$header = new \Page\Header($page->getTemplate());
			$header->process();
		}

		$page->process();
		$page->render();
	}

	/**
	 * Check if the page is in the list of unallowed pages. If so, return 'Index'.
	 *
	 * @param string $pageName
	 * @return string
	 */
	protected function checkPage($pageName)
	{
		if (in_array($pageName, $this->unallowedPages))
			return 'Index';
		else
			return $pageName;
	}
}
