<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string identity_id
 * @property string default
 * @property string logo_hash
 * @property string logo_container_full_width
 * @property string logo_display_width
 * @property string logo_position
 * @property string background_hash
 * @property string paper_size
 * @property string address_position
 * @property string font_size
 * @property string font_family
 * @property string print_on_stationary
 * @property string custom_css
 * @property string invoice_sender_address
 * @property string invoice_metadata_left
 * @property string invoice_metadata_right
 * @property string estimate_sender_address
 * @property string estimate_metadata_left
 * @property string estimate_metadata_right
 * @property string created_at
 * @property string updated_at
 */
class DocumentStyle extends Model
{
    use FindAll;

    
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

    
    protected $endpoint = 'document_styles';
}
