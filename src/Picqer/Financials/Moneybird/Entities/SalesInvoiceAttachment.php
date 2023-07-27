<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class SalesInvoiceAttachment.
 */
class SalesInvoiceAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'sales_invoices';
}
