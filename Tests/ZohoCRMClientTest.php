<?php
namespace Christiaan\ZohoCRMClient\Tests;

use Christiaan\ZohoCRMClient\Request\GetRecords;
use Christiaan\ZohoCRMClient\Transport\MockTransport;
use Christiaan\ZohoCRMClient\ZohoCRMClient;

class ZohoCRMClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;

    /** @var ZohoCRMClient */
    private $client;

    public function testGetRecords()
    {
        $request = $this->client->getRecords()
            ->selectColumns('id', 'name')
            ->fromIndex(100)
            ->toIndex(200)
            ->sortBy('name')
            ->sortAsc()
            ->since(date_create('now'));

        $this->assertTrue($request instanceof GetRecords);
    }

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->client = new ZohoCRMClient('Leads', $this->transport);
    }
}
 