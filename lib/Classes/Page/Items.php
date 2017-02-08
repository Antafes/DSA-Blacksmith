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
 * Class for the items page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Items extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('items');
    }

    /**
     * Add javascripts, handle removing of items and show the item list.
     *
     * @return void
     */
    public function process()
    {
        $this->getTemplate()->loadJs('item');
        $this->getTemplate()->loadJs('jquery.ajax');
        $this->getTemplate()->loadJs('removeRow');
        $this->getTemplate()->loadJs('jquery.popupEdit');

        $itemsListing = \Listing\Items::loadList();
        $moneyHelper = new \Helper\Money();

        switch ($_GET['action']) {
            case 'remove':
                $this->removeItem($itemsListing->getById($_GET['id']));
                break;
            case 'edit':
                $this->editItem($_GET['id'], $_POST['data']);
                break;
            case 'get':
                $this->getItem($itemsListing->getById($_GET['id']));
                break;
        }

        $this->assign('itemsListing', $itemsListing);
        $this->assign('currencyList', $moneyHelper->getCurrencyList());
        $this->assign('columsPerItemType', array(
            'meleeWeapon' => array(
                'item' => array(
                    'heading' => 'item',
                    'key' => 'name',
                ),
                'hitPoints' => array(
                    'heading' => 'hp',
                    'key' => 'hitPointsString',
                ),
                'weight' => array(
                    'heading' => 'weight',
                    'key' => 'weight',
                ),
                'breakFactor' => array(
                    'heading' => 'bf',
                    'key' => 'breakFactor',
                ),
                'initiative' => array(
                    'heading' => 'ini',
                    'key' => 'initiative',
                ),
                'price' => array(
                    'heading' => 'price',
                    'key' => 'priceFormatted',
                ),
                'weaponModificator' => array(
                    'heading' => 'wm',
                    'key' => 'weaponModificatorFormatted',
                ),
                'notes' => array(
                    'heading' => 'notes',
                    'key' => 'notes',
                ),
            ),
            'rangedWeapon' => array(
                'item' => array(
                    'heading' => 'item',
                    'key' => 'name',
                ),
                'hitPoints' => array(
                    'heading' => 'hp',
                    'key' => 'hitPointsString',
                ),
                'weight' => array(
                    'heading' => 'weight',
                    'key' => 'weight',
                ),
                'physicalStrengthRequirement' => array(
                    'heading' => 'physicalStrengthRequirement',
                    'key' => 'physicalStrengthRequirement',
                ),
                'price' => array(
                    'heading' => 'price',
                    'key' => 'priceFormatted',
                ),
            ),
            'projectile' => array(
                'item' => array(
                    'heading' => 'item',
                    'key' => 'name',
                ),
                'proofModificator' => array(
                    'heading' => 'proofModificator',
                    'key' => 'proofModificator',
                ),
            ),
        ));
    }

    /**
     * Get a single item.
     * Used for ajax requests.
     *
     * @param \Model\Item $item
     *
     * @return void
     */
    protected function getItem($item)
    {
        $this->doRender = false;

        if (empty($item))
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => false,
                    'error' => 'noItemFound',
                )
            );
        }
        else
        {
            $moneyHelper = new \Helper\Money();
            $itemArray = $item->getAsArray();
            $itemArray['price'] = $moneyHelper->exchange($itemArray['price'], 'K', 'S');
            $itemArray['currency'] = 'S';
            $itemArray['weaponModificator'] = $itemArray['weaponModificatorFormatted'];
            $this->echoAjaxResponse(
                array(
                    'ok' => true,
                    'data' => $itemArray
                )
            );
        }
    }

    /**
     * Remove an item.
     *
     * @param \Model\Item $item
     *
     * @return void
     */
    protected function removeItem($item)
    {
        $item->remove();
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
    protected function editItem($id, $data)
    {
        if ($id == 'new')
        {
            $response = array(
                'ok' => \Model\Item::create($data),
            );
        }
        else
        {
            $item = \Model\Item::loadById($id);
            $response = array(
                'ok' => $item->update($data),
                'data' => $item->getAsArray(),
            );
        }

        $this->echoAjaxResponse($response);
    }
}
