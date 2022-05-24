<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string amount
 * @property string code
 * @property string date
 * @property string message
 * @property string contra_account_name
 * @property string contra_account_number
 * @property string state
 * @property string amount_open
 * @property string sepa_fields
 * @property string batch_reference
 * @property string financial_account_id
 * @property string currency
 * @property string original_amount
 * @property string created_at
 * @property string updated_at
 * @property string financial_statement_id
 * @property string processed_at
 * @property string payments
 * @property string ledger_account_bookings
 * @property string account_servicer_transaction_id
 */
class FinancialMutation extends Model
{
    use FindAll, Filterable, Synchronizable;

    
    private static $allowedBookingTypesToLinkToFinancialMutation = [
        'Document',
        'ExternalSalesInvoice',
        'LedgerAccount',
        'NewPurchaseInvoice',
        'NewReceipt',
        'Payment',
        'PaymentTransaction',
        'PaymentTransactionBatch',
        'PurchaseTransaction',
        'PurchaseTransactionBatch',
        'SalesInvoice',
    ];

    
    private static $allowedBookingTypesToUnlinkFromFinancialMutation = [

        'LedgerAccountBooking',
        'Payment',
    ];

    
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

    
    protected $endpoint = 'financial_mutations';

    
    protected $multipleNestedEntities = [
        'ledger_account_bookings' => [
            'entity' => LedgerAccountBooking::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    
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
