<?php
/**
 * Created by PhpStorm.
 * User: Wes
 * Date: 1/6/2017
 * Time: 6:58 PM
 */

namespace Christiaan\ZohoCRMClient\Request;

/**
 * Gets a list of users in your organization
 *
 * @see     https://www.zoho.com/crm/help/api/getusers.html
 * @package Christiaan\ZohoCRMClient\Request
 */
class GetUsers extends AbstractRequest
{

    /**
     * @inheritdoc
     */
    protected function configureRequest()
    {
        $this->request
            ->setMethod('getUsers')
            ->setParam('type', 'AllUsers');
    }

    /**
     * Set the version of API data to return.
     *
     * The `$version` parameter is (as of January 6th, 2017) can be
     * one of the following:
     *
     * - `1` (default): Fetch responses based on the earlier API implementation, i.e prior to enhancements made
     * - `2`: Fetch responses based on the latest API documentation
     *
     * @param int $version The version of data to get back (1 to exclude null fields, 2 to include them)
     *
     * @return $this
     */
    public function version($version = 1)
    {
        $this->request->setParam('version', (int)$version);
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

    /**
     * Set what type of users to return
     *
     * The `$type` parameter (as of January 6th, 2017) can be one of the following:
     *
     * - `'AllUsers'`: Lists all users in your organization (both active and inactive)
     * - `'ActiveUsers'`: Lists only active users in your organization
     * - `'DeactiveUsers'`: Lists all users in your organization who have been deactivated
     * - `'AdminUsers'`: Lists all users who have Administrative privileges
     * - `'ActiveConfirmedUsers'`: Lists all users who have Administrative privileges who are also confirmed
     *
     * @param string $type What type of users the API should return (see above)
     *
     * @return $this
     */
    public function type($type = "AllUsers")
    {
        $this->request->setParam('type', $type);
        return $this;
    }
}