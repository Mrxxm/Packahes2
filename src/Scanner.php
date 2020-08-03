<?php


namespace Mrxxm\Scanner;

use GuzzleHttp\Client;

class Scanner
{
    protected $urls;

    protected $httpClient;

    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }

    public function getInvalidUrld()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {

            try {
                $statusCode = $this->getStatusCodeForUrl($url);

            } catch (\Exception $exception) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invalidUrls, ['url' => $url, 'status' => $statusCode]);
            }
        }
        return $invalidUrls;

    }
}