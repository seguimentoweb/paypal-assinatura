<?php
/** @var Plan $createdPlan */
//$createdPlan = require 'CreatePlan.php';
$createdPlan = $output;
use PayPal\Api\Plan;

try {
    $params = array('page_size' => '2');
    $planList = Plan::all($params, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("List of Plans", "Plan", null, $params, $ex);
    exit(1);
}
ResultPrinter::printResult("List of Plans", "Plan", null, $params, $planList);

dump($planList);
