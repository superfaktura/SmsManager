<?php

namespace Po1nt\SmsManager;

use Po1nt\SmsManager\Exceptions\InsufficientDataException;
use Po1nt\SmsManager\Exceptions\ServerException;

/**
 * Class Dispatcher
 * @package Po1nt\SmsManager
 */
class Dispatcher implements IDispatcher {
	
	const TEST_USER = 'user@user.com';
	const TEST_PASSHASH = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
	
	/** @var string $username */
	protected $username;
	
	/** @var string $passwordHash */
	protected $passwordHash;
	
	/** @var string $apiEndpoint */
	protected $apiEndpoint = IDispatcher::ENV_PRODUCTION;
	
	/** @var bool $testMode */
	public $testMode = false;
	
	/**
	 * Dispatcher constructor.
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password) {
		$this->setUsername($username);
		$this->setPassword($password);
 	}
	
	/**
	 * @param $username
	 */
	function setUsername($username) {
		$this->username = $username;
	}
	
	/**
	 * @return string
	 */
	function getUsername() {
		return $this->username;
	}
	
	/**
	 * @param $password
	 */
	function setPassword($password) {
		$this->passwordHash = sha1($password); // We don't want to hold raw password
	}
	
	/**
	 * @param $url
	 */
	function setApiEndpoint($url) {
		$this->apiEndpoint = $url;
	}
	
	/**
	 * @return string
	 */
	function getApiEndpoint() {
		return $this->apiEndpoint;
	}
	
	/**
	 * Generates Xml from current data
	 *
	 * @param Message $message
	 * @return \SimpleXmlElement
	 * @throws InsufficientDataException
	 */
	protected function generateXml($message) {
		$xml = new \SimpleXMLElement('<RequestDocument />');
		
		$header = $xml->addChild('RequestHeader');
		$header->addChild('Username', $this->username);
		$header->addChild('Password', $this->passwordHash);
		
		$requestList = $xml->addChild('RequestList');
		
		if(count($message->getRecipients()) < 1)
			throw new InsufficientDataException('Recipients are empty');
		
		foreach($message->getRecipients() as $recipient) {
			$request = $requestList->addChild('Request');
			
			if($message->getType())
				$request->addAttribute('Type', $message->getType());
			
			if($message->getId())
				$request->addAttribute('CustomID', $message->getId());
			
			if(empty($message->getText()))
				throw new InsufficientDataException('The message is empty');
			
			$msg = $request->addChild('Message', $message->getText());
			$msg->addAttribute('Type', 'Text');
			
			$nlist = $request->addChild('NumbersList');
			$nlist->addChild('Number', $recipient->getPhoneNumber());
		}
		
		return $xml;
	}
	
	/**
	 * @param $message
	 * @return string
	 *
	 * @throws ServerException
	 */
	function send($message) {
		$xml = $this->generateXml($message);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getApiEndpoint());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('XMLDATA' => $xml->asXML())));
		
		try {
			$output = curl_exec($ch);
		} catch(\Exception $e) {
			throw new ServerException('Connection error');
		} finally {
			curl_close($ch);
		}
		
		/** @var \SimpleXMLElement|\stdClass $result */
		$result = null;
		try {
			$result =  new \SimpleXMLElement($output);
		} catch(\Exception $e) {
			throw new ServerException('Couldn\'t parse server response');
		}
		
		try {
			/** @var \SimpleXMLElement $res_el */
			$res_el = $result->Response;
			/** @var array $res_attrs */
			$res_attrs = $res_el->attributes();
		} catch(\Exception $e) {
			throw new ServerException('Bad response format');
		}
		
		if($res_attrs['Type'] == 'ERROR') {
			throw new ServerException('Server exception thrown', intval($res_attrs['ID']));
		}
		
		return $result;
	}
}