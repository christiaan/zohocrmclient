<?php
/**
 * Created by PhpStorm.
 * User: gwagner
 * Date: 2/17/14
 * Time: 10:50 AM
 */

namespace Christiaan\ZohoCRMClient\Tests\Request;

use Christiaan\ZohoCRMClient\Request;

class UpdateRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Request\TransportRequest */
    private $request;

    /** @var Request\UpdateRecords */
    private $updateRecords;

    protected function setUp()
    {
        $this->request = new Request\TransportRequest('Leads');
        $this->setUpdateRecords(new Request\UpdateRecords($this->request));
    }

    public function testInitial()
    {
        $this->assertEquals('updateRecords', $this->request->getMethod());
        $this->assertEquals(
            4,
            $this->updateRecords->getRequest()->getParam('version')
        );
    }

    public function testId()
    {
        $this->updateRecords->id('abc123');
        $this->assertEquals(
            'abc123',
            $this->updateRecords->getRequest()->getParam('id')
        );
    }

    public function testAddRecord()
    {
        $this->updateRecords->addRecord(array('abc123'));
        $this->assertEquals(
            array(array('abc123')),
            $this->updateRecords->getRecords()
        );
    }

    public function testSetRecords()
    {
        # Make sure an ID is set
        $this->testId();

        $this->updateRecords->setRecords(array('abc123'));
        $this->assertEquals(
            array('abc123'),
            $this->updateRecords->getRecords()
        );

        # Test that the ID is removed
        $this->assertNotEquals(
            'abc123',
            $this->updateRecords->getRequest()->getParam('id')
        );
    }

    public function testTriggerWorkflow()
    {
        $this->updateRecords->triggerWorkflow();
        $this->assertTrue(
            $this->updateRecords->getRequest()->getParam('wfTrigger')
        );
    }

    public function testOnDuplicateUpdate()
    {
        $this->updateRecords->onDuplicateUpdate();
        $this->assertEquals(
            2,
            $this->updateRecords->getRequest()->getParam('duplicateCheck')
        );
    }

    public function testOnDuplicateError()
    {
        $this->updateRecords->onDuplicateError();
        $this->assertEquals(
            1,
            $this->updateRecords->getRequest()->getParam('duplicateCheck')
        );
    }

    public function testRequireApproval()
    {
        $this->updateRecords->requireApproval();
        $this->assertTrue(
            $this->updateRecords->getRequest()->getParam('isApproval')
        );
    }

    /**
     * @param \Christiaan\ZohoCRMClient\Request\UpdateRecords $updateRecords
     */
    public function setUpdateRecords( $updateRecords )
    {
        $this->updateRecords = $updateRecords;
    }

    /**
     * @return \Christiaan\ZohoCRMClient\Request\UpdateRecords
     */
    public function getUpdateRecords()
    {
        return $this->updateRecords;
    }
}
