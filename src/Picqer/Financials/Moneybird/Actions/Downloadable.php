<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Downloadable.
 */
trait Downloadable
{
    use BaseTrait;

    /**
     * Download as PDF.
     *
     * @return string PDF file data
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function download()
    {
        $response = $this->connection()->download($this->getEndpoint() . '/' . urlencode($this->id) . '/download_pdf');

        return $response->getBody()->getContents();
    }
}
