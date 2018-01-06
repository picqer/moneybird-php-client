<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Model;

/**
 * Class ImportMapping
 * @package Picqer\Financials\Moneybird\Entities
 */
class ImportMapping extends Model {

    use FindAll, FindOne;

    protected $type = null;

    /**
     * @var array
     */
    protected $fillable = [
        'administration_id',
        'entity_type',
        'old_id',
        'new_id',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'import_mappings';

    /**
     * @param string $type The type of import mapping to request
     *
     * Type should be any of: financial_account bank_mutation contact document_attachment general_journal identity
     * incoming_invoice attachment payment history invoice_attachment transaction ledger_account tax_rate product
     * print_invoice recurring_template invoice workflow document_style
     * @return $this
     */
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
