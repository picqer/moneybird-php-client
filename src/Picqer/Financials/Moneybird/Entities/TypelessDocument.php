<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Attachment;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string contact_id
 * @property string reference
 * @property string date
 * @property string state
 * @property string origin
 * @property string created_at
 * @property string updated_at
 * @property string attachments
 */
class TypelessDocument extends Model
{
    use Attachment, FindAll, FindOne, Storable, Removable;

    
    protected $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'state',
        'origin',
        'created_at',
        'updated_at',
        'attachments',
    ];

    
    protected $endpoint = 'documents/typeless_documents';

    
    protected $namespace = 'typeless_document';
}
