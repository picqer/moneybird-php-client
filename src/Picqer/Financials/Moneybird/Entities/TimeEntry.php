<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

class TimeEntry extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $endpoint = 'time_entries';

    /**
     * @var string
     */
    protected $namespace = 'time_entry';

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'user' => User::class,
        'project' => Project::class,
        'detail' => SalesInvoiceDetail::class,
    ];
}
