<?php

/** @var Plan $createdPlan */
//$createdPlan = require 'UpdatePlan.php';
$createdPlan = $plan;

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

/* Create a new instance of Agreement object
{
    "name": "Base Agreement",
    "description": "Basic agreement",
    "start_date": "2015-06-17T9:45:04Z",
    "plan": {
      "id": "P-1WJ68935LL406420PUTENA2I"
    },
    "payer": {
      "payment_method": "paypal"
    },
    "shipping_address": {
        "line1": "111 First Street",
        "city": "Saratoga",
        "state": "CA",
        "postal_code": "95070",
        "country_code": "US"
    }
}*/
$agreement = new Agreement();

$agreement->setName('Base Agreement')
    ->setDescription('Basic Agreement')
    ->setStartDate('2017-03-23T12:45:04Z'); // Data tem que ser maior que data atual

$plan = new Plan();
$plan->setId($createdPlan->getId());
$agreement->setPlan($plan);

$payer = new Payer();
$payer->setPaymentMethod('paypal');
$agreement->setPayer($payer);

$shippingAddress = new ShippingAddress();
$shippingAddress->setLine1('111 First Street')
    ->setCity('Saratoga')
    ->setState('CA')
    ->setPostalCode('95070')
    ->setCountryCode('US');
$agreement->setShippingAddress($shippingAddress);

$request = clone $agreement;
try {
    $agreement = $agreement->create($apiContext);
    $approvalUrl = $agreement->getApprovalLink();
} catch (Exception $ex) {
    ResultPrinter::printError("Created Billing Agreement.", "Agreement", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Billing Agreement. Please visit the URL to Approve.", "Agreement", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $agreement);

dump($agreement);
dump($approvalUrl);
