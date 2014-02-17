<?php
namespace Christiaan\ZohoCRMClient\Request;

/**
 * GetRecords API Call
 *
 * You can use the getRecords method to fetch all users data specified in the API request.
 *
 * @see https://www.zoho.com/crm/help/api/getrecords.html
 */
class GetRecords extends AbstractRequest
{
    /** @var string */
    protected $method = 'getRecords';

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
     * @return GetRecords
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
     * @param int $index
     * @return GetRecords
     */
    public function fromIndex($index)
    {
        $this->getRequest()->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetRecords
     */
    public function toIndex($index)
    {
        $this->getRequest()->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * @param string $column
     * @return GetRecords
     */
    public function sortBy($column)
    {
        $this->getRequest()->setParam('sortColumnString', (string) $column);
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
        $this->getRequest()->setParam('lastModifiedTime', $timestamp->format('Y-m-d H:i:s'));
        return $this;
    }

    private function sortOrder($direction)
    {
        $this->getRequest()->setParam('sortOrderString', $direction);
    }
}
