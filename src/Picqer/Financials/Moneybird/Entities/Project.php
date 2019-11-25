<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Project
 * @package Picqer\Financials\Moneybird\Entities
 */
class Project extends Model {

    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'state',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'projects';

    /**
     * @var string
     */
    protected $namespace = 'project';
}
