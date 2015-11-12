<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class TypelessDocument
 * @package Picqer\Financials\Moneybird\Entities
 */
class TypelessDocument extends Model {

    use FindAll, FindOne, Storable, Removable;

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
    protected $url = 'documents/typeless_documents';

    /**
     * @var string
     */
    protected $namespace = 'typeless_document';
}