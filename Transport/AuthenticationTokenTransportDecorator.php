<?php
namespace Christiaan\ZohoCRMClient\Transport;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Transport Decorator that transparently adds the authtoken param and scope param
 */
class AuthenticationTokenTransportDecorator implements Transport, LoggerAwareInterface
{
    private $authToken;
    private $transport;

    function __construct($authToken, Transport $transport)
    {
        $this->authToken = $authToken;
        $this->transport = $transport;
    }

    public function call($module, $method, array $paramList)
    {
        $paramList['authtoken'] = $this->authToken;
        $paramList['scope'] = 'crmapi';

        return $this->transport->call($module, $method, $paramList);
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        if ($this->transport instanceof LoggerAwareInterface) {
            $this->transport->setLogger($logger);
        }
    }
}
