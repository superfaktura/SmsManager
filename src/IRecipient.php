<?php

namespace Po1nt\SmsManager;
use Po1nt\SmsManager\Exceptions\ValidationException;

/**
 * Recipient for IMessage
 * @package Po1nt\SmsManager
 */
interface IRecipient {
	
	/**
	 * Set phone number of recipient
	 *
	 * @param string
	 *
	 * @return void
	 * @throws ValidationException
	 */
	function setPhoneNumber($number);
	
	/**
	 * Set locale for telephone number 
	 *
	 * @param $locale
	 */
	function setLocale($locale);
	
	/**
	 * @return string
	 */
	function getLocale();
	
	/**
	 * Get phone number of recipient
	 *
	 * @return string
	 */
	function getPhoneNumber();
}