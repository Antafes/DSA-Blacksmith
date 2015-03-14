<?php
namespace Page;

/**
 * Description of LostPassword
 *
 * @author Neithan
 */
class LostPassword extends \Page
{
	function __construct()
	{
		parent::__construct('lostPassword');
	}

	public function process()
	{
		if (!$_POST['lostPassword'] || $_POST['lostPassword'] != $_SESSION['formSalts']['lostPassword'])
		{
			return;
		}

		if (!$_POST['email'])
		{
			$this->template->assign('error', 'emptyEmail');
			return;
		}

		$user = \User::getUserByMail($_POST['email']);

		if ($user)
		{
			$user->lostPassword();
			$this->template->assign('message', 'lostPasswordMailSent');
		}
		else
			$this->template->assign('error', 'lostPasswordNoUserFound');
	}
}
