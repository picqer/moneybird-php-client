<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


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
 * @property string created_at
 * @property string updated_at
 */
class ReceiptPayment extends Model
{
    
    protected $fillable = [
        'id',
        'invoice_type',
        'invoice_id',
        'financial_account_id',
        'user_id',
        'payment_transaction_id',
        'price',
        'price_base',
        'payment_date',
        'credit_invoice_id',
        'financial_mutation_id',
        'created_at',
        'updated_at',
    ];

    
    protected $namespace = 'payment';
}
