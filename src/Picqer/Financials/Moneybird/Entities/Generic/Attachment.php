<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class InvoiceDetail.
 */
abstract class Attachment extends Model
{
    /**
     * @var string
     */
    protected $attachmentPath = 'attachments';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'attachable_id',
        'attachable_type',
        'filename',
        'content_type',
        'size',
        'rotation',
        'created_at',
        'updated_at',
    ];

    /**
     * Download the file.
     *
     * @return string file data
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function download()
    {
        $response = $this->connection()->download($this->getEndpoint() . '/' . urlencode($this->attachable_id) . '/' . $this->attachmentPath . '/' . urlencode($this->id) . '/download');

        return $response->getBody()->getContents();
    }
}
