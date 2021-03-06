<?php
namespace Christiaan\ZohoCRMClient\Transport;

use Buzz\Browser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Transport implemented using the Buzz library to do HTTP calls to Zoho
 */
class BuzzTransport implements Transport, LoggerAwareInterface
{
    private $browser;
    private $baseUrl;
    private $logger;

    public function __construct(Browser $browser, $baseUrl)
    {
        $this->browser = $browser;
        $this->baseUrl = $baseUrl;
        $this->logger = new NullLogger();
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function call($module, $method, array $paramList)
    {
        $url = $this->baseUrl . $module . '/' .  $method;
        $headers = array();
        $requestBody = http_build_query($paramList, '', '&');

        $this->logger->info(sprintf(
                '[christiaan/zohocrmclient] request: call "%s" with params %s',
                $module . '/' . $method,
                $requestBody
            ));

        /** @var \Buzz\Message\Response $response */
        $response = $this->browser->post($url, $headers, $requestBody);


        $responseContent = $response->getContent();
        if ($response->getStatusCode() !== 200) {
            $this->logger->error(sprintf(
                    '[christiaan/zohocrmclient] fault "%s" for request "%s" with params %s',
                    $responseContent,
                    $module . '/' . $method,
                    $requestBody
                ));
            throw new HttpException(
                $responseContent, $response->getStatusCode()
            );
        }

        $this->logger->info(sprintf(
                '[christiaan/zohocrmclient] response: %s',
                $responseContent
            ));

        return $responseContent;
    }
}