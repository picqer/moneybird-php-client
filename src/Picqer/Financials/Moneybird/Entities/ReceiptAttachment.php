<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class ReceiptAttachment.
 */
class ReceiptAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'documents/receipts';
}
