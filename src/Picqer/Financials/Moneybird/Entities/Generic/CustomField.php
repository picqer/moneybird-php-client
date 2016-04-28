<?php namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class CustomField
 * @package Picqer\Financials\Moneybird\Entities\Generic
 */
abstract class CustomField extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'value'
    ];
}