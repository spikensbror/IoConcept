<?php

// Add assembler for ModelExample:
Assembler::add('model', function()
{
	// This is essentially making the class a singleton.
	// Only this static instance will be distributed among
	// the dependent objects.
	static $buffer;
	if(!$buffer) {
		$buffer = new ModelExample();
	}

	return $buffer;
});

// Add assembler for JSONEncoder:
Assembler::add('jsonEncoder', function()
{
	// This should not be singleton so just return a new instance.
	return new JSONEncoder();
});

// Add assembler for ViewExample:
Assembler::add('view', function()
{
	return new ViewExample(Assembler::resolve('jsonEncoder'));
});

// Add assembler for ControllerExample:
Assembler::add('controllerExample', function()
{
	return new ControllerExample(
		Assembler::resolve('model'),
		Assembler::resolve('view')
	);
});