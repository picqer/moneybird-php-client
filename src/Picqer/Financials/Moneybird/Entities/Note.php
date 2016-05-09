<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Note
 * @package Picqer\Financials\Moneybird\Entities
 */
class Note extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'note',
        'todo',
        'assignee_id',
    ];

    /**
     * @var string
     */
    protected $namespace = 'note';
}
