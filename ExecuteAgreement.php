<?php

require __DIR__ . '/bootstrap.php';

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();
    try {
        $agreement->execute($token, $apiContext);
    } catch (Exception $ex) {
        ResultPrinter::printError("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $ex);
        exit(1);
    }

    ResultPrinter::printResult("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $agreement);
    try {
        $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
    } catch (Exception $ex) {
        ResultPrinter::printError("Get Agreement", "Agreement", null, null, $ex);
        exit(1);
    }
    ResultPrinter::printResult("Get Agreement", "Agreement", $agreement->getId(), null, $agreement);
} else {
    ResultPrinter::printResult("User Cancelled the Approval", null);
}
