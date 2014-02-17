<?php
namespace Christiaan\ZohoCRMClient;

use Christiaan\ZohoCRMClient\Request;
use Christiaan\ZohoCRMClient\Transport;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Main Class of the ZohoCRMClient library
 * Only use this class directly
 */
class ZohoCRMClient implements LoggerAwareInterface
{
    /** @var string */
    private $module;
    /** @var Transport\Transport */
    private $transport;
    /** @var LoggerInterface */
    private $logger;

    public function __construct($module, $authToken)
    {
        $this->module = $module;

        if ($authToken instanceof Transport\Transport) {
            $this->transport = $authToken;
        } else {
            $this->transport = new Transport\XmlDataTransportDecorator(
                    new Transport\AuthenticationTokenTransportDecorator(
                        $authToken,
                        new Transport\BuzzTransport(
                            new \Buzz\Browser(new \Buzz\Client\Curl()),
                            'https://crm.zoho.com/crm/private/xml/'
                        )
                    )
                );
        }
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return Request\GetRecords
     */
    public function getRecords()
    {
        return new Request\GetRecords($this->request());
    }

    /**
     * @return Request\GetRecordById
     */
    public function getRecordById()
    {
        return new Request\GetRecordById($this->request());
    }

    /**
     * @return Request\InsertRecords
     */
    public function insertRecords()
    {
        return new Request\InsertRecords($this->request());
    }

    /**
     * @return Request\UpdateRecords
     */
    public function updateRecords()
    {
        return new Request\UpdateRecords($this->request());
    }

    /**
     * @return Request\GetFields
     */
    public function getFields()
    {
        return new Request\GetFields($this->request());
    }

    /**
     * @return Request\TransportRequest
     */
    protected function request()
    {
        $request = new Request\TransportRequest($this->module);
        $request->setTransport($this->transport);
        return $request;
    }
}
