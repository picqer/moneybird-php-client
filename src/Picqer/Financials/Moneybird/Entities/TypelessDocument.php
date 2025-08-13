<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Attachment;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class TypelessDocument.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int|null $contact_id
 * @property Contact|null $contact
 * @property string|null $reference
 * @property string $date
 * @property string $state
 * @property string|null $origin
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 * @property array $attachments
 * @property array $events
 */
class TypelessDocument extends Model
{
    use Attachment, Filterable, FindAll, FindOne, Storable, Removable;

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
        'state',
        'origin',
        'version',
        'created_at',
        'updated_at',
        'attachments',
        'events',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'documents/typeless_documents';

    /**
     * @var string
     */
    protected $namespace = 'typeless_document';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => TypelessDocumentAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
