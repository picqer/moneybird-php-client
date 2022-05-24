<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string contact_id
 * @property string workflow_id
 * @property string identity_id
 * @property string document_style_id
 * @property string sales_invoices
 * @property string reminder_text
 * @property string delivery_method
 * @property string email_address
 */
class SalesInvoiceReminder extends Model
{
    
    protected $fillable = [
        'contact_id',
        'workflow_id',
        'identity_id',
        'document_style_id',
        'sales_invoices',
        'reminder_text',
        'delivery_method',
        'email_address',
    ];

    protected $endpoint = 'sales_invoices';

    
    protected $namespace = 'sales_invoice_reminders';

    
    public function send()
    {
        $aReminder = $this->json();
        $aReminder = json_decode($aReminder, true);

        $aReminder['sales_invoice_ids'] = array_map(function ($salesInvoice) {
            if (is_object($salesInvoice)) {
                return $salesInvoice->id;
            } else {
                return $salesInvoice;
            }
        }, $this->sales_invoices);
        unset($aReminder['sales_invoices']);

        $this->connection->post($this->endpoint . '/send_reminders', json_encode([
            'sales_invoice_reminders' => [$aReminder],
        ]));
    }
}
