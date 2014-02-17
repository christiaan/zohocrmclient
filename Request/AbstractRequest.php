<?php
/**
 * Created by PhpStorm.
 * User: gwagner
 * Date: 2/17/14
 * Time: 10:35 AM
 */ 

namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Exception\NoDataException;
use Christiaan\ZohoCRMClient\Exception\UnexpectedValueException;
use Christiaan\ZohoCRMClient\Response\Field;
use Christiaan\ZohoCRMClient\Response\Record;

abstract class AbstractRequest implements RequestInterface
{
    /** @var TransportRequest */
    protected $request;

    /**
     * @throws UnexpectedValueException
     * @return Record[]|Field[]
     */
    public function request()
    {
        try {
            return $this->getRequest()->request();
        } catch (NoDataException $e) {
            return array();
        }
    }

    /**
     * @param \Christiaan\ZohoCRMClient\Request\TransportRequest $request
     */
    public function setRequest( $request )
    {
        $this->request = $request;
    }

    /**
     * @return \Christiaan\ZohoCRMClient\Request\TransportRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
}
