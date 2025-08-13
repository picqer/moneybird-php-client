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
 * Class GeneralDocument.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $contact_id
 * @property Contact $contact
 * @property string $reference
 * @property string $date
 * @property string $due_date
 * @property string $entry_number
 * @property string $state
 * @property string $exchange_rate
 * @property string $created_at
 * @property string $updated_at
 * @property array $notes
 * @property array $attachments
 * @property int $version
 * @property array $events
 */
class GeneralDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact',
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
        'version',
        'events',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'documents/general_documents';

    /**
     * @var string
     */
    protected $namespace = 'general_document';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => GeneralDocumentAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
