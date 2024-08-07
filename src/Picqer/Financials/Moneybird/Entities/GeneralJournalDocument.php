<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class GeneralJournalDocument.
 */
class GeneralJournalDocument extends Model
{
    use Filterable, FindAll, FindOne, Storable, Removable, Noteable, Synchronizable;

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $endpoint = 'documents/general_journal_documents';

    /**
     * @var string
     */
    protected $namespace = 'general_journal_document';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => GeneralJournalDocumentAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'general_journal_document_entries' => [
            'entity' => GeneralJournalDocumentEntry::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
