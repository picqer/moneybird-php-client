<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class SalesInvoiceAttachment.
 */
class PurchaseInvoiceAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'documents/purchase_invoices';
}
