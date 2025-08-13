<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class User.
 *
 * @property string|int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $email
 * @property bool $email_validated
 * @property string $language
 * @property string $time_zone
 * @property array $permissions
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
    ];

    /**
     * @var string
     */
    protected $endpoint = 'users';
}
