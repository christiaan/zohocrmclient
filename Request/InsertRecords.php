<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * InsertRecords API Call
 *
 * @see https://www.zoho.com/crm/help/api/insertrecords.html
 */
class InsertRecords implements Request
{
    private $request;
    private $records;

    public function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->request->setMethod('insertRecords');
        $this->request->setParam('version', 4);
        $this->records = array();
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
        $this->request->setParam('wfTrigger', true);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function onDuplicateUpdate()
    {
        $this->request->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function onDuplicateError()
    {
        $this->request->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return InsertRecords
     */
    public function requireApproval()
    {
        $this->request->setParam('isApproval', true);
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        $this->request->setParam('xmlData', $this->records);
        return $this->request->request();
    }
}