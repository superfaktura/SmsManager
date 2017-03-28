<?php

namespace Po1nt\SmsManager\Utils;

use Po1nt\SmsManager\Exceptions\ValidationException;

/**
 * Basic utilility class for working with phone numbers
 * @package Po1nt\Utils
 */
final class PhoneNumberUtils {
	
	/**
	 * Private PhoneNumberUtils constructor to make non-instanciable static class
	 */
	private function __construct() {}
	
	/**
	 * @param string $number
	 * @param string $locale
	 *
	 * @return string
	 * @throws ValidationException
	 */
	public static function processPhoneNumber($number, $locale = null) {
		// Let's try to replace invalid characters
		$number = preg_replace('/[^\+\d]/', '', $number);
		
		// If number is in locale 09** *** *** format, replace it to international
		if($locale !== null) {
			if(preg_match('/^0?9/', $number)) { // Starts with 09xx xxx xxx or 9xx xxx xxx
				/** @var string $localeNumber */
				$localeNumber = '';
				switch($locale) {
					case 'sk':
						$localeNumber = '421';
						break;
					case 'cz':
						$localeNumber = '420';
						break;
				}
				$number = preg_replace('/^0?9/', $localeNumber, $number);
			} else if(preg_match('/^(?:00|\+)\d{11}$/', $number)) { // Starts with 00xxx xxx xxx xxx or +xxx xxx xxx xxx
				/** @var string $localeNumber */
				$localeNumber = '';
				switch($locale) {
					case 'sk':
						$localeNumber = '421';
						break;
					case 'cz':
						$localeNumber = '420';
						break;
				}
				$number = preg_replace('/^(?:00|\+)?\d{3}/', $localeNumber, $number);
			}
		}
		
		return $number;
	}
	
	/**
	 * @param $number
	 * @return bool
	 */
	public static function validatePhoneNumber($number) {
		return preg_match('/^(?:00|\+)?\d+/', $number);
	}
}