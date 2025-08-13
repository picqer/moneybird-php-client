<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Webhook.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $url
 * @property array $enabled_events
 * @property int|string|null $last_http_status
 * @property string|null $last_http_body
 * @property string $token
 */
class Webhook extends Model
{
    use FindAll, Storable, Removable;

    const JSON_OPTIONS = 0;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'url',
        'enabled_events',
        'last_http_status',
        'last_http_body',
        'token',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'webhooks';
}
