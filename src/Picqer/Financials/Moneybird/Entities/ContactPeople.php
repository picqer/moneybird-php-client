<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ContactPeople.
 *
 * @property string $id
 * @property string $administration_id
 * @property string $firstname
 * @property string lastname
 * @property string phone
 * @property string email
 * @property string department
 * @property string created_at
 * @property string updated_at
 * @property string version
 */
class ContactPeople extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'department',
        'created_at',
        'updated_at',
        'version',
    ];
}
