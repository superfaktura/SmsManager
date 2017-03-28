<?php
/**
 * Created by PhpStorm.
 * User: SF1
 * Date: 23.03.2017
 * Time: 14:56
 */

namespace Po1nt\SmsManager;

use Po1nt\SmsManager\Exceptions\ValidationException;

/**
 * Message inheriting interface working specifically for Smsmananger.cz
 * @package Po1nt\SmsManager
 */
interface ISmsManagerMessage extends IMessage {
	
	/**
	 * @param int $number
	 *
	 * @return void
	 * @throws ValidationException
	 */
	function setSenderNumber($number);
	
	/**
	 * @return string|null
	 */
	function getSenderNumber();
	
	/**
	 * @param \DateTime $datetime
	 *
	 * @return void
	 * @throws ValidationException
	 */
	function setExpiration($datetime);
	
	/**
	 * @return \DateTime|null
	 */
	function getExpiration();
	
	/**
	 * Sets type of message
	 *
	 * @param string
	 *
	 * @return void
	 */
	function setType($type);
	
	/**
	 * @return string
	 */
	function getType();
}