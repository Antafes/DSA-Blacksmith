<?php
namespace Page;

/**
 * Description of EsLogout
 *
 * @author Neithan
 */
class Logout extends \Page
{
	public function __construct()
	{
	}

	public function process()
	{
		session_destroy();
		redirect('index.php?page=Login');
	}
}
