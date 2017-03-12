# PHP Value Objects for Authorize.Net

For now, just exploring some ideas.

```php
<?php

use Academe\AuthorizeNetObjects;
use Academe\AuthorizeNetObjects\Auth;
use Academe\AuthorizeNetObjects\Amount;
use Academe\AuthorizeNetObjects\Payment;
use Academe\AuthorizeNetObjects\Request;
use Academe\AuthorizeNetObjects\Collections;

// Composer: moneyphp/money
use Money\Money;

require 'vendor/autoload.php';

echo "<pre>";

// Set up authorisation details.
$auth = new Auth\MerchantAuthentication('xxx', 'yyy');

// Create a credit card.
$credit_card = new Payment\CreditCard('4000123412341234', '1220', '123');

// Or create a magnetic stri track (only one can be used).
$track1 = new Payment\Track1('TTTTTTTTTTTTTTTT11111');
$track2 = new Payment\Track2('TTTTTTTT2222222222222222');

// Create order details.
$order = new Request\Model\Order('orderx', 'ordery');

// Create customer detals.
$customer = new Request\Model\Customer('business', 'Customer ID', 'customer@example.com');

// Create retail flags
$retail = new Request\Model\Retail(2, 3, 'HJSHDJSDJKSD');

// Create a billing name and address.
$billTo = new Request\Model\NameAddress('BFirstname', 'BLastname');
$billTo = $billTo->withCompany('My Billing Company Ltd')->withZip('ZippyZipBill');

// Create a shipping name and address.
$shipTo = new Request\Model\NameAddress('Firstname', 'Lastname');
$shipTo = $shipTo->withCompany('My Company Ltd')->withZip('ZippyZip');

// Create a total amount of £24.99
$amount = new Amount\Amount('GBP', 2499);
// Or maybe just £19.99
$amount = $amount->withMajorUnit(19.99);

// Better still, use moneyphp/money to set the amount to £15.49
$money_php_object = Money::GBP(1549);
$amount = new Amount\MoneyPhp($money_php_object);

// Create tax amount.
// All parameters have a with*() method available.
$tax = new Request\Model\ExtendedAmount();
$tax = $tax->withName('Tax Name')->withDescription('Tax Description');
$tax = $tax->withAmount(new Amount\MoneyPhp(Money::GBP(99));

// Set up some line items.
$lineItems = new Collections\LineItems();
$lineItems->push(new Request\Model\ListItem(1, 'Item Name 1', 'Item Desc 1', 1.5, new Amount\MoneyPhp(Money::GBP(49)), false));
$lineItems->push(new Request\Model\ListItem(2, 'Item Name 2', 'Item Desc 2', 2, new Amount\MoneyPhp(Money::GBP(97)), true));

// Set up some transaction settings.
$transactionSettings = new Collections\TransactionSettings();
$transactionSettings->push(new Request\Model\Setting('Foo', 'Bar'));

// And add some user fields.
$userFields = new Collections\UserFields();
$userFields->push(new Request\Model\UserField('UserFoo', 'UserBar'));

// Now put most of these into an Auth Capture transaction.
$auth_capture_transaction_request = new Request\Model\AuthCaptureTransaction($amount);
$auth_capture_transaction_request = $auth_capture_transaction_request->withPayment(/*$track1*/ $credit_card);
$auth_capture_transaction_request = $auth_capture_transaction_request->withCreateProfile(false);
$auth_capture_transaction_request = $auth_capture_transaction_request->withTaxExempt(true);
$auth_capture_transaction_request = $auth_capture_transaction_request->withLineItems($lineItems);
$auth_capture_transaction_request = $auth_capture_transaction_request->withTransactionSettings($transactionSettings);
$auth_capture_transaction_request = $auth_capture_transaction_request->withUserFields($userFields);
$auth_capture_transaction_request = $auth_capture_transaction_request->withSolutionId('SOLLLL');
$auth_capture_transaction_request = $auth_capture_transaction_request->withOrder($order);
$auth_capture_transaction_request = $auth_capture_transaction_request->withTax($tax);
$auth_capture_transaction_request = $auth_capture_transaction_request->withDuty($tax);
$auth_capture_transaction_request = $auth_capture_transaction_request->withShipping($tax);
$auth_capture_transaction_request = $auth_capture_transaction_request->withPoNumber('myPoNumber');
$auth_capture_transaction_request = $auth_capture_transaction_request->withCustomer($customer);
$auth_capture_transaction_request = $auth_capture_transaction_request->withRetail($retail);
$auth_capture_transaction_request = $auth_capture_transaction_request->withShipTo($shipTo)->withBillTo($billTo);

// Add the auth capture transaction to the transaction request, along with the auth details.
$transaction_request = new Request\CreateTransaction($auth, $auth_capture_transaction_request);

// Add some final settings that go into the rerquest.
$transaction_request = $transaction_request->withEmployeeId('1234');

// Display the resultng JSON request message.
echo "<textarea style='width:100%;height: 12em'>" . $transaction_request->getObjectName() . ' is ' . json_encode($transaction_request) . "</textarea>";

/*
{
   "createTransactionRequest":{
      "merchantAuthentication":{
         "name":"xxx",
         "transactionKey":"yyy"
      },
      "employeeId":"1234",
      "transactionRequest":{
         "transactionType":"authCaptureTransaction",
         "amount":"9.99",
         "payment":{
            "creditCard":{
               "cardNumber":"4000123412341234",
               "expirationDate":"1220",
               "cardCode":"123"
            }
         },
         "profile":{
            "createProfile":false
         },
         "solution":{
            "id":"SOLLLL"
         },
         "order":{
            "invoiceNumber":"orderx",
            "description":"ordery"
         },
         "lineItems":[
            {
               "itemId":1,
               "name":"Item Name 1",
               "description":"Item Desc 1",
               "quantity":1.5,
               "unitPrice":"0.49",
               "taxable":false
            },
            {
               "itemId":2,
               "name":"Item Name 2",
               "description":"Item Desc 2",
               "quantity":2,
               "unitPrice":"0.97",
               "taxable":true
            }
         ],
         "tax":{
            "amount":"9.99",
            "name":"Tax Name",
            "description":"Tax Description"
         },
         "duty":{
            "type":"business",
            "id":"Customer ID",
            "email":"customer@example.com"
         },
         "shipping":{
            "amount":"9.99",
            "name":"Tax Name",
            "description":"Tax Description"
         },
         "taxExempt":true,
         "poNumber":"myPoNumber",
         "billTo":{
            "firstName":"BFirstname",
            "lastName":"BLastname",
            "company":"My Billing Company Ltd",
            "zip":"ZippyZipBill"
         },
         "shipTo":{
            "marketType":2,
            "deviceType":3,
            "customerSignature":"HJSHDJSDJKSD"
         },
         "transactionSettings":[
            {
               "settingName":"Foo",
               "settingValue":"Bar"
            }
         ],
         "userFields":[
            {
               "name":"UserFoo",
               "value":"UserBar"
            }
         ]
      }
   }
}
*/
```
