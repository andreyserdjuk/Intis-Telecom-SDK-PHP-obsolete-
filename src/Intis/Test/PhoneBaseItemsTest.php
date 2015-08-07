<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Intis Telecom
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Intis\Test;

require_once  __DIR__.'/../../../vendor/autoload.php';

use Intis\SDK\IntisClient;


class PhoneBaseItemsTest extends \PHPUnit_Framework_TestCase {
    private $login = 'your api login';
    private $apiKey = 'your api key here';
    private $apiHost = 'http://api.host.com/get/';

    public function test_getPhoneBaseItems(){
        $connector = new LocalApiConnector($this->getData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);

        $baseId = 125508;
        $page = 1;
        $items = $client->getPhoneBaseItems($baseId, $page);

        foreach($items as $item){
            $item->getPhone();
            $item->getFirstName();
            $item->getMiddleName();
            $item->getLastName();
            $item->getGender();
            $item->getNetwork();
            $item->getArea();
            $item->getNote1();
            $item->getNote2();
        }

        $this->assertInternalType('array',$items);
        $first = $items[0];
        $this->assertInstanceOf('Intis\SDK\Entity\PhoneBaseItem',$first);
    }

    /**
     * @expectedException Intis\SDK\Exception\PhoneBaseItemException
     */
    public function test_getPhoneBaseItemsException(){
        $connector = new LocalApiConnector($this->getErrorData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);

        $baseId = 12547233333;
        $page = 1;
        $client->getPhoneBaseItems($baseId, $page);
    }

    private function getData(){
        $result = '{"78432956720":{"name":"\u0417\u0430\u0432\u0434\u0430\u0442","last_name":"\u0421\u0430\u0445\u0430\u0432\u0435\u0442\u0434\u0438\u043d\u043e\u0432","middle_name":"\u0411\u0430\u0433\u0430\u0432\u0435\u0442\u0434\u0438\u043d\u043e\u0432\u0438\u0447","date_birth":"0000-00-00","male":"m","note1":"","note2":"","region":null,"operator":null},'.
            '"78432793843":{"name":"\u0413\u0435\u043d\u043d\u0430\u0434\u0438\u0439","last_name":"\u042e\u0440\u044c\u0435\u0432","middle_name":"\u0412\u0430\u0441\u0438\u043b\u044c\u0435\u0432\u0438\u0447","date_birth":"0000-00-00","male":"m","note1":"","note2":"","region":null,"operator":null}}';
        return json_decode($result);
    }

    private function getErrorData(){
        $result = '{"error":4}';
        return json_decode($result);
    }
}
