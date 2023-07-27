<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class ExternalSalesInvoiceAttachment.
 */
class ExternalSalesInvoiceAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'external_sales_invoices';
}
