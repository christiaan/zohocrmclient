<?php
namespace Christiaan\ZohoCRMClient\Request;

/**
 * SearchRecords API Call
 *
 * You can use the searchRecords method to get the list of records that meet your search criteria.
 *
 * @see https://www.zoho.eu/crm/help/api/searchrecords.html
 */
class SearchRecords extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('searchRecords')
            ->setParam('selectColumns', 'All');
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param string $criteria
     * @return GetRecords
     */
    public function criteria($criteria)
    {
        $this->request->setParam(
            'criteria',
            '(' . $criteria . ')'
        );
        return $this;
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
        if (!is_array($columns)) {
            $columns = func_get_args();
        }
        $this->request->setParam(
            'selectColumns',
            $this->request->getModule() . '(' . implode(',', $columns) . ')'
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
     * Set the format of the API data to return
     *
     * The `$format` parameter (as of January 6th, 2017) can be
     * one of the following:
     *
     * - `1`: To exclude fields with "null" values while inserting data from your CRM account.
     * - `2`: To include fields with "null" values while inserting data from your CRM account.
     *
     * @param int $format The format version as specified in the Zoho CRM documentation (1 to exclude null fields, 2 to include them)
     *
     * @return $this
     */
    public function newFormat($format = 1)
    {
        $this->request->setParam('newFormat', (int)$format);
        return $this;
    }
}
