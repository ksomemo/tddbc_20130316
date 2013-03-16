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
		$this->hash[$key] = $value;

		return null;
	}
}