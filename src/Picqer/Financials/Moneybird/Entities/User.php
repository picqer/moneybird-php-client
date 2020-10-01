<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class User.
 */
class User extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'email',
        'email_validated',
        'language',
        'time_zone',
        'permissions',
        'sales_invoices',
        'documents',
        'estimates',
        'bank',
        'settings',
        'ownership',
        'time_entries',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'users';
}
