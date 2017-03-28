<?php

namespace Po1nt\SmsManager;

use PHPUnit\Framework\TestCase;

class RecipientTest extends TestCase {
	
	function testPhoneNumber() {
		$recipient = new Recipient('0902987654', 'sk');
		$this->assertStringStartsWith('421', $recipient->getPhoneNumber());
		
		$recipient->setLocale('cz');
		$this->assertStringStartsWith('420', $recipient->getPhoneNumber());
	}
	
	function testInvalidPhoneNumber() {
		$this->expectException(Exceptions\ValidationException::class);
		$recipient = new Recipient('0100800145145', 'sk');
		$recipient->getPhoneNumber();
	}
}
