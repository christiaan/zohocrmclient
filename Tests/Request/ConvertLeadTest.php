<?php
namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;
use Christiaan\ZohoCRMClient\Transport\MockTransport;
use Christiaan\ZohoCRMClient\Transport\TransportRequest;

class UpdateRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;

    /** @var TransportRequest */
    private $request;

    /** @var Request\ConvertLead */
    private $convertLead;

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->request = new TransportRequest('Leads');
        $this->request->setTransport($this->transport);
        $this->convertLead = new Request\ConvertLead($this->request);
    }

    public function testInitial()
    {
        $this->assertEquals('convertLead', $this->request->getMethod());
    }

    public function testId()
    {
        $this->convertLead->id('abc123');
        $this->assertEquals(
            'abc123',
            $this->request->getParam('leadId')
        );
    }

    public function testSetRecord()
    {
        $this->convertLead->setRecords([['abc123']]);

        $this->transport->response = true;

        $this->assertTrue($this->convertLead->request());
        $this->assertEquals(array('xmlData' => [['abc123']]), $this->transport->paramList);
    }
}
