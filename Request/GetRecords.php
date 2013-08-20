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
class GetRecords implements Request
{
    protected $method = 'getRecords';

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
     * @return GetRecords
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
     * @param int $index
     * @return GetRecords
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetRecords
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * @param string $column
     * @return GetRecords
     */
    public function sortBy($column)
    {
        $this->request->setParam('sortColumnString', (string) $column);
        return $this;
    }

    /**
     * @return GetRecords
     */
    public function sortAsc()
    {
        $this->sortOrder('asc');
        return $this;
    }

    /**
     * @return GetRecords
     */
    public function sortDesc()
    {
        $this->sortOrder('desc');
        return $this;
    }

    /**
     * If you specify the time, modified data will be fetched after the configured time.
     *
     * @param \DateTime $timestamp
     * @return GetRecords
     */
    public function since(\DateTime $timestamp)
    {
        $this->request->setParam('lastModifiedTime', $timestamp->format('Y-m-d H:i:s'));
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

    private function sortOrder($direction)
    {
        $this->request->setParam('sortOrderString', $direction);
    }
}