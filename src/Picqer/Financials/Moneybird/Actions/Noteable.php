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

    /**
     * Delete a note from the current object.
     *
     * @param  Note|string  $note  Note object or note ID
     * @return $this
     *
     * @throws ApiException
     */
    public function deleteNote(Note|string $note)
    {
        if (! is_string($note)) {
            $note = $note->id;
        }

        $this->connection()->delete($this->getEndpoint() . '/' . urlencode($this->id) . '/notes/' . $note);

        return $this;
    }
}
