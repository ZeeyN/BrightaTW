<?php 

/******************************Custom Constants***********************/
defined('DS') 			? null : define('DS'			, DIRECTORY_SEPARATOR);
defined('SITE_ROOT') 	? null : define('SITE_ROOT'		, $_SERVER['DOCUMENT_ROOT'] . DS . 'BrightaTW');
defined('INCLUDES_DIR') ? null : define('INCLUDES_DIR'	, SITE_ROOT . DS . 'includes');
defined('CLASSES_DIR') ? null : define('CLASSES_DIR'	, INCLUDES_DIR . DS . 'classes');

/**************************Requiers*****************************/
require_once(INCLUDES_DIR . DS . 'functions.php');
require_once(INCLUDES_DIR . DS . 'config' . DS . 'config.php');
require_once(CLASSES_DIR . DS . 'database.php');
require_once(CLASSES_DIR . DS . 'session.php');
require_once(CLASSES_DIR . DS . 'dbObject.php');
require_once(CLASSES_DIR . DS . 'user.php');


/***********************Global Vars*****************************/
$database 	= new Database;
$session 	= new Session;
$message	= $session->message(); 