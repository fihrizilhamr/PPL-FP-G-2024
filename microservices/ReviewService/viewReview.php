<?php
require 'classes.php'; 

if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
    $observer = new ReviewObserver();
    $reviewService = new ReviewService();
    $reviewService->attach($observer);
    $review = $reviewService->viewReview($review_id);
    if ($review) {
        $image_html = "<img src='{$review['image_path']}' alt='Review Image'>";
        
        echo json_encode(array(
            'data' => $review,
            'image_html' => $image_html
        ));
    } else {
        echo "Review not found.";
    }
} else {
    echo "Invalid request.";
}
?>
