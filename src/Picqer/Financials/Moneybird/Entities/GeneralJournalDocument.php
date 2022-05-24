<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string reference
 * @property string date
 * @property string created_at
 * @property string updated_at
 * @property string general_journal_document_entries
 * @property string notes
 * @property string attachments
 */
class GeneralJournalDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Noteable;

    
    protected $fillable = [
        'id',
        'reference',
        'date',
        'created_at',
        'updated_at',
        'general_journal_document_entries',
        'notes',
        'attachments',
    ];

    
    protected $endpoint = 'documents/general_journal_documents';

    
    protected $namespace = 'general_journal_document';

    
    protected $multipleNestedEntities = [
        'general_journal_document_entries' => [
            'entity' => GeneralJournalDocumentEntry::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
