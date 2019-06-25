<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ContactCustomField.
 *
 * @property string $id
 * @property string $name
 * @property string $value
 */
class ContactCustomField extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'value',
    ];
}
