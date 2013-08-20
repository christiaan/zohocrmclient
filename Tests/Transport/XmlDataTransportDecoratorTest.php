<?php
namespace Christiaan\ZohoCRMClient\Tests\Transport;

use Christiaan\ZohoCRMClient\Response\Record;
use Christiaan\ZohoCRMClient\Transport\MockTransport;
use Christiaan\ZohoCRMClient\Transport\XmlDataTransportDecorator;

class XmlDataTransportDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $mockTransport;
    /** @var XmlDataTransportDecorator */
    private $transport;

    public function testEncodeRecords()
    {
        $records = array(
            array(
                'First Name' => 'Christiaan',
                'Last Name' => 'Baartse',
                'Due Date' => date_create('2012-01-01')
            ),
            array('First Name' => 'Stefan'),
        );

        $this->mockTransport->response = file_get_contents(__DIR__ . '/getRecordsResponse.xml');

        $records = $this->transport->call(
            'Leads',
            'getRecords',
            array('xmlData' => $records)
        );

        $this->assertEquals(
            <<<XML
<?xml version="1.0"?>
<Leads><row no="1"><FL val="First Name">Christiaan</FL><FL val="Last Name">Baartse</FL><FL val="Due Date">01/01/2012</FL></row><row no="2"><FL val="First Name">Stefan</FL></row></Leads>

XML
            ,
            $this->mockTransport->paramList['xmlData']
        );

        $this->assertTrue(is_array($records));

        /** @var Record $record */
        $record = $records[1];
        $this->assertTrue($record instanceof Record);

        $this->assertEquals('acme', $record->get('Company'));
        $this->assertEquals('Baartse', $record->get('Last Name'));
    }


    protected function setUp()
    {
        $this->mockTransport = new MockTransport();
        $this->transport = new XmlDataTransportDecorator($this->mockTransport);
    }
}
 