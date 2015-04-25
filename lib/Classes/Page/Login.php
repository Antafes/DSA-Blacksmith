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
 * Class for the login page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Login extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	function __construct()
	{
		parent::__construct('login');
	}

	/**
	 * Process the login.
	 *
	 * @return void
	 */
	public function process()
	{
		$this->logIn($_POST['username'], $_POST['password'], $_POST['login']);
	}

	/**
	 * Login process with check for the form salt, existing users and a password check.
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $salt
	 *
	 * @return void
	 */
	protected function logIn($username, $password, $salt)
	{
		if (!$salt || $salt != $_SESSION['formSalts']['login'])
			return;

		if (!$username && !$password)
		{
			$this->template->assign('error', 'emptyLogin');
			return;
		}

		$user = \SmartWork\User::getUser($username, $password);

		if ($user)
		{
			$_SESSION['userId'] = $user->getUserId();
			$translator = \SmartWork\Translator::getInstance();
			$translator->setCurrentLanguage($user->getLanguageId());
			redirect('index.php?page=Index');
		}
		else
			$this->template->assign('error', 'invalidLogin');
	}
}
