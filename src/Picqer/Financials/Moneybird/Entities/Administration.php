<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Administration
 * @package Picqer\Financials\Moneybird\Entities
 */
class Administration extends Model {

    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'language',
        'currency',
        'country',
        'time_zone',
    ];

    /**
     * @var string
     */
    protected $url = 'administrations';
}