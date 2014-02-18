<?php
namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;
use Christiaan\ZohoCRMClient\Transport\TransportRequest;

class GetFieldsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetFields */
    private $getFields;

    public function testInitial()
    {
        $this->assertEquals('getFields', $this->request->getMethod());
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->getFields = new Request\GetFields($this->request);
    }
}