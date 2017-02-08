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
        $this->getTemplate()->loadJs('jquery.ajax');
        $this->getTemplate()->loadJs('removeRow');
        $this->getTemplate()->loadJs('jquery.popupBlueprint');
        $this->getTemplate()->loadJs('jquery.addTalentPoints');
        $this->getTemplate()->loadJs('jquery.popupEdit');
        $this->getTemplate()->loadJs('crafting');
        $craftingsList = \Listing\Craftings::loadList();

        switch ($_GET['action']) {
            case 'remove':
                $this->removeCrafting($craftingsList->getById($_GET['remove']));
                break;
            case 'edit':
                $this->editCrafting($_GET['id'], $_POST['data']);
                break;
            case 'get':
                $this->getCrafting($craftingsList->getById($_GET['id']));
                break;
        }

        if ($_GET['remove'])
        {

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

    /**
     * Get a single crafting.
     * Used for ajax requests.
     *
     * @param \Model\Crafting $crafting
     *
     * @return void
     */
    protected function getCrafting(\Model\Crafting $crafting)
    {
        $this->doRender = false;

        if (empty($crafting))
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => false,
                    'error' => 'noCraftingFound',
                )
            );
        }
        else
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => true,
                    'data' => $this->getCraftingData($crafting),
                )
            );
        }
    }

    /**
     * Add or edit a crafting.
     * Used for ajax requests.
     *
     * @param integer/string $id
     * @param array          $data
     *
     * @return void
     */
    protected function editCrafting($id, $data)
    {
        $this->doRender = false;

        if ($id == 'new')
        {
            $response = array(
                'ok' => \Model\Crafting::create(
                    array_merge(array('userId' => $_SESSION['userId']), $data)
                ),
            );
        }
        else
        {
            $crafting = \Model\Crafting::loadById($id);
            $response = array(
                'ok' => $crafting->update($data),
                'data' => $this->getCraftingData($crafting),
            );
        }

        $this->echoAjaxResponse($response);
    }

    /**
     * Prepare the crafting data for the ajax request so it can be shown in the
     * edit popup.
     *
     * @param \Model\Crafting $crafting
     *
     * @return array
     */
    protected function getCraftingData(\Model\Crafting $crafting)
    {
        $craftingArray = $crafting->getAsArray();
        $craftingArray['characterId'] = $crafting->getCharacter()->getCharacterId();
        $craftingArray['blueprintId'] = $crafting->getBlueprint()->getBlueprintId();

        return $craftingArray;
    }
}
