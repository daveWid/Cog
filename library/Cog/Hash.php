<?php

namespace Cog;

/**
 * The Hash object is and associative array wrapped in helper methods to make
 * it more OO.
 *
 * @package Cog
 */
class Hash implements \ArrayAccess, \Countable, \IteratorAggregate
{
	/**
	 * @var array  The internal data array
	 */
	protected $data;

	/**
	 * @param array $data  Any initial data
	 */
	public function __construct(array $data = array())
	{
		$this->replace($data);
	}

	/**
	 * @param  string $name    The property name to get
	 * @param  mixed  $default The default value if the property isn't found
	 * @return mixed           The property value or default
	 */
	public function get($name, $default = null)
	{
		if ($this->offsetExists($name))
		{
			$default = $this->offsetGet($name);
		}

		return $default;
	}

	/**
	 * @param  string $name   The property name
	 * @param  mixed  $value  The property value
	 * @return \Cog\Hash      $this
	 */
	public function set($key, $value)
	{
		$this->offsetSet($key, $value);
		return $this;
	}

	/**
	 * @param  array $data  The array of data to set.
	 * @return \Cog\Hash    $this
	 */
	public function setArray(array $data)
	{
		foreach ($data as $key => $value)
		{
			$this->set($key, $value);
		}

		return $this;
	}

	/**
	 * Alias for count.
	 *
	 * @return int The number of elements
	 */
	public function length()
	{
		return $this->count();
	}

	/**
	 * @param  array  $data The new data array
	 * @return \Cog\Hash    $this
	 */
	public function replace(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->data;
	}

/** ====================
    ArrayAccess
    ==================== */

	/**
	 * @param  mixed  $offset  The offest name
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return \array_key_exists($offset, $this->data);
	}

	/**
	 * @param  mixed  $offset The offset to find
	 * @return mixed          The offset value
	 */
	public function offsetGet($offset)
	{
		return $this->data[$offset];
	}

	/**
	 * @param  mixed  $offset The property name
	 * @param  mixed  $value  The property value
	 */
	public function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}

	/**
	 * @param  mixed  $offset  The property name
	 */
	public function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}

/** ====================
    Countable
    ==================== */

    /**
     * @return int  The number of elements in the hash
     */
	public function count()
	{
		return \count($this->data);
	}

/** ====================
    IteratorAggregate
    ==================== */

	/**
	 * @return \Traversable
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->data);
	}

}
