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
 * Class for the materials page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Materials extends \SmartWork\Page
{
    /**
     * Set the used template.
     */
    public function __construct()
    {
        parent::__construct('materials');
    }

    /**
     * Add javascripts, handle removing of materials and show the list of them.
     *
     * @return void
     */
    public function process()
    {
        $this->template->loadJs('material');
        $this->template->loadJs('jquery.materialAsset');
        $this->getTemplate()->loadJs('jquery.ajax');
        $this->getTemplate()->loadJs('removeRow');
        $this->getTemplate()->loadJs('jquery.popupEdit');

        $materialListing = \Listing\Materials::loadList();
        $materialTypeListing = \Listing\MaterialTypes::loadList();

        switch ($_GET['action']) {
            case 'remove':
                $this->removeMaterial($materialListing->getById($_GET['id']));
                break;
            case 'edit':
                $this->editMaterial($_GET['id'], $_POST['data']);
                break;
            case 'get':
                $this->getMaterial($materialListing->getById($_GET['id']));
                break;
        }

        $moneyHelper = new \Helper\Money();
        $this->getTemplate()->assign('materialListing', $materialListing);
        $this->getTemplate()->assign('materialTypeListing', $materialTypeListing);
        $this->getTemplate()->assign('currencyList', json_encode($moneyHelper->getCurrencyList()));
    }

    /**
     * Remove a material.
     *
     * @param \Model\Material $material
     *
     * @return void
     */
    protected function removeMaterial($material)
    {
        $material->remove();
        $this->doRender = false;

        $this->echoAjaxResponse(array('ok' => true));
    }

    /**
     * Get a single material.
     * Used for ajax requests.
     *
     * @param \Model\Material $material
     *
     * @return void
     */
    public function getMaterial($material)
    {
        $this->doRender = false;

        if (empty($material))
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => false,
                    'error' => 'noMaterialFound',
                )
            );
        }
        else
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => true,
                    'data' => $material->getAsArray(),
                )
            );
        }
    }

    /**
     * Create or edit a material.
     *
     * @param integer|string $id   The id of the material entry. May be a string
     *                             if a new material is created. Otherwise it's
     *                             an integer.
     * @param array          $data The data for the material.
     *
     * @return void
     */
    protected function editMaterial($id, $data)
    {
        if ($id == 'new')
        {
            $response = array(
                'ok' => \Model\Material::create($data),
            );
        }
        else
        {
            $material = \Model\Material::loadById($id);
            $response = array(
                'ok' => $material->update($data),
                'data' => $material->getAsArray(),
            );
        }

        $this->echoAjaxResponse($response);
    }
}