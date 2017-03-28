# PHP Library for SmsManager.cz

## Installation
Install superfaktura/smsmanager using  [Composer](http://getcomposer.org/):

```sh
$ composer require superfaktura/smsmanager
```

### Dependencies
- PHP >=5.6
- PHP extensions: php_curl

## Example Usage

```php
use Po1nt\SmsManager\Dispatcher;
use Po1nt\SmsManager\Message;
use Po1nt\SmsManager\Recipient;

/** @var Recipient $recipient */
$recipient = new Recipient('420 900 123 456');

/** @var Message $message */
$message = new Message('Best message text ever');
$message->addRecipient($recipient);

/** @var Dispatcher $dispatcher */
$dispatcher = new Dispatcher('example@smsmanager.cz', 'examplePass');
print_r($dispatcher->send($message));

```

### License
MIT