<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Event.
 *
 * @property string|int|null $administration_id
 * @property string|int $user_id
 * @property string $action
 * @property string|int|null $link_entity_id
 * @property string|null $link_entity_type
 * @property object $data
 * @property string|null $created_at
 * @property string|null $updated_at
 */
abstract class Event extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'administration_id',
        'user_id',
        'action',
        'link_entity_id',
        'link_entity_type',
        'data',
        'created_at',
        'updated_at',
    ];
}
