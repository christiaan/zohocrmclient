<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * InsertRecords API Call
 *
 * @see https://www.zoho.com/crm/help/api/insertrecords.html
 */
class UpdateRecords implements Request
{
    private $request;
    private $records;

    public function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->request->setMethod('updateRecords');
        $this->request->setParam('version', 4);
        $this->records = array();
    }

    /**
     * @param string $id
     * @return GetRecordById
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);

        return $this;
    }

    /**
     * @param array $record Record as a simple associative array
     * @return UpdateRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;
        return $this;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     * @return UpdateRecords
     */
    public function setRecords(array $records)
    {
        # Must make sure this is not set on a "update multiple records" call
        $this->request->removeParam('id');

        $this->records = $records;
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function triggerWorkflow()
    {
        $this->request->setParam('wfTrigger', true);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateUpdate()
    {
        $this->request->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateError()
    {
        $this->request->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return UpdateRecords
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
