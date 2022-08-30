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
 */
class Product extends Model
{
    use Search, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'title',
        'identifier',
        'price',
        'currency',
        'frequency',
        'frequency_type',
        'tax_rate_id',
        'ledger_account_id',
        'identifier',
        'product_type',
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
