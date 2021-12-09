<?php

namespace Picqer\Financials\Moneybird\Actions;

use Picqer\Financials\Moneybird\Entities\Note;
use Picqer\Financials\Moneybird\Exceptions\ApiException;

/**
 * Class Noteable.
 */
trait Noteable
{
    use BaseTrait;

    /**
     * Add a note to the current object.
     *
     * @param  Note  $note
     * @return $this
     *
     * @throws ApiException
     */
    public function addNote(Note $note)
    {
        $this->connection()->post($this->getEndpoint() . '/' . urlencode($this->id) . '/notes',
            $note->jsonWithNamespace()
        );

        return $this;
    }
}
