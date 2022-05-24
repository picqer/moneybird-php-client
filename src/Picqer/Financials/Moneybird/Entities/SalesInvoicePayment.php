<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\InvoicePayment;


/**
 * @property string id
 * @property string invoice_type
 * @property string invoice_id
 * @property string financial_account_id
 * @property string user_id
 * @property string payment_transaction_id
 * @property string price
 * @property string price_base
 * @property string payment_date
 * @property string credit_invoice_id
 * @property string financial_mutation_id
 * @property string transaction_identifier
 * @property string manual_payment_action
 * @property string ledger_account_id
 * @property string created_at
 * @property string updated_at
 */
class SalesInvoicePayment extends InvoicePayment
{
}
