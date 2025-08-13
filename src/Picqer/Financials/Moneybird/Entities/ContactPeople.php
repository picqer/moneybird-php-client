<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class ContactPeople.
 *
 * @property string|int $id
 * @property string|int $contact_id
 * @property string|int $administration_id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $department
 * @property string $created_at
 * @property string $updated_at
 * @property int $version
 */
class ContactPeople extends Model
{
    use FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
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

    protected $namespace = 'contact_person';

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'contacts/' . $this->contact_id . '/contact_people';
    }
}
