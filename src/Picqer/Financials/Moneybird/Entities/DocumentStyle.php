<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class DocumentStyle.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $name
 * @property string|int $identity_id
 * @property bool $default
 * @property string|null $logo_hash
 * @property bool $logo_container_full_width
 * @property int $logo_display_width
 * @property string $logo_position
 * @property string|null $background_hash
 * @property string $paper_size
 * @property string $address_position
 * @property string $font_size
 * @property string $font_family
 * @property bool $print_on_stationery
 * @property string|null $custom_css
 * @property string|null $invoice_sender_address
 * @property string|null $invoice_metadata_left
 * @property string|null $invoice_metadata_right
 * @property string|null $estimate_sender_address
 * @property string|null $estimate_metadata_left
 * @property string|null $estimate_metadata_right
 * @property string $created_at
 * @property string $updated_at
 */
class DocumentStyle extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
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
        'print_on_stationery',
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
