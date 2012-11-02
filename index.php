<?php

// Setup autoload.
function __autoload($class)
{
	$path = 'class/'.$class.'.php';
	if(!is_file($path)) {
		return false;
	}

	include_once $path;
	return true;
}

// The dependency chain will be as follows:
//                  JSONEncoder
// ModelExample        |
//      |       ViewExample
//      |         |
//      \__  _____/
//         \/
// ControllerExample
// -------------------------------------
// The way it works is basically that ControllerExample uses
// ModelExample to get the data, then uses ViewExample which
// uses JSONEncoder to encode the data to return a representable
// JSON encoded string of the data.
// 
// The final result will be the JSON encoded presentation of:
// array('name' => 'John Smith', 'age' => 30)

// Model Example
// This class has no dependencies.
// This is just an example of a class that will return
// a database result.
class ModelExample
{
	public function getData()
	{
		return array('name' => 'John Smith', 'age' => 30);
	}
}

// JSON Encoder
// This class has no dependencies.
// This is just an example JSON encoder to be used by the view.
class JSONEncoder
{
	public function encode($data)
	{
		return json_encode($data);
	}
}

// View Example
// This class depends on JSONEncoder to format the data.
// This class will format any data fed into it.
class ViewExample
{
	private $_encoder;

	function __construct($encoder)
	{
		$this->_encoder = $encoder;
	}

	public function render($data)
	{
		return $this->_encoder->encode($data);
	}
}

// Controller Example
// This class depends on the ModelExample to get data
// then it will format it using the view and finally return the result.
class ControllerExample
{
	private $_model;
	private $_view;

	function __construct($model, $view)
	{
		$this->_model = $model;
		$this->_view = $view;
	}

	public function process()
	{
		return $this->_view->render($this->_model->getData());
	}
}

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

// Utilize assembler.
echo Assembler::resolve('controllerExample')->process();