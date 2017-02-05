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
 * Class for the lost password page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class LostPassword extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    function __construct()
    {
        parent::__construct('lostPassword');
    }

    /**
     * Show the lost password form and init the lost password process.
     *
     * @return void
     */
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

        $user = \SmartWork\User::getUserByMail($_POST['email']);

        if ($user)
        {
            $user->lostPassword();
            $this->template->assign('message', 'lostPasswordMailSent');
        }
        else
            $this->template->assign('error', 'lostPasswordNoUserFound');
    }
}
