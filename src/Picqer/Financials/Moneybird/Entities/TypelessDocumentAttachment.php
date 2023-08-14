<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class TypelessDocumentAttachment.
 */
class TypelessDocumentAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'documents/typeless_documents';
}
