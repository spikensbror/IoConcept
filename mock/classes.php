<?php

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