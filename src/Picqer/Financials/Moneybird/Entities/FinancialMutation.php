<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialMutation
 * @package Picqer\Financials\Moneybird\Entities
 */
class FinancialMutation extends Model {

    use FindAll, Filterable, Synchronizable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'amount',
        'code',
        'date',
        'message',
        'contra_account_name',
        'contra_account_number',
        'state',
        'amount_open',
        'sepa_fields',
        'batch_reference',
        'financial_account_id',
        'currency',
        'original_amount',
        'created_at',
        'updated_at',
        'financial_statement_id',
        'processed_at',
        'payments',
        'ledger_account_bookings',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_mutations';

    /**
     * @param string $bookingType
     * @param string | int $bookingId
     * @param string | float $priceBase
     * @param string | float $price
     * @param string $description
     * @param string $paymentBatchIdentifier
     *
     * @return int
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function linkToBooking($bookingType, $bookingId, $priceBase, $price = null, $description = null, $paymentBatchIdentifier = null)
    {
        if (!in_array($bookingType, ['SalesInvoice', 'Document', 'LedgerAccount', 'PaymentTransactionBatch', 'NewPurchaseInvoice', 'NewReceipt'])) {
            throw new ApiException('Invalid booking type to link FinancialMutation');
        }
        if (!is_numeric($bookingId)) {
            throw new ApiException('Invalid Booking identifier to link FinancialMutation');
        }

        //Filter out potential NULL values
        $parameters = array_filter(
            array(
                'booking_type' => $bookingType,
                'booking_id' => $bookingId,
                'price_base' => $priceBase,
                'price' => $price,
                'description' => $description,
                'payment_batch_identifier' => $paymentBatchIdentifier,
            )
        );

        return $this->connection->patch($this->endpoint . '/' . $this->id . '/link_booking', json_encode($parameters));
    }
}
