<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ContactCustomField
 * @package Picqer\Financials\Moneybird\Entities
 */
class ContactCustomField extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'value',
    ];

}