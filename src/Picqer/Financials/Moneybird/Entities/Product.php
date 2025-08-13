<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Search;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Product.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $title
 * @property string|null $description
 * @property string $identifier
 * @property string $price
 * @property string $currency
 * @property string $frequency
 * @property string $frequency_type
 * @property string|int $tax_rate_id
 * @property string|int $ledger_account_id
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends Model
{
    use Search, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'title',
        'description',
        'identifier',
        'price',
        'currency',
        'frequency',
        'frequency_type',
        'tax_rate_id',
        'ledger_account_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'products';

    /**
     * @var string
     */
    protected $namespace = 'product';

    /**
     * @param  string|int  $identifier
     * @return static
     *
     * @throws ApiException
     */
    public function findByIdentifier($identifier)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/identifier/' . urlencode($identifier));

        return $this->makeFromResponse($result);
    }
}
