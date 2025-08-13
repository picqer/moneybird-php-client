<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ReceiptDetail.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $description
 * @property string $period
 * @property string $price
 * @property string $amount
 * @property string|int $tax_rate_id
 * @property string|int $ledger_account_id
 * @property string|int|null $project_id
 * @property string|int|null $product_id
 * @property string|null $amount_decimal
 * @property string|null $total_price_excl_tax_with_discount
 * @property string|null $total_price_excl_tax_with_discount_base
 * @property string|null $tax_report_reference
 * @property string|null $mandatory_tax_text
 * @property int $row_order
 * @property string $created_at
 * @property string $updated_at
 * @property bool $is_optional
 * @property bool $is_selected
 * @property bool $_destroy
 */
class ReceiptDetail extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'description',
        'period',
        'price',
        'amount',
        'tax_rate_id',
        'ledger_account_id',
        'project_id',
        'product_id',
        'amount_decimal',
        'total_price_excl_tax_with_discount',
        'total_price_excl_tax_with_discount_base',
        'tax_report_reference',
        'mandatory_tax_text',
        'row_order',
        'created_at',
        'updated_at',
        'is_optional',
        'is_selected',
        '_destroy',
    ];
}
