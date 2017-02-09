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
        $this->getTemplate()->loadJs('jquery.ajaxCheckbox');
        $this->getTemplate()->loadJs('crafting');
        $craftingsList = \Listing\Craftings::loadList();
        $blueprintsList = \Listing\Blueprints::loadList();
        $publicBlueprintsList = \Listing\Blueprints::loadPublicList();
        $user = \User::getUserById($_SESSION['userId']);

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
            case 'getBlueprints':
                $this->getBlueprints($blueprintsList, $user);
                break;
        }

        if ($_GET['remove'])
        {

        }

        $this->getTemplate()->assign(array(
            'blueprints' => $blueprintsList,
            'publicBlueprints' => $publicBlueprintsList,
            'characters' => \Listing\Characters::loadList(),
            'craftings'  => $craftingsList,
            'user'       => $user,
        ));
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

    /**
     * Get a list of blueprints.
     * Used for ajax requests.
     *
     * @param \Listing\Blueprints $blueprintsList
     * @param \User               $user
     *
     * @return void
     */
    protected function getBlueprints(\Listing\Blueprints $blueprintsList, \User $user)
    {
        $this->doRender = false;
        $blueprints = array();

        /* @var $blueprint \Model\Blueprint */
        foreach ($blueprintsList->getList() as $blueprint)
        {
            $blueprints[] = array(
                'id' => $blueprint->getBlueprintId(),
                'name' => $blueprint->getName(),
                'item' => $blueprint->getItem()->getName(),
            );
        }

        if ($user->getShowPublicBlueprints())
        {
            $blueprints['public'] = array();
            $publicBlueprints = \Listing\Blueprints::loadPublicList();
            /* @var $blueprint \Model\Blueprint */
            foreach ($publicBlueprints->getList() as $blueprint)
            {
                $blueprints['public'][] = array(
                    'id' => $blueprint->getBlueprintId(),
                    'name' => $blueprint->getName(),
                    'item' => $blueprint->getItem()->getName(),
                );
            }
        }

        $this->echoAjaxResponse(array(
            'ok' => true,
            'data' => $blueprints,
        ));
    }
}
