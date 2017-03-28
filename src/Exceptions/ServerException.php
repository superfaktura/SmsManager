<?php
/**
 * Created by PhpStorm.
 * User: SF1
 * Date: 27.03.2017
 * Time: 13:01
 */

namespace Po1nt\SmsManager\Exceptions;

use Exception;

class ServerException extends \Exception {
	private $errors = [
		101 => 'Neexistující data požadavku (chybí XMLDATA parametr u XML API)',
		102 => 'Zaslaná data nejsou ve správném formátu',
		103 => 'Neplatné uživatelské jméno nebo heslo',
		104 => 'Neplatný parametr gateway',
		105 => 'Nedostatek kreditu pro prepaid',
		109 => 'Požadavek neobsahuje všechna vyžadovaná data',
		201 => 'Žádná platná telefonní čísla v požadavku',
		202 => 'Text zprávy neexistuje nebo je příliš dlouhý',
		203 => 'Neplatný parametr sender (odesílatele nejprve nastavte ve webovém rozhraní)'
	];
	
	public function __construct($message = "", $code = 0, \Exception $previous = null) {
		if(isset($this->errors[$code])) {
			$message .= ': ' . $this->errors[$code];
		} else if($code > 100) {
			$message .= ': General failure, please contact support';
		}
		parent::__construct($message, $code, $previous);
	}
	
	public function getError($code) {
		return isset($this->errors[$code])? $this->errors[$code] : null;
	}
}