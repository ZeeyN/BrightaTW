<?php

function classAutoLoader($class)
{
	$class 	= strtolower($class);
	$path	= "includes/classes/{$class}.php";

	if(is_file($class) and !class_exists($class)){
		require_once($path);
	} else {
		die("This file name {$class}.php was not found");
	}
}
spl_autoload_register('classAutoLoader');


function redirect($location)
{
	header("Location: {$location}");
}
