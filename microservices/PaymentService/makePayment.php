<?php
include 'paymentservice.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $datetime = $_POST['datetime'];
    $totalprice = $_POST['totalprice'];
    $paymentMethodType = $_POST['paymentMethodType'];

    $paymentMethod = null;
    switch ($paymentMethodType) {
        case 'credit_card':
            $paymentMethod = new CreditCardPayment();
            break;
        case 'paypal':
            $paymentMethod = new PayPalPayment();
            break;
        default:
            echo "Invalid payment method.";
            exit;
    }

    $payment = new Payment($id, $datetime, $totalprice, $paymentMethod);

    try {
        $payment->makePayment();
        echo "Payment processed successfully.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>