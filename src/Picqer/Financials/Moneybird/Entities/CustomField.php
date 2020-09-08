<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class CustomField.
 */
class CustomField extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'source',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'custom_fields';
}
