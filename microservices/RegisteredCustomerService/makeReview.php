<?php
require 'classes.php'; 

$target_dir = "uploads/";

$unique_id = uniqid();
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . $unique_id . '.' . $imageFileType;

$check = getimagesize($_FILES["image"]["tmp_name"]);
if($check === false) {
    die("File is not an image.");
}

if ($_FILES["image"]["size"] > 500000) {
    die("Sorry, your file is too large.");
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    die("Sorry, only JPG, JPEG, & PNG files are allowed.");
}

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $observer = new CustomerObserver();
    $customer = new RegisteredCustomer('', '', '', '', '', '', '');
    $customer->attach($observer);
    $customer->makeReview($_POST['dest_id'], $_POST['user_id'], $_POST['rating'], $_POST['description'], $target_file, $_POST['datetime']);
    echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded as " . $unique_id . '.' . $imageFileType;
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
