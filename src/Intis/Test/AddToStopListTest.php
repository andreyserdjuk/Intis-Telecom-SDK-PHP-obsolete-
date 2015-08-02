<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 30.07.2015
 * Time: 22:51
 */

namespace Intis\Test;

require  '../../../vendor/autoload.php';

use Intis\SDK\IntisClient;

class AddToStopListTest extends \PHPUnit_Framework_TestCase {
    private $login = 'your api login';
    private $apiKey = 'your api key here';
    private $apiHost = 'http://api.host.com/get/';

    public function test_addTemplate(){
        $connector = new LocalApiConnector($this->getData());

        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $phone = '79009009090';

        $result = $client->addToStopList($phone);

        $this->assertNotEquals(0, $result);
    }

    /**
     * @expectedException Intis\SDK\Exception\AddToStopListException
     */
    public function test_addTemplateException(){
        $connector = new LocalApiConnector($this->getErrorData());

        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $phone = '79009009090';

        $result = $client->addToStopList($phone);
    }

    private function getData(){
        $result = '{"id":4}';
        return json_decode($result);
    }

    private function getErrorData(){
        $result = '{"error":4}';
        return json_decode($result);
    }
}
