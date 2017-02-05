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
 * Class for the logout page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Logout extends \SmartWork\Page
{
    /**
     * No template used.
     */
    public function __construct()
    {
    }

    /**
     * Destroy the session and redirect to the login page.
     *
     * @return void
     */
    public function process()
    {
        session_destroy();
        redirect('index.php?page=Login');
    }
}
