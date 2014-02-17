<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * InsertRecords API Call
 *
 * @see https://www.zoho.com/crm/help/api/insertrecords.html
 */
class InsertRecords extends AbstractRequest
{
    /** @var array */
    protected $records = array();

    public function __construct(TransportRequest $request)
    {
        $this->setRequest($request);
        $this->getRequest()->setMethod('insertRecords');
        $this->getRequest()->setParam('version', 4);
    }

    /**
     * @param array $record Record as a simple associative array
     * @return InsertRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;
        return $this;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     * @return InsertRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function triggerWorkflow()
    {
        $this->getRequest()->setParam('wfTrigger', true);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function onDuplicateUpdate()
    {
        $this->getRequest()->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function onDuplicateError()
    {
        $this->getRequest()->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function requireApproval()
    {
        $this->getRequest()->setParam('isApproval', true);
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        $this->getRequest()->setParam('xmlData', $this->records);
        return $this->getRequest()->request();
    }
}
