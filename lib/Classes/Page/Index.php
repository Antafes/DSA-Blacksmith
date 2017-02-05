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
        $this->getTemplate()->loadJs('jquery.blueprint');
        $this->getTemplate()->loadJs('showCrafting');
        $this->getTemplate()->loadJs('jquery.addTalentPoints');
        $this->getTemplate()->loadJsReadyScript('
            $(document).tooltip({
                content: function () {
                    $(this).addClass("tooltip");
                    return $(this).attr("title").replace(/(?:\r\n|\r|\n)/g, "<br />");
                }
            });
            $(".addTalentPoints").addTalentPoints();
        ');
        $craftingsList = \Listing\Craftings::loadList(true);

        $this->getTemplate()->assign('craftings', $craftingsList);
    }
}
