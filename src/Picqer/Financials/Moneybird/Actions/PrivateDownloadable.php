<?php

namespace Picqer\Financials\Moneybird\Actions;

use GuzzleHttp\Psr7\Request;

/**
 * Class PrivateDownloadable
 * 
 * This download as PDF method is a private API method. It is currently
 * officially unsupported, but serves a purpose until Moneybird updates
 * their API to provide PDF files.
 * 
 * @package Picqer\Financials\Moneybird\Actions
 */
trait PrivateDownloadable
{
    
    /**
     * Download invoice as PDF
     *
     * @return string PDF file data
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function download()
    {
        $connection = $this->connection;
        $client = $connection->connect();
        
        $headers = [
            'Accept' => 'application/pdf',
            'Content-Type' => 'application/pdf',
            'Authorization' => 'Bearer ' . $connection->getAccessToken(),
        ];

        $endpoint = 'https://moneybird.com/' . $connection->getAdministrationId() . '/' . $this->endpoint . '/' . $this->id . '.pdf';
        $body = '';
            
        $request = new Request('GET', $endpoint, $headers, $body);
        $response = $client->send($request);

        return $response->getBody()->getContents();
    }

}
