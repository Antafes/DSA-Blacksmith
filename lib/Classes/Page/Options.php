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
 * Class for the options page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Options extends \SmartWork\Page
{
    /**
     * @var \SmartWork\User
     */
    protected $user;

    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('options');

        $this->user = \SmartWork\User::getUserById($_SESSION['userId']);
    }

    /**
     * Process possibly entered data of the page.
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
