<?php

class HashTest extends PHPUnit_Framework_TestCase
{
	public $hash;

	public function setUp()
	{
		$this->hash = new \Cog\Hash(
			array(
				'foo' => 'bar'
			)
		);
	}

	public function testEmptyWithoutData()
	{
		$hash = new \Cog\Hash;
		$this->assertSame(array(), $hash->toArray());
		$this->assertSame(0, $hash->length());
	}

	public function testGet()
	{
		$this->assertSame('bar', $this->hash->get('foo'));
	}

	public function testGetDefault()
	{
		$this->assertNull($this->hash->get('fail'));
		$this->assertFalse($this->hash->get('fail', false));
	}

	public function testSet()
	{
		$this->hash->set('testing', true);
		$this->assertTrue($this->hash->get('testing'));
	}

	public function testSetArray()
	{
		$this->hash->setArray(array('testing' => true, 'fun' => 'yes'));
		$this->assertSame('yes', $this->hash->get('fun'));
	}

	public function testLength()
	{
		$this->assertSame(1, $this->hash->length());
	}

	public function testLengthUpdates()
	{
		$this->hash->set('testing', true);
		$this->assertSame(2, $this->hash->length());
	}

	public function testReplaceData()
	{
		$data = array('new' => 'data');
		$this->hash->replace($data);
		$this->assertSame('data', $this->hash->get('new'));
		$this->assertNull($this->hash->get('foo'));
	}

	public function testToArray()
	{
		$this->assertSame(array('foo' => 'bar'), $this->hash->toArray());
	}

	public function testArrayAccess()
	{
		$this->assertSame('bar', $this->hash['foo']);
	}

	public function testIterator()
	{
		$this->assertInstanceOf('ArrayIterator', $this->hash->getIterator());
	}

}
