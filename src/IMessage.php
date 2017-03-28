<?php

namespace Po1nt\SmsManager;

use Po1nt\SmsManager\Exceptions\ValidationException;

/**
 * Message for sending
 * @package Po1nt\SmsManager
 */
interface IMessage {
	
	/**
	 * High price level message type
	 * Check pricing at https://www.smsmanager.cz/rozesilani-sms/ceny/
	 */
	const TYPE_HIGH = 'high';
	
	/**
	 * Economy price level message type
	 * Check pricing at https://www.smsmanager.cz/rozesilani-sms/ceny/
	 */
	const TYPE_ECONOMY = 'economy';
	
	/**
	 * Lowcost price level message type
	 * Check pricing at https://www.smsmanager.cz/rozesilani-sms/ceny/
	 */
	const TYPE_LOWCOST = 'lowcost';
	
	/**
	 * Add phone number to list of recipients
	 *
	 * @param IRecipient $recipient
	 *
	 * @return void
	 */
	function addRecipient($recipient);
	
	/**
	 * Removes recipient from recipients list
	 *
	 * @param IRecipient $recipient
	 *
	 * @return true
	 */
	function removeRecipient($recipient);
	
	/**
	 * Returns all recipients
	 *
	 * @return IRecipient[]
	 */
	function getRecipients();
	
	/**
	 * Sets custom identificator of message (Only numbers allowed, must be < 10 000 000 000)
	 *
	 * @param int $id
	 *
	 * @return void
	 * @throws ValidationException
	 */
	function setId($id);
	
	/**
	 * Returns custom identificator of message
	 * Random generated number if not defined else
	 *
	 * @return int|null
	 */
	function getId();
	
	/**
	 * @param string $text
	 *
	 * @return void
	 * @throws ValidationException
	 */
	function setText($text);
	
	/**
	 * @return string|null
	 */
	function getText();
}