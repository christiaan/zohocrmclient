<?php
namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;

class GetRecordByIdTest extends \PHPUnit_Framework_TestCase
{
    /** @var Request\TransportRequest */
    private $request;
    /** @var Request\GetRecordById */
    private $getRecordById;

    public function testInitial()
    {
        $this->assertEquals('getRecordById', $this->request->getMethod());
        $this->assertEquals(
            'All',
            $this->getRecordById->getRequest()->getParam('selectColumns')
        );
    }

    public function testSelectColumns()
    {
        $this->getRecordById->selectColumns(['test']);
        $this->assertEquals(
            'Leads(test)',
            $this->getRecordById->getRequest()->getParam('selectColumns')

        );

        # Verify that the implode is working
        $this->getRecordById->selectColumns(['test', 'test2']);
        $this->assertEquals(
            'Leads(test,test2)',
            $this->getRecordById->getRequest()->getParam('selectColumns')
        );

        # Verify that the getModule is working
        $this->getRecordById->getRequest()->setModule('Accounts');
        $this->getRecordById->selectColumns(['test', 'test2']);
        $this->assertEquals(
            'Accounts(test,test2)',
            $this->getRecordById->getRequest()->getParam('selectColumns')
        );
    }

    public function testId()
    {
        $this->getRecordById->id('abc123');
        $this->assertEquals(
            'abc123',
            $this->getRecordById->getRequest()->getParam('id')
        );
    }

    protected function setUp()
    {
        $this->request = new Request\TransportRequest('Leads');
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
