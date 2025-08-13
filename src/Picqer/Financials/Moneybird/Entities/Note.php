<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class Note.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $entity_id
 * @property string $entity_type
 * @property string $note
 * @property bool $todo
 * @property string|int|null $assignee_id
 * @property string|int|null $user_id
 * @property string|null $completed_at
 * @property string|int|null $completed_by_id
 * @property string|null $todo_type
 * @property array $data
 * @property string $created_at
 * @property string $updated_at
 */
class Note extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'entity_id',
        'entity_type',
        'note',
        'todo',
        'assignee_id',
        'user_id',
        'completed_at',
        'completed_by_id',
        'todo_type',
        'data',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $namespace = 'note';
}
