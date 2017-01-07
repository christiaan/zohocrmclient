<?php
/**
 * Created by PhpStorm.
 * User: Wes
 * Date: 1/6/2017
 * Time: 7:30 PM
 */

namespace Christiaan\ZohoCRMClient\Tests\Request;


use Christiaan\ZohoCRMClient\Request;
use Christiaan\ZohoCRMClient\Transport\TransportRequest;


class GetUsersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TransportRequest
     */
    private $request;
    /**
     * @var Request\GetUsers
     */
    private $getUsers;

    public function testInitial()
    {
        $this->assertEquals('getUsers', $this->request->getMethod());
        $this->assertEquals('AllUsers', $this->request->getParam('type'));
    }

    public function testVersion()
    {
        $this->getUsers->version(1);
        $this->assertEquals(
            1,
            $this->request->getParam('version')
        );
        $this->getUsers->version(2);
        $this->assertEquals(
            2,
            $this->request->getParam('version')
        );
    }

    public function testNewFormat()
    {
        $this->getUsers->newFormat(1);
        $this->assertEquals(
            1,
            $this->request->getParam('newFormat')
        );
        $this->getUsers->newFormat(2);
        $this->assertEquals(
            2,
            $this->request->getParam('newFormat')
        );
    }

    public function testType()
    {
        $this->getUsers->type('ActiveUsers');
        $this->assertEquals(
            'ActiveUsers',
            $this->request->getParam('type')
        );
        $this->getUsers->type('AllUsers');
        $this->assertEquals(
            'AllUsers',
            $this->request->getParam('type')
        );
        $this->getUsers->type('DeactiveUsers');
        $this->assertEquals(
            'DeactiveUsers',
            $this->request->getParam('type')
        );
        $this->getUsers->type('AdminUsers');
        $this->assertEquals(
            'AdminUsers',
            $this->request->getParam('type')
        );
        $this->getUsers->type('ActiveConfirmedUsers');
        $this->assertEquals(
            'ActiveConfirmedUsers',
            $this->request->getParam('type')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Users');
        $this->getUsers = new Request\GetUsers($this->request);
    }

}
