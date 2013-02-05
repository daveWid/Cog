<?php

namespace Cog;

/**
 * Cog Environment variables, which is mainly the $_SERVER variables along with
 * some custom cog variables.
 *
 * @package Cog
 */
class Environment implements \ArrayAccess
{
	/**
	 * @var array  Environment parameters
	 */
	private $params;

	/**
	 * @param array  The environment parameters
	 */
	public function __construct(array $params)
	{
		$scheme = 'http';
		if (array_key_exists('HTTPS', $params) && $params['HTTPS'] !== 'off')
		{
			$scheme .= 's';
		}

		$this->params = array_merge($params, array(
			'cog.version' => array(0, 1, 0),
			'cog.url_scheme' => $scheme,
			'cog.input' => \file_get_contents("php://input"),
			'cog.errors' => \STDERR
		));
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->params;
	}

	/** Implementing ArrayAccess */

	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->params);
	}

	public function offsetGet($offset)
	{
		return $this->params[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->params[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->params[$offset]);
	}
}
