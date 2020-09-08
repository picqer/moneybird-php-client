<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Event.
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
