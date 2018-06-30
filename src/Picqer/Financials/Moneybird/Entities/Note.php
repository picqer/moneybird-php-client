<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Note
 * @package Picqer\Financials\Moneybird\Entities
 *
 * @property string $id
 * @property string $note
 * @property boolean $todo
 * @property string $assignee_id
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
