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
class GetFields extends AbstractRequest
{
    public function __construct(TransportRequest $request)
    {
        $this->setRequest($request);
        $this->getRequest()->setMethod('getFields');
    }
}
