<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string url
 * @property string events
 * @property string last_http_status
 * @property string last_http_body
 */
class Webhook extends Model
{
    use FindAll, Storable, Removable;

    const JSON_OPTIONS = 0;

    
    protected $fillable = [
        'id',
        'url',
        'events',
        'last_http_status',
        'last_http_body',
    ];

    
    protected $endpoint = 'webhooks';
}
