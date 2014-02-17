<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\Record;
use Christiaan\ZohoCRMClient\Exception\NoDataException;
use Christiaan\ZohoCRMClient\Exception\UnexpectedValueException;

/**
 * GetRecords API Call
 *
 * You can use the getRecords method to fetch all users data specified in the API request.
 *
 * @see https://www.zoho.com/crm/help/api/getrecords.html
 */
class GetRecordById implements Request
{
    protected $method = 'getRecordById';

    private $request;

    function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->request->setMethod($this->method);

        $this->request->setParam('selectColumns', 'All');
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
        $this->request->setParam(
            'selectColumns',
            'Leads(' . implode(',', $columns) .')'
        );
        return $this;
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
     * @throws UnexpectedValueException
     * @return Record[]
     */
    public function request()
    {
        try {
            return $this->request->request();
        } catch (NoDataException $e) {
            return array();
        }
    }
}
