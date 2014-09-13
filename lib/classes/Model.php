<?php
/**
 * Description of Model
 *
 * @author Neithan
 */
abstract class Model
{
	public abstract static function loadById($id);

	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	protected function castToType($value)
	{
		if (is_numeric($value))
		{
			if (stripos($value, '.') !== false)
			{
				return floatval($value);
			}
			else
			{
				return intval($value);
			}
		}

		return $value;
	}
}
