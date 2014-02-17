<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * InsertRecords API Call
 *
 * @see https://www.zoho.com/crm/help/api/insertrecords.html
 */
class UpdateRecords extends AbstractRequest
{
    /** @var array */
    protected $records = [];

    public function __construct(TransportRequest $request)
    {
        $this->setRequest($request);
        $this->getRequest()->setMethod('updateRecords');
        $this->getRequest()->setParam('version', 4);
    }

    /**
     * @param string $id
     * @return GetRecordById
     */
    public function id($id)
    {
        $this->getRequest()->setParam('id', $id);

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
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     * @return UpdateRecords
     */
    public function setRecords(array $records)
    {
        # Must make sure this is not set on a "update multiple records" call
        $this->getRequest()->removeParam('id');

        $this->records = $records;
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function triggerWorkflow()
    {
        $this->getRequest()->setParam('wfTrigger', true);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateUpdate()
    {
        $this->getRequest()->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateError()
    {
        $this->getRequest()->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return UpdateRecords
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
