<?php

namespace Picqer\Financials\Moneybird\Actions;

use Picqer\Financials\Moneybird\Exceptions\ApiException;

/**
 * @property string $id
 */
trait Attachment
{
    use BaseTrait;

    protected $attachmentPath = 'attachments';

    /**
     * Add an attachment to this invoice.
     *
     * You can use fopen('/path/to/file', 'r') in $resource.
     *
     * @param  string  $filename  The filename of the attachment
     * @param  resource  $contents  A StreamInterface/resource/string, @see http://docs.guzzlephp.org/en/stable/request-options.html?highlight=multipart#multipart
     * @return void
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function addAttachment($filename, $contents)
    {
        if (! isset($this->id)) {
            throw new ApiException('This method can only be used on existing records.');
        }

        $this->connection()->upload($this->getEndpoint() . '/' . urlencode($this->id) . '/' . $this->attachmentPath, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $contents,
                    'filename' => $filename,
                ],
            ],
        ]);
    }
}
