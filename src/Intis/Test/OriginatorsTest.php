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

use Intis\SDK\Exception\OriginatorException;
use Intis\SDK\IntisClient;
use PHPUnit\Framework\TestCase;

class OriginatorsTest extends TestCase {
    private $login = 'your api login';
    private $apiKey = 'your api key here';
    private $apiHost = 'http://api.host.com/get/';

    /**
     * @covers \Intis\SDK\IntisClient::getOriginators
     */
    public function test_getOriginators(){
        $connector = new LocalApiConnector($this->getData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $originators = $client->getOriginators();

        foreach($originators as $originator){
            $originator->getOriginator();
            $originator->getState();
        }

        $this->assertIsArray($originators);
        $first = $originators[0];
        $this->assertInstanceOf('Intis\SDK\Entity\Originator',$first);
    }

    /**
     * @covers \Intis\SDK\IntisClient::getOriginators
     */
    public function test_getOriginatorsException(){
        $this->expectException(OriginatorException::class);
        $connector = new LocalApiConnector($this->getErrorData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $client->getOriginators();
    }

    private function getData(){
        $result = '{"smstest":"completed","Stok&Sekond":"completed","chmvm":"completed","rsoTEST":"completed"}';
        return json_decode($result);
    }

    private function getErrorData(){
        $result = '{"error":4}';
        return json_decode($result);
    }
}
