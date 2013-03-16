<?php
require_once '../src/Ltsv.php';

class LtsvTest extends PHPUnit_Framework_TestCase
{
	protected $t;

	public function setUp()
	{
		$this->t = new Ltsv();
	}

	public function test存在しないキーを呼び出したときにnullを返す()
	{
		$this->assertNull($this->t->get('foo'));
	}

	public function test存在するキーを呼び出したときに格納されている値を返す()
	{
		$this->t->set('foo', 'bar');

		$this->assertEquals('bar', $this->t->get('foo'));
	}

	public function testセットしたときにnullを返す()
	{
		$actual = $this->t->set('foo', 'bar');

		$this->assertNull($actual);
	}

	public function test何も格納されていないときdumpすると空文字列を返す()
	{
		$actual = $this->t->dump();

		$this->assertEquals('', $actual);
	}

	public function test1件格納されているときにdumpするとキーバリューを返す()
	{
		$this->t->set('foo', 'hoge');
		$actual = $this->t->dump();

		$this->assertEquals("foo:hoge¥n", $actual);
	}

	public function test2件格納されているときにdumpするとタブ区切りでキーバリューを返す()
	{
		$this->t->set('bar', 'fuga');
		$this->t->set('foo', 'piyo');
		$actual = $this->t->dump();

		$this->assertEquals("bar:fuga¥tfoo:piyo¥n", $actual);
	}

	public function test既に入っている値をリセットすると置き換える以前の値を返す()
	{
		$this->t->set('foo', 'fuga');
		$actual = $this->t->set('foo', 'piyo');

		$this->assertEquals("fuga", $actual);
	}

	public function test2件格納されているときに、１件目をリセットしてdumpすると格納順にキーバリューを返す()
	{
		$this->t->set('foo', 'hoge');
		$this->t->set('bar', 'fuga');
		$this->t->set('foo', 'piyo');
		$actual = $this->t->dump();

		$this->assertEquals("bar:fuga¥tfoo:piyo¥n", $actual);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testキーをnullにして格納するとき例外を投げる()
	{
		$this->t->set(null, 'hoge');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testキーが空文字列のとき例外を投げる()
	{
		$this->t->set('', 'foo');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNull値を格納するとき例外を投げる()
	{
		$this->t->set('foo', null);
	}

	public function test空文字列を格納できる()
	{
		$this->t->set('foo', '');
		$actual = $this->t->get('foo');

		$this->assertEquals('', $actual);
	}

	public function test1件格納して値が空文字列のときdumpしても空文字列である()
	{
		$this->t->set('foo', '');
		$actual = $this->t->dump();

		$this->assertEquals("foo:¥n", $actual);
	}

	public function test2件格納して値が空文字列のときdumpしても空文字列である()
	{
		$this->t->set('foo', '');
		$this->t->set('bar', 'fuga');
		$actual = $this->t->dump();

		$this->assertEquals("foo:¥tbar:fuga¥n", $actual);
	}

	/**
	 * @dataProvider escapeTargetList
	 */
	public function testエスケープ対象の文字列($key, $value, $expected)
	{
		$this->t->set($key, $value);
		$actual = $this->t->get($key);

		$this->assertEquals($expected, $actual);
	}

	public function escapeTargetList()
	{
		return array(
			array('foo', ':', "¥¥:"),
			array('foo', "¥n", "¥¥n"),
			array('foo', "¥t", "¥¥t")
		);
	}
}