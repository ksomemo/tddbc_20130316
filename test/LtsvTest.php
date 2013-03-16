<?php
require_once '../src/Ltsv.php';

class LtsvTest extends PHPUnit_Framework_TestCase
{
	public function test存在しないキーを呼び出したときにnullを返す()
	{
		$t = new Ltsv();

		$this->assertNull($t->get('foo'));
	}

	public function test存在するキーを呼び出したときに格納されている値を返す()
	{
		$t = new Ltsv();
		$t->set('foo', 'bar');

		$this->assertEquals('bar', $t->get('foo'));
	}

	public function testセットしたときにnullを返すこと()
	{
		$t = new Ltsv();
		$actual = $t->set('foo', 'bar');
		$this->assertNull($actual);
	}
}