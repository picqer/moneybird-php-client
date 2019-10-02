<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;

/**
 * Class GeneralJournalDocument.
 */
class GeneralJournalDocument extends Model
{
    use FindAll, FindOne, Storable, Removable;

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
        'general_journal_document_entries' => [
            'entity' => GeneralJournalDocumentEntry::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
