<?php namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class InvoiceDetail
 * @package Picqer\Financials\Moneybird\Entities\Generic
 *
 * @property int $id
 * @property int $tax_rate_id
 * @property int $ledger_account_id
 * @property float|int $amount
 * @property string $description
 * @property mixed $period
 * @property mixed $price
 * @property mixed $row_order
 * @property mixed $total_price_excl_tax_with_discount
 * @property mixed $total_price_excl_tax_with_discount_base
 * @property mixed $tax_report_reference
 * @property int $created_at
 * @property int $updated_at
 */
abstract class InvoiceDetail extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'tax_rate_id',
        'ledger_account_id',
        'amount',
        'description',
        'period',
        'price',
        'row_order',
        'total_price_excl_tax_with_discount',
        'total_price_excl_tax_with_discount_base',
        'tax_report_reference',
        'created_at',
        'updated_at',
        'product_id',
        '_destroy'
    ];
}