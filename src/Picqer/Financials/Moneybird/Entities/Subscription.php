<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Subscription.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $start_date
 * @property string|int $product_id
 * @property Product $product
 * @property string|null $cancelled_at
 * @property string|int $contact_id
 * @property Contact $contact
 * @property string|int|null $contact_person_id
 * @property Contact $contact_person
 * @property string|null $end_date
 * @property string $reference
 * @property string|int|null $document_style_id
 * @property string $frequency
 * @property string $frequency_type
 * @property array $subscription_products
 * @property string|int|null $recurring_sales_invoice_id
 */
class Subscription extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'start_date',
        'product_id',
        'product',
        'cancelled_at',
        'contact_id',
        'contact',
        'contact_person_id',
        'contact_person',
        'end_date',
        'reference',
        'document_style_id',
        'frequency',
        'frequency_type',
        'subscription_products',
        'recurring_sales_invoice_id',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'subscriptions';

    /**
     * @var string
     */
    protected $namespace = 'subscription';
}
