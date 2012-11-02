<?php

class Assembler
{
	private static $_buffer;

	public static function add($name, $f)
	{
		// Add the function to the assembler function buffer.
		return (self::$_buffer[$name] = $f);
	}

	public static function get($name)
	{
		// Return the function if it exists, otherwise null.
		return (isset(self::$_buffer[$name])) ? self::$_buffer[$name] : null;
	}

	public static function resolve($name)
	{
		// Get arguments and pop off name.
		$args = func_get_args();
		array_shift($args);

		// Get assembler function and return null if it doesn't exist.
		$f = self::get($name);
		if(!$f) {
			return null;
		}

		// Invoke assembler function and return assembler result.
		return call_user_func_array($f, $args);
	}
}