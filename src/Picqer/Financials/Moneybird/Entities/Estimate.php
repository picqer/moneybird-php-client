<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Contact
 * @package Picqer\Financials\Moneybird
 *
 * @property integer $id
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 */
class Estimate extends Model
{

    use FindAll, FindOne, Storable, Removable, Synchronizable, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'contact',
        'esimate_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'state',
        'estimate_date',
        'due_date',
        'reference',
        'language',
        'currency',
        'exchange_rate',
        'discount',
        'original_estimate_id',
        'show_tax',
        'sign_online',
        'sent_at',
        'accepted_at',
        'rejected_at',
        'archived_at',
        'created_at',
        'updated_at',
        'pre_text',
        'post_text',
        'details',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'url',
        'custom_fields',
        'notes',
        'attachments',
    ];

    /**
     * @var string
     */
    protected $url = 'estimates';

    /**
     * @var string
     */
    protected $namespace = 'estimate';

}
