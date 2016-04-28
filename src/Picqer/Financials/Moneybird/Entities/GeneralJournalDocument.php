<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Model;

/**
 * Class GeneralJournalDocument
 * @package Picqer\Financials\Moneybird\Entities
 */
class GeneralJournalDocument extends Model {

    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'reference',
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
}
