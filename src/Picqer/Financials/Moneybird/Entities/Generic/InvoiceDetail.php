<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class InvoiceDetail.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $tax_rate_id
 * @property string|int $ledger_account_id
 * @property string|int|null $project_id
 * @property string|int|null $product_id
 * @property string|null $amount
 * @property string|null $amount_decimal
 * @property string $description
 * @property string $price
 * @property string|null $period
 * @property int $row_order
 * @property string $total_price_excl_tax_with_discount
 * @property string $total_price_excl_tax_with_discount_base
 * @property array $tax_report_reference
 * @property string|null $mandatory_tax_text
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property bool $is_optional
 * @property bool $is_selected
 * @property bool $_destroy
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
        'amount_decimal',
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
        'project_id',
        '_destroy',
    ];
}
