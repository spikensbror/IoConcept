<?php

class AssemblerTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once '../class/Assembler.php';

		$this->fAdd = function($a, $b) {
			return $a + $b;
		};
	}

	public function testAddGet()
	{
		Assembler::add('testCase', $this->fAdd);
		$this->assertEquals($this->fAdd, Assembler::get('testCase'));
	}

	/**
	 * @depends testAddGet
	 */
	public function testResolve()
	{
		Assembler::add('testCase', $this->fAdd);
		$this->assertEquals(10 + 20, Assembler::resolve('testCase', 10, 20));
	}
}