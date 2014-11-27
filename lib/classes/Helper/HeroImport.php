<?php
namespace Helper;

/**
 * Import a hero created with the program Heldensoftware
 *
 * @author Neithan
 */
class HeroImport
{
	/**
	 * @var string
	 */
	protected $xml;

	/**
	 * @param string $xml
	 */
	function __construct($xml)
	{
		$this->xml = $xml;
	}

	public function import()
	{
		
	}
}
