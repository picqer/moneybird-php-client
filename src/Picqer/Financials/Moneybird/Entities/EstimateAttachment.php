<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Entities\Generic\Attachment;

/**
 * Class EstimateAttachment.
 */
class EstimateAttachment extends Attachment
{
    /**
     * @var string
     */
    protected $endpoint = 'estimates';
}
