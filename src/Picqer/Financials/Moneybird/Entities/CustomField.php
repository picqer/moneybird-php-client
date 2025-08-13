<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class CustomField.
 *
 * @property string|int|null $id
 * @property string|int|null $administration_id
 * @property string $name
 * @property string|null $source
 */
class CustomField extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'name',
        'source',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'custom_fields';
}
