<?php
include 'paymentservice.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $paymentService = new PaymentService();
    $payment = $paymentService->getPaymentById($id);

    if ($payment) {
        try {
            $payment->confirmPayment();
            echo "Payment confirmed successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Payment not found.";
    }
}
?>