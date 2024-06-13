<?php
include 'paymentservice.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $datetime = $_POST['datetime'];
    $totalprice = $_POST['totalprice'];

    $paymentService = new PaymentService();
    $payment = $paymentService->getPaymentById($id);

    if ($payment) {
        try {
            $payment->setDatetime($datetime);
            $payment->setTotalprice($totalprice);
            $payment->update();
            echo "Payment updated successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Payment not found.";
    }
}
?>