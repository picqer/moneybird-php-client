<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class SalesInvoiceReminder
 * @package Picqer\Financials\Moneybird\Entities
 */
class SalesInvoiceReminder extends Model {

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $namespace = 'sales_invoice_reminders';

    /**
     * Pushes the reminder.
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
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
            'sales_invoice_reminders' => [$aReminder]
        ]));
    }
}
