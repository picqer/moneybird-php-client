<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class DocumentStyle.
 */
class DocumentStyle extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'identity_id',
        'default',
        'logo_hash',
        'logo_container_full_width',
        'logo_display_width',
        'logo_position',
        'background_hash',
        'paper_size',
        'address_position',
        'font_size',
        'font_family',
        'print_on_stationary',
        'custom_css',
        'invoice_sender_address',
        'invoice_metadata_left',
        'invoice_metadata_right',
        'estimate_sender_address',
        'estimate_metadata_left',
        'estimate_metadata_right',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'document_styles';
}
