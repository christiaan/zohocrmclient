<?php
namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;

class GetFieldsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Request\TransportRequest */
    private $request;
    /** @var Request\GetFields */
    private $getFields;

    public function testInitial()
    {
        $this->assertEquals('getFields', $this->request->getMethod());
    }

    protected function setUp()
    {
        $this->request = new Request\TransportRequest('Leads');
        $this->getFields = new Request\GetFields($this->request);
    }
}