<?php

namespace Po1nt\SmsManager;

/**
 * SMS message class
 * @package Po1nt\SmsManager
 */
class Message implements ISmsManagerMessage {
	
	/** @var int $id */
	protected $id = null;
	
	/** @var IRecipient[] $recipients */
	protected $recipients = [];
	
	/** @var string $text */
	protected $text = null;
	
	/** @var string $senderNumber */
	protected $senderNumber = null;
	
	/** @var \DateTime $expiration */
	protected $expiration = null;
	
	/** @var string $type */
	protected $type = IMessage::TYPE_ECONOMY;
	
	/**
	 * Message constructor.
	 *
	 * @param string $text
	 */
	public function __construct($text = null) {
		if($text !== null)
			$this->setText($text);
	}
	
	/**
	 * @param \Po1nt\SmsManager\IRecipient $recipient
	 */
	function addRecipient($recipient) {
		$this->recipients[] = $recipient;
	}
	
	/**
	 * @param \Po1nt\SmsManager\IRecipient $recipient
	 * @return bool
	 */
	function removeRecipient($recipient) {
		for($i = 0; $i < count($this->recipients); $i++) {
			if($this->recipients[$i] === $recipient) {
				unset($this->recipients[$i]);
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @return \Po1nt\SmsManager\IRecipient[]
	 */
	function getRecipients() {
		return $this->recipients;
	}
	
	/**
	 * @param int $id
	 */
	function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @return int
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * @param string $text
	 */
	function setText($text) {
		$this->text = $text;
	}
	
	/**
	 * @return string
	 */
	function getText() {
		return $this->text;
	}
	
	/**
	 * @param int $number
	 */
	function setSenderNumber($number) {
		$this->senderNumber = $number;
	}
	
	/**
	 * @return string
	 */
	function getSenderNumber() {
		return $this->senderNumber;
	}
	
	/**
	 * @param \DateTime $datetime
	 */
	function setExpiration($datetime) {
		$this->expiration = $datetime;
	}
	
	/**
	 * @return \DateTime
	 */
	function getExpiration() {
		return $this->expiration;
	}
	
	/**
	 * @param $type
	 */
	function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @return string
	 */
	function getType() {
		return $this->type;
	}
}