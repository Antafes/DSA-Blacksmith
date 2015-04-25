<?php
namespace Page;

/**
 * Description of EsLogout
 *
 * @author Neithan
 */
class Logout extends \SmartWork\Page
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
