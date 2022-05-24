<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * @property string id
 * @property string user_id
 * @property string user
 * @property string started_at
 * @property string ended_at
 * @property string paused_duration
 * @property string contact_id
 * @property string project_id
 * @property string project
 * @property string detail_id
 * @property string detail
 * @property string description
 * @property string billable
 */
class TimeEntry extends Model
{
    use FindAll, FindOne, Storable, Removable;

    
    protected $fillable = [
        'id',
        'user_id',
        'user',
        'started_at',
        'ended_at',
        'paused_duration',
        'contact_id',
        'project_id',
        'project',
        'detail_id',
        'detail',
        'description',
        'billable',
    ];

    
    protected $endpoint = 'time_entries';

    
    protected $namespace = 'time_entry';

    
    protected $singleNestedEntities = [
        'user' => User::class,
        'project' => Project::class,
        'detail' => SalesInvoiceDetail::class,
    ];
}
