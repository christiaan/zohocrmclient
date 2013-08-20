<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Exception\NoDataException;
use Christiaan\ZohoCRMClient\Response\Field;
use Christiaan\ZohoCRMClient\Exception\ZohoErrorException;

/**
 * GetFields API Call
 *
 * @see https://www.zoho.com/crm/help/api/getfields.html
 */
class GetFields implements Request
{
    private $request;

    public function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->request->setMethod('getFields');
    }

    /**
     * @throws ZohoErrorException
     * @return Field[]
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