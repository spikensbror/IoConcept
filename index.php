<?php

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

// Require assembler.
require_once 'class/Assembler.php';

// Require mocks.
require_once 'mock/assemblers.php';
require_once 'mock/classes.php';

// Utilize assembler.
echo Assembler::resolve('controllerExample')->process();