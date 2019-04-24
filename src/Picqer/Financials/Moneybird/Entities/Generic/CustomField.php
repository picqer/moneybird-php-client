<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class CustomField.
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
