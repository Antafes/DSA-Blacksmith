<?php
namespace Page;

/**
 * Description of Options
 *
 * @author Neithan
 */
class Options extends \Page
{
	/**
	 * @var \User
	 */
	protected $user;

	public function __construct()
	{
		parent::__construct('options');

		$this->user = \User::getUserById($_SESSION['userId']);
	}

	/**
	 * Process possibly entered data of the page.
	 */
	public function process()
	{
		if (!$_POST['generalOptions'] && !$_POST['passwordOptions'])
			return;

		if ($_POST['generalOptions'])
		{
			if ($_POST['generalOptions'] != $_SESSION['formSalts']['generalOptions'])
				return;

			$this->changeGeneralOptions($_POST['username'], $_POST['email']);
			return;
		}

		if ($_POST['passwordOptions'])
		{
			if ($_POST['passwordOptions'] != $_SESSION['formSalts']['passwordOptions'])
				return;

			$this->changePassword($_POST['password'], $_POST['repeatPassword']);
			return;
		}
	}

	/**
	 * Render and output the template
	 */
	public function render()
	{
		$this->template->assign('user', $this->user);

		parent::render();
	}

	/**
	 * Change and save general options of the user.
	 *
	 * @param string $username
	 * @param string $email
	 */
	protected function changeGeneralOptions($username, $email)
	{
		if (!$username || !$email)
		{
			$this->template->assign('errorGeneral', 'emptyGeneralOptions');
			return;
		}

		$this->user->setName($username);
		$this->user->setEmail($email);
		$this->template->assign('messageGeneral', 'generalSuccess');
	}

	/**
	 * Change the users password.
	 *
	 * @param string $password
	 * @param string $repeatPassword
	 */
	protected function changePassword($password, $repeatPassword)
	{
		if (!$password || !$repeatPassword)
		{
			$this->template->assign('errorPassword', 'emptyPasswordOptions');
			return;
		}

		if ($password !== $repeatPassword)
		{
			$this->template->assign('errorPassword', 'passwordsDontMatch');
			return;
		}

		$this->user->setPassword($password);
		$this->template->assign('messagePassword', 'passwordSuccess');
	}
}
