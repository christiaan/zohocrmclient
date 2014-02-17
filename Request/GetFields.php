<?php
namespace Christiaan\ZohoCRMClient\Request;

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
