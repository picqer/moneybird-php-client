<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Note.
 *
 * @property string $id
 * @property string $note
 * @property bool $todo
 * @property string $assignee_id
 */
class Note extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'note',
        'todo',
        'assignee_id',
        'id',
        'note',
        'todo',
        'assignee_id',
        'user_id',
        'completed_by_id',
        'completed_at',
        'todo_type',
        'created_at',
    ];

    /**
     * @var string
     */
    protected $namespace = 'note';
}
