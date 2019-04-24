<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;

/**
 * Class FinancialMutation.
 *
 * @property  LedgerAccountBooking[] $ledger_account_bookings
 */
class FinancialMutation extends Model
{
    use FindAll, Filterable, Synchronizable;

    /**
     * @see https://developer.moneybird.com/api/financial_mutations/#patch_financial_mutations_id_link_booking
     *
     * @var array
     */
    private static $allowedBookingTypesToLinkToFinancialMutation = [
        'Document',
        'LedgerAccount',
        'NewPurchaseInvoice',
        'NewReceipt',
        'PaymentTransactionBatch',
        'SalesInvoice',
    ];

    /**
     * @see https://developer.moneybird.com/api/financial_mutations/#delete_financial_mutations_id_unlink_booking
     *
     * @var array
     */
    private static $allowedBookingTypesToUnlinkFromFinancialMutation = [

        'LedgerAccountBooking',
        'Payment',
    ];

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
        'account_servicer_transaction_id',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_mutations';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'ledger_account_bookings' => [
            'entity' => LedgerAccountBooking::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

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
        if (! in_array($bookingType, self::$allowedBookingTypesToLinkToFinancialMutation, true)) {
            throw new ApiException('Invalid booking type to link to FinancialMutation, allowed booking types: ' . implode(', ', self::$allowedBookingTypesToLinkToFinancialMutation));
        }
        if (! is_numeric($bookingId)) {
            throw new ApiException('Invalid Booking identifier to link to FinancialMutation');
        }

        //Filter out potential NULL values
        $parameters = array_filter(
            [
                'booking_type' => $bookingType,
                'booking_id' => $bookingId,
                'price_base' => $priceBase,
                'price' => $price,
                'description' => $description,
                'payment_batch_identifier' => $paymentBatchIdentifier,
            ]
        );

        return $this->connection->patch($this->endpoint . '/' . $this->id . '/link_booking', json_encode($parameters));
    }

    /**
     * @param string $bookingType
     * @param string | int $bookingId
     *
     * @return array
     * @throws ApiException
     */
    public function unlinkFromBooking($bookingType, $bookingId)
    {
        if (! in_array($bookingType, self::$allowedBookingTypesToUnlinkFromFinancialMutation, true)) {
            throw new ApiException('Invalid booking type to unlink from FinancialMutation, allowed booking types: ' . implode(', ', self::$allowedBookingTypesToUnlinkFromFinancialMutation));
        }
        if (! is_numeric($bookingId)) {
            throw new ApiException('Invalid Booking identifier to unlink from FinancialMutation');
        }

        $parameters = [
            'booking_type' => $bookingType,
            'booking_id' => $bookingId,
        ];

        return $this->connection->delete($this->endpoint . '/' . $this->id . '/unlink_booking', json_encode($parameters));
    }
}
