<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\InvoicePayment;

/**
 * Class SalesInvoicePayment.
 */
class PurchaseInvoicePayment extends InvoicePayment
{
    /**
     * Delete the current purchase invoice payment.
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function delete()
    {
        return $this->connection()->delete('/documents/purchase_invoices/' . urlencode($this->invoice_id) . '/payments/' . urlencode($this->id));
    }
}
