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
 * Class for the index page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Index extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('index');
    }

    /**
     * Add javascripts and show the list of undergoing craftings.
     *
     * @return void
     */
    public function process()
    {
        $this->getTemplate()->loadJs('jquery.popupBlueprint');
        $this->getTemplate()->loadJs('jquery.popupEdit');
        $this->getTemplate()->loadJs('crafting');
        $this->getTemplate()->loadJs('jquery.addTalentPoints');
        $craftingsList = \Listing\Craftings::loadList(true);

        $this->getTemplate()->assign('craftings', $craftingsList);
    }
}
