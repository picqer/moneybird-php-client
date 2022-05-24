<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string contact_id
 * @property string reference
 * @property string date
 * @property string due_date
 * @property string entry_number
 * @property string state
 * @property string exchange_rate
 * @property string created_at
 * @property string updated_at
 * @property string notes
 * @property string attachments
 */
class GeneralDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Noteable;

    
    protected $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'exchange_rate',
        'created_at',
        'updated_at',
        'notes',
        'attachments',
    ];

    
    protected $endpoint = 'documents/general_documents';

    
    protected $namespace = 'general_document';
}
