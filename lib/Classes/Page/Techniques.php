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
 * Class for the techniques page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Techniques extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	public function __construct()
	{
		parent::__construct('techniques');
	}

	/**
	 * Add javascripts, handle removing of techniques and show the list of them.
	 *
	 * @return void
	 */
	public function process()
	{
		$this->template->loadJs('technique');
        $this->getTemplate()->loadJs('jquery.ajax');
        $this->getTemplate()->loadJs('removeRow');
        $this->getTemplate()->loadJs('jquery.popupEdit');

		$techniqueListing = \Listing\Techniques::loadList();

        switch ($_GET['action']) {
            case 'remove':
                $this->removeTechnique($techniqueListing->getById($_GET['id']));
                break;
            case 'edit':
                $this->editItem($_GET['id'], $_POST['data']);
                break;
            case 'get':
                $this->getTechnique($techniqueListing->getById($_GET['id']));
                break;
        }

		$this->getTemplate()->assign('techniqueListing', $techniqueListing);
	}

	/**
	 * Remove a technique.
	 *
	 * @param \Model\Technique $technique
	 *
	 * @return void
	 */
	public function removeTechnique($technique)
	{
		$technique->remove();
		$this->doRender = false;

        $this->echoAjaxResponse(array('ok' => true));
	}

    /**
     * Get a single technique.
     * Used for ajax requests.
     *
     * @param \Model\Technique $technique
     *
     * @return void
     */
    public function getTechnique($technique)
    {
        $this->doRender = false;

        if (empty($technique))
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => false,
                    'error' => 'noTechniqueFound',
                )
            );
        }
        else
        {
            $this->echoAjaxResponse(
                array(
                    'ok' => true,
                    'data' => $technique->getAsArray(),
                )
            );
        }
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
                'ok' => \Model\Technique::create($data),
            );
        }
        else
        {
            $technique = \Model\Technique::loadById($id);
            $response = array(
                'ok' => $technique->update($data),
                'data' => $technique->getAsArray(),
            );
        }

        $this->echoAjaxResponse($response);
    }
}
