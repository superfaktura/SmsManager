<?php

namespace Po1nt\SmsManager;

/**
 * Interface IDispatcher for Dispatcher classes
 * @package Po1nt\SmsManager
 */
interface IDispatcher {
	
	const ENV_PRODUCTION = 'https://xml-api.smsmanager.cz/Send';
	
	function setUsername($username);
	
	function getUsername();
	
	function setPassword($password);
	
	function setApiEndpoint($url);
	
	function getApiEndpoint();
	
	function send(IMessage $message);
}