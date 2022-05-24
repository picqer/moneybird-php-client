<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string state
 * @property string budget
 */
class Project extends Model
{
    use FindAll, FindOne, Storable, Removable;

    
    protected $fillable = [
        'id',
        'name',
        'state',
        'budget',
    ];

    
    protected $endpoint = 'projects';

    
    protected $namespace = 'project';
}
