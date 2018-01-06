<?php

namespace Academe\AuthorizeNet\Request\Transaction;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Academe\AuthorizeNet\Amount\Amount;
use Academe\AuthorizeNet\Request\Model\Order;
use Academe\AuthorizeNet\Request\Model\Surcharge;

class CaptureOnlyTest extends TestCase
{
    protected $transaction;

    public function setUp()
    {
        $amount = new Amount('GBP', 123);
        $this->transaction = new CaptureOnly($amount, 'AUTH123');
    }

    /**
     * A minimaal request.
     * The documentation does not make it clear whether the amount should be
     * a string or a float. We are going for a float for now, but have a hunch
     * that may need to be changed throughout.
     */
    public function testSimple()
    {
        $data = [
            'transactionType' => 'captureOnlyTransaction',
            'amount' => 1.23,
            'authCode' => 'AUTH123',
        ];

        $this->assertSame($data, $this->transaction->toData(true));

        $this->assertSame(
            '{"transactionType":"captureOnlyTransaction","amount":1.23,"authCode":"AUTH123"}',
            json_encode($this->transaction)
        );
    }

    /**
     * All parameters populated.
     */
    public function testFull()
    {
        $order = new Order('INV123', 'Description');

        $surcharge = new Surcharge(
            new Amount('GBP', 99),
            'Surcharge Description'
        );

        $transaction = $this->transaction->with([
            'terminalNumber' => 'TERM999',
            'order' => $order,
            'surcharge' => $surcharge,
            'merchantDescriptor' => 'Merchant Desc',
            'tip' => new Amount('GBP', 500),
        ]);

        $data = [
            'transactionType' => 'captureOnlyTransaction',
            'amount' => 1.23,
            'terminalNumber' => 'TERM999',
            'authCode' => 'AUTH123',
            'order' => [
                'invoiceNumber' => 'INV123',
                'description' => 'Description',
            ],
            'surcharge' => [
                'amount' => 0.99,
                'description' => 'Surcharge Description',
            ],
            'merchantDescriptor' => 'Merchant Desc',
            'tip' => 5,
        ];

        $this->assertSame($data, $transaction->toData(true));
    }
}
