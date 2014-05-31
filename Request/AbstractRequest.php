<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Exception\NoDataException;
use Christiaan\ZohoCRMClient\Exception\UnexpectedValueException;
use Christiaan\ZohoCRMClient\Response\Record;
use Christiaan\ZohoCRMClient\Transport\TransportRequest;

abstract class AbstractRequest implements RequestInterface
{
    /** @var TransportRequest */
    protected $request;

    public function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->configureRequest();
    }

    /**
     * @throws UnexpectedValueException
     * @return Record[]|Field[]
     */
    public function request()
    {
        try {
            return $this->request->request();
        } catch (NoDataException $e) {
            return array();
        }
    }

    abstract protected function configureRequest();
}
