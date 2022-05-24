<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string administration_id
 * @property string entity_type
 * @property string old_id
 * @property string new_id
 */
class ImportMapping extends Model
{
    use FindAll, FindOne;

    
    protected $type;

    
    protected $fillable = [
        'administration_id',
        'entity_type',
        'old_id',
        'new_id',
    ];

    
    protected $endpoint = 'import_mappings';

    
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getEndpoint()
    {
        if (null === $this->type) {
            return $this->endpoint;
        }

        return $this->endpoint . '/' . $this->type;
    }
}
