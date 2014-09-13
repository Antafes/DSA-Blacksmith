<?php
/**
 * Description of Listing
 *
 * @author Neithan
 */
abstract class Listing
{
	/**
	 * @var array
	 */
	protected $list = array();

	public abstract static function loadList();

	public function getList()
	{
		return $this->list;
	}

	public function setList($list)
	{
		$this->list = $list;
	}

	public abstract function getById($id);
}
