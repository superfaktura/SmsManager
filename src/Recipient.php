<?php

namespace Po1nt\SmsManager;

use Po1nt\SmsManager\Exceptions\ValidationException;
use Po1nt\SmsManager\Utils\PhoneNumberUtils;

/**
 * Class for handling message recipient
 * @package Po1nt\SmsManager
 */
class Recipient implements IRecipient {
	
	/** @var string $phoneNumber */
	protected $phoneNumber;
	
	/** @var string locale */
	protected $locale;
	
	/**
	 * Recipient constructor.
	 *
	 * @param string $phoneNumber
	 * @param string|null $locale
	 */
	public function __construct($phoneNumber, $locale = null) {
		$this->locale = $locale;
		$this->setPhoneNumber($phoneNumber);
	}
	
	/**
	 * @param string $locale
	 */
	function setLocale($locale) {
		$this->locale = $locale;
	}
	
	/**
	 * @return string
	 */
	function getLocale() {
		return $this->locale;
	}
	
	/**
	 * @param $number
	 *
	 * @throws \Po1nt\SmsManager\Exceptions\ValidationException
	 */
	function setPhoneNumber($number) {
		$number = PhoneNumberUtils::processPhoneNumber($number, $this->locale);
		if(!PhoneNumberUtils::validatePhoneNumber($number)) {
			throw new ValidationException('Phone number not valid');
		}
			
		$this->phoneNumber = $number;
	}
	
	/**
	 * @return string
	 */
	function getPhoneNumber() {
		return PhoneNumberUtils::processPhoneNumber($this->phoneNumber, $this->locale);
	}
}