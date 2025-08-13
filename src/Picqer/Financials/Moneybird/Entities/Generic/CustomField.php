<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class CustomField.
 *
 * @property string|int $id
 * @property string $name
 * @property string $value
 */
abstract class CustomField extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'value',
    ];
}
