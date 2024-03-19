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
 */
class TypelessDocument extends Model
{
    use Attachment, Filterable, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
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
