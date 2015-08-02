<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 30.07.2015
 * Time: 21:52
 */


namespace Intis\Test;

require  '../../../vendor/autoload.php';

use Intis\SDK\IntisClient;


class HLRResponseTest extends \PHPUnit_Framework_TestCase {
    private $login = 'your api login';
    private $apiKey = 'your api key here';
    private $apiHost = 'http://api.host.com/get/';

    public function test_makeHLRRequest(){
        $connector = new LocalApiConnector($this->getData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $phone = array('79009009090', '79009008080');
        /*
         * || $phone = '79009009090,79009008080';
         */
        $result = $client->makeHLRRequest($phone);

        foreach ($result as $hlr) {
            $hlr->getId();
            $hlr->getDestination();
            $hlr->getIMSI();
            $hlr->getMCC();
            $hlr->getMNC();
            $hlr->getOriginalCountryCode();
            $hlr->getOriginalCountryName();
            $hlr->getOriginalNetworkName();
            $hlr->getOriginalNetworkPrefix();
            $hlr->getPortedCountryName();
            $hlr->getPortedCountryPrefix();
            $hlr->getPortedNetworkName();
            $hlr->getPortedNetworkPrefix();
            $hlr->getRoamingCountryName();
            $hlr->getRoamingCountryPrefix();
            $hlr->getRoamingNetworkName();
            $hlr->getRoamingNetworkPrefix();
            $hlr->getStatus();
            $hlr->getPricePerMessage();
            $hlr->isInRoaming();
            $hlr->isPorted();
        }

        $this->assertInternalType('array',$result);
        $first = $result[0];
        $this->assertInstanceOf('Intis\SDK\Entity\HLRResponse',$first);
    }

    /**
     * @expectedException Intis\SDK\Exception\HLRResponseException
     */
    public function test_makeHLRRequestException(){
        $connector = new LocalApiConnector($this->getErrorData());
        $client = new IntisClient($this->login, $this->apiKey, $this->apiHost, $connector);
        $phone = array('79009009090', '79009008080');
        /*
         * || $phone = '79009009090,79009008080';
         */
        $result = $client->makeHLRRequest($phone);
    }

    private function getData(){
        $result = '[{"id":"4133004490987800000001","destination":"79178880143","message_id":"x6ikubibd4y5ljdnttxt","IMSI":"250017224827276","stat":"DELIVRD","error":"0","orn":"MTS (Mobile TeleSystems)","pon":"MTS (Mobile TeleSystems)","ron":"MTS (Mobile TeleSystems)","mccmnc":"25001","rcn":"Russian Federation","ppm":"932","onp":"91788","ocn":"Russian Federation","ocp":"7","is_ported":"false","rnp":"917","rcp":"7","is_roaming":"false","pnp":"79872500000","pcn":"Russian Federation","pcp":"7","total_price":"0.2","request_id":"607a199fb7dc99e68af1196f659c23cf","request_time":"2014-10-14 19:27:29"},'.
            '{"id":"4115440762085900000001","destination":"79371844901","message_id":"l9likizqtxau2e5gbbho","IMSI":"250017145699048","stat":"DELIVRD","error":"0","orn":"Megafon","pon":"MTS (Mobile TeleSystems)","ron":"MTS (Mobile TeleSystems)","mccmnc":"25001","rcn":"Russian Federation","ppm":"932","onp":"93718","ocn":"Russian Federation","ocp":"7","is_ported":"true","rnp":"91701","rcp":"7","is_roaming":"false","pnp":"79872500000","pcn":"Russian Federation","pcp":"7","total_price":"0.2","request_id":"79cdde57cea85f1cc2728f7c0d48f0bd","request_time":"2014-09-24 11:34:36"}]';
        return json_decode($result);
    }

    private function getErrorData(){
        $result = '{"error":4}';
        return json_decode($result);
    }
}
