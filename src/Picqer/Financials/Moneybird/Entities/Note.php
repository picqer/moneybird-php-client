<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string note
 * @property string todo
 * @property string assignee_id
 * @property string id
 * @property string note
 * @property string todo
 * @property string assignee_id
 * @property string user_id
 * @property string completed_by_id
 * @property string completed_at
 * @property string todo_type
 * @property string created_at
 */
class Note extends Model
{
    
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

    
    protected $namespace = 'note';
}
