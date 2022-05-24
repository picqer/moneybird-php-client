<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string email
 * @property string email_validated
 * @property string language
 * @property string time_zone
 * @property string permissions
 */
class User extends Model
{
    use FindAll;

    
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
    ];

    
    protected $endpoint = 'users';
}
