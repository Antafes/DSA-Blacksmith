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
 * Class for the craftings page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Craftings extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('craftings');
    }

    /**
     * Add javascripts, handle the removing of craftings and show the list of undergoing and done
     * craftings.
     *
     * @return void
     */
    public function process()
    {
        $this->getTemplate()->loadJs('addCrafting');
        $this->getTemplate()->loadJs('jquery.popupBlueprint');
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
        $craftingsList = \Listing\Craftings::loadList();

        if ($_GET['remove'])
        {
            $this->removeCrafting($craftingsList->getById($_GET['remove']));
        }

        $this->getTemplate()->assign('blueprints', \Listing\Blueprints::loadList());
        $this->getTemplate()->assign('characters', \Listing\Characters::loadList());
        $this->getTemplate()->assign('craftings', $craftingsList);
    }

    /**
     * Remove a crafting.
     *
     * @param \Model\Crafting $crafting
     *
     * @return void
     */
    protected function removeCrafting($crafting)
    {
        $crafting->remove();
        redirect('index.php?page=Craftings');
    }
}
