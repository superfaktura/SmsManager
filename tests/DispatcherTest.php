<?php

namespace Po1nt\SmsManager;

use PHPUnit\Framework\TestCase;
use Po1nt\SmsManager\Exceptions\ServerException;

class DispatcherStub extends Dispatcher {
	
	public function generateXml($message) {
		return parent::generateXml($message);
	}
}

class DispatcherTest extends TestCase {
	
	const API_USER = 'info@superfaktura.cz';
	const API_PASS = 'HesloTiNeřeknuZmrde!';
	
	function createMessage() {
		$recipient = new Recipient('0900123456', 'sk');
		
		$message = new Message();
		$message->setText('test');
		$message->addRecipient($recipient);
		
		return $message;
	}
	
	function createDispatcher() {
		$dispatcher = new DispatcherStub('test', 'test');
		
		return $dispatcher;
	}
	
	function testGenerateXmlIsValid() {
		$dispatcher = $this->createDispatcher();
		$message = $this->createMessage();
		$message->addRecipient(new Recipient('+420 123 12 12 13'));
		$xml = $dispatcher->generateXml($message);
		$dxml = dom_import_simplexml($xml);
		
		$domdoc = new \DOMDocument('1.0');
		$dxml = $domdoc->importNode($dxml, true);
		$domdoc->appendChild($dxml);
		
		$this->assertTrue($domdoc->schemaValidateSource($this->getXsdSchema()), 'Should be valid XML');
	}
	
	function testWrongServerPassword() {
		$this->expectException(ServerException::class);
		
		$dispatcher = new DispatcherStub('WRONG_USER', 'WRONG_PASS');
		$message = new Message('Test message text');
		$message->addRecipient(new Recipient('+420 123 12 12 12'));
		$message->addRecipient(new Recipient('+420 123 12 12 13'));
		
		$dispatcher->send($message);
	}
	
	/**
	 * @depends testGenerateXmlIsValid
	 */
	function testSend() {
		$dispatcher = new DispatcherStub(self::API_USER, self::API_PASS);
		$message = new Message('c==3');
		$message->addRecipient(new Recipient('+421 902 796 000'));
		$message->addRecipient(new Recipient('+421 940 133 565'));
		
		$result = $dispatcher->send($message);
	}
	
	function getXsdSchema() {
		return <<<XML
<xs:schema attributeFormDefault="unqualified" elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:element name="RequestDocument">
    <xs:complexType>
      <xs:sequence>
        <xs:element name="RequestHeader" maxOccurs="1">
          <xs:complexType>
            <xs:sequence>
              <xs:element type="xs:string" name="Username"/>
              <xs:element type="xs:string" name="Password"/>
            </xs:sequence>
          </xs:complexType>
        </xs:element>
        <xs:element name="RequestList" maxOccurs="1">
          <xs:complexType>
            <xs:sequence>
              <xs:element name="Request" maxOccurs="unbounded" minOccurs="1">
                <xs:complexType>
                  <xs:sequence>
                    <xs:element name="Message" minOccurs="1" maxOccurs="1">
                      <xs:complexType>
                        <xs:simpleContent>
                          <xs:extension base="xs:string">
                            <xs:attribute type="xs:string" name="Type"/>
                          </xs:extension>
                        </xs:simpleContent>
                      </xs:complexType>
                    </xs:element>
                    <xs:element name="NumbersList" minOccurs="1" maxOccurs="1">
                      <xs:complexType>
                        <xs:sequence>
                          <xs:element type="xs:long" name="Number" minOccurs="1" maxOccurs="1"/>
                        </xs:sequence>
                      </xs:complexType>
                    </xs:element>
                  </xs:sequence>
                  <xs:attribute type="xs:string" name="Type"/>
                  <xs:attribute type="xs:int" name="CustomID" use="optional"/>
                </xs:complexType>
              </xs:element>
            </xs:sequence>
          </xs:complexType>
        </xs:element>
      </xs:sequence>
    </xs:complexType>
  </xs:element>
</xs:schema>
XML;
	}
}
