<?php
namespace Page;

/**
 * Description of EsRegister
 *
 * @author Neithan
 */
class Register extends \Page
{
	public function __construct()
	{
		parent::__construct('register');
	}

	public function process()
	{
		$this->register(
			$_POST['username'], $_POST['password'], $_POST['repeatPassword'], $_POST['email'],
			$_POST['register']
		);
	}

	protected function register($username, $password, $repeatPassword, $email, $salt)
	{
		if (!$salt || $salt != $_SESSION['formSalts']['register'])
			return;

		if (!$username || !$password || !$repeatPassword || !$email)
		{
			$this->template->assign('error', 'registerEmpty');
			return;
		}

		if ($password !== $repeatPassword)
		{
			$this->template->assign('error', 'passwordsDontMatch');
			return;
		}

		if (\User::checkUsername($username))
		{
			$this->template->assign('error', 'usernameAlreadyInUse');
			return;
		}

		if (\User::createUser($username, $password, $email))
			$this->template->assign('message', 'registrationSuccessful');
		else
			$this->template->assign('error', 'registrationUnsuccessful');
	}
}
