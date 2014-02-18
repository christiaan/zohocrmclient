<?php
namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;
use Christiaan\ZohoCRMClient\Transport\TransportRequest;

class GetRecordByIdTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetRecordById */
    private $getRecordById;

    public function testInitial()
    {
        $this->assertEquals('getRecordById', $this->request->getMethod());
        $this->assertEquals(
            'All',
            $this->request->getParam('selectColumns')
        );
    }

    public function testSelectColumns()
    {
        $this->getRecordById->selectColumns(array('test'));
        $this->assertEquals(
            'MyOwnModuleName(test)',
            $this->request->getParam('selectColumns')

        );

        $this->getRecordById->selectColumns(array('test', 'test2', 'test4'));
        $this->assertEquals(
            'MyOwnModuleName(test,test2,test4)',
            $this->request->getParam('selectColumns')
        );
    }

    public function testId()
    {
        $this->getRecordById->id('abc123');
        $this->assertEquals(
            'abc123',
            $this->request->getParam('id')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('MyOwnModuleName');
        $this->setGetRecordById(new Request\GetRecordById($this->request));
    }

    /**
     * @param \Christiaan\ZohoCRMClient\Request\GetRecordById $getRecordById
     */
    public function setGetRecordById( $getRecordById )
    {
        $this->getRecordById = $getRecordById;
    }

    /**
     * @return \Christiaan\ZohoCRMClient\Request\GetRecordById
     */
    public function getGetRecordById()
    {
        return $this->getRecordById;
    }
}
