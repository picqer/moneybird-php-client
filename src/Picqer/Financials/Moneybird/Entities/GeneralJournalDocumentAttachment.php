<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class GeneralJournalDocumentAttachment.
 */
class GeneralJournalDocumentAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'documents/general_journal_documents';
}
