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
 * Class for the page headers
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Header extends \SmartWork\Page\Header
{
    /**
     * Add additional css and javascript files.
     */
    public function process()
    {
        // Add CSS files
        $this->template->loadCss('header');
        $this->template->loadCss('main');

        parent::process();

        // Add JS files
        $this->getTemplate()->loadJs('jquery.basePopup');
        $this->getTemplate()->loadJs('jquery.popup');
    }
}
