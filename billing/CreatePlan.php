<?php

require __DIR__ . '/../bootstrap.php';

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

$plan = new Plan();
$plan->setName('Plano assinatura mensal')
    ->setDescription('Plano de assinatura mensal para o site mapa numerologico.')
    ->setType('infinite');

$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Pagamento Mensal')
    ->setType('REGULAR')
    ->setFrequency('MONTH')
    ->setFrequencyInterval("2")
    ->setAmount(new Currency(array('value' => '19.90', 'currency' => 'BRL')));

//$chargeModel = new ChargeModel();
//$chargeModel->setType('SHIPPING')
//    ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
//
//$paymentDefinition->setChargeModels(array($chargeModel));

$merchantPreferences = new MerchantPreferences();
$baseUrl = getBaseUrl();

$merchantPreferences->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
    ->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
    ->setAutoBillAmount("yes")
    ->setInitialFailAmountAction("CONTINUE")
    ->setMaxFailAttempts("0")
    ->setSetupFee(new Currency(array('value' => 0, 'currency' => 'BRL')));


$plan->setPaymentDefinitions(array($paymentDefinition));
$plan->setMerchantPreferences($merchantPreferences);

$request = clone $plan;

try {
    $output = $plan->create($apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);

//echo '<pre>';
//print_r($output);
