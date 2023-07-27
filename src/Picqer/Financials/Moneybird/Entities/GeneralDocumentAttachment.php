<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class GeneralDocumentAttachment.
 */
class GeneralDocumentAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'documents/general_documents';
}
