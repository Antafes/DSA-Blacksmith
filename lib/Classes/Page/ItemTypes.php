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
 * Class for the item types page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class ItemTypes extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('itemTypes');
    }

    /**
     * Add javascripts, handle removing if item types and show the list of them.
     *
     * @return void
     */
    public function process()
    {
        $this->template->loadJs('itemType');
        $this->getTemplate()->loadJs('jquery.ajax');
        $this->getTemplate()->loadJs('removeRow');
        $this->getTemplate()->loadJs('jquery.popupEdit');

        $itemTypesListing = \Listing\ItemTypes::loadList();

        switch ($_GET['action']) {
            case 'remove':
                $this->removeItemType($itemTypesListing->getById($_GET['id']));
                break;
            case 'edit':
                $this->editItemType($_GET['id'], $_POST['data']);
                $itemTypesListing->loadList();
                break;
            case 'get':
                $this->getItemType($itemTypesListing->getById($_GET['id']));
                break;
        }

        $this->getTemplate()->assign('itemTypeListing', $itemTypesListing);
    }

    /**
     * Get a single item type.
     * Used for ajax requests.
     *
     * @param \Model\ItemType $itemType
     *
     * @return void
     */
    protected function getItemType($itemType)
    {
        $this->doRender = false;

        if (empty($itemType))
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => false,
                    'error' => 'noItemTypeFound',
                )
            );
        }
        else
        {
            $itemTypeArray = $itemType->getAsArray();
            $this->echoAjaxResponse(
                array(
                    'ok' => true,
                    'data' => $itemTypeArray
                )
            );
        }
    }

    /**
     * Remove an item type.
     *
     * @param \Model\ItemType $itemType
     *
     * @return void
     */
    protected function removeItemType($itemType)
    {
        $itemType->remove();
        $this->doRender = false;

        $this->echoAjaxResponse(array('ok' => true));
    }

    /**
     * Create or edit an item type.
     *
     * @param integer|string $id   The id of the item type entry. May be a string
     *                             if a new item type is created. Otherwise it's
     *                             an integer.
     * @param array          $data The data for the item type.
     *
     * @return void
     */
    protected function editItemType($id, $data)
    {
        if ($id == 'new')
        {
            $response = array(
                'ok' => \Model\ItemType::create($data),
            );
        }
        else
        {
            $itemType = \Model\ItemType::loadById($id);
            $response = array(
                'ok' => $itemType->update($data),
                'data' => $itemType->getAsArray(),
            );
        }

        $this->echoAjaxResponse($response);
    }
}
