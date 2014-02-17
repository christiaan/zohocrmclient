<?php
namespace Christiaan\ZohoCRMClient\Request;

/**
 * GetRecords API Call
 *
 * You can use the getRecords method to fetch all users data specified in the API request.
 *
 * @see https://www.zoho.com/crm/help/api/getrecords.html
 */
class GetRecordById  extends AbstractRequest
{
    protected $method = 'getRecordById';

    /**
     * @param TransportRequest $request
     */
    function __construct(TransportRequest $request)
    {
        $this->setRequest($request);
        $this->getRequest()->setMethod($this->method);

        $this->getRequest()->setParam('selectColumns', 'All');
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array $columns
     * @return GetRecordById
     */
    public function selectColumns($columns)
    {
        if (is_string($columns)) {
            $columns = func_get_args();
        }
        $this->getRequest()->setParam(
            'selectColumns',
            $this->getRequest()->getModule().'(' . implode(',', $columns) .')'
        );
        return $this;
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
}
