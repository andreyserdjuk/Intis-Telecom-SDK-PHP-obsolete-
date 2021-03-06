<?php
/**
 * Send sms, balance, delivery
 */

require dirname(__FILE__) . '/../../vendor/autoload.php';

use Intis\SDK\Entity\DeliveryStatus;
use Intis\SDK\Entity\MessageSendingResult;
use Intis\SDK\Entity\MessageSendingSuccess;
use Intis\SDK\IntisClient;

$login = 'your login';
$apiKey = 'your key';
$host = 'https://go.intistele.com/external/get';
$phone = 'phone number';

$client = new IntisClient($login, $apiKey, $host);

/** @var MessageSendingResult[] $results */
$results = $client->sendMessage([$phone], 'smstest', 'Hello!');
if (!count($results) or !$results[0]->isOk()) {
    echo 'Error: ' . isset($results[0]) ? $results[0]->getMessage() : 'not sent';
    exit(0);
}

/** @var MessageSendingSuccess $result */
$result = $results[0];
$messageId = $result->getMessageId();
echo sprintf('Send message cost: %s %s', $result->getCost(), $result->getCurrency()) . PHP_EOL;

/** @var DeliveryStatus[] $deliveryResults */
$deliveryResults = $client->getDeliveryStatus($messageId);
if (!count($deliveryResults)) {
    echo 'Error check delivery' . PHP_EOL;
    exit(0);
}

$deliveryResult = $deliveryResults[0];
echo sprintf('Delivery status: %s', $deliveryResult->getMessageStatus()) . PHP_EOL;

$balance = $client->getBalance();
echo sprintf('Balance: %s %s', $balance->getAmount(), $balance->getCurrency()) . PHP_EOL;