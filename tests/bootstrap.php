<?php
ini_set('display_errors', 1);
define('DIR_ROOT', __DIR__ . '/..');
define('DIR_VENDOR', DIR_ROOT . '/vendor');
define('DIR_SRC', DIR_ROOT . '/src');

$GLOBALS['test_api_params'] = [
	'username',
	'password'
];

@include('conf.php');

/** @noinspection PhpIncludeInspection */
require_once DIR_VENDOR . "/autoload.php";