<?php
class Ltsv
{
	protected $hash = array();

	public function get($key)
	{
		if (isset($this->hash[$key])) {
			return $this->hash[$key];
		}

		return null;
	}

	public function set($key, $value)
	{
		$beforeValue = null;

		if ($key === null || $key === '') {
			throw new InvalidArgumentException();
		}

		if ($value === null) {
			throw new InvalidArgumentException();
		}

		if (isset($this->hash[$key])) {
			$beforeValue = $this->hash[$key];

			unset($this->hash[$key]);
		}

		$this->hash[$key] = str_replace(array(':', "¥n", "¥t"), array("¥¥:", "¥¥n", "¥¥t"), $value);

		return $beforeValue;
	}

	public function dump()
	{
		$return = '';
		foreach($this->hash as $key => $value) {
			$return .= $key . ':' . $value . "¥t";
		}

		return preg_replace("/¥t$/", "¥n", $return);
	}
}