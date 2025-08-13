<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class TimeEntry.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $user_id
 * @property User $user
 * @property string $started_at
 * @property string $ended_at
 * @property string $paused_duration
 * @property string|int $contact_id
 * @property string|int $project_id
 * @property Project $project
 * @property string|int|null $sales_invoice_id
 * @property string|int $detail_id
 * @property SalesInvoiceDetail $detail
 * @property string $description
 * @property bool $billable
 * @property Contact $contact
 * @property SalesInvoice $sales_invoice
 * @property string $created_at
 * @property string $updated_at
 * @property array $events
 * @property array $notes
 */
class TimeEntry extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'user_id',
        'user',
        'started_at',
        'ended_at',
        'paused_duration',
        'contact_id',
        'project_id',
        'project',
        'sales_invoice_id',
        'detail_id',
        'detail',
        'description',
        'billable',
        'contact',
        'sales_invoice',
        'created_at',
        'updated_at',
        'events',
        'notes',
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
