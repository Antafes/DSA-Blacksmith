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
 * Class for the registration page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Register extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('register');
    }

    /**
     * Process the registration.
     *
     * @return void
     */
    public function process()
    {
        $this->register(
            $_POST['username'], $_POST['password'], $_POST['repeatPassword'], $_POST['email'],
            $_POST['register']
        );
    }

    /**
     * Handle the registration process includign the form salt check.
     *
     * @param string $username
     * @param string $password
     * @param string $repeatPassword
     * @param string $email
     * @param string $salt
     *
     * @return void
     */
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

        if (\SmartWork\User::checkUsername($username))
        {
            $this->template->assign('error', 'usernameAlreadyInUse');
            return;
        }

        if (\SmartWork\User::checkEmail($email))
        {
            $this->template->assign('error', 'emailAlreadyInUse');
            return;
        }

        if (\SmartWork\User::createUser($username, $password, $email))
            $this->template->assign('message', 'registrationSuccessful');
        else
            $this->template->assign('error', 'registrationUnsuccessful');
    }
}
