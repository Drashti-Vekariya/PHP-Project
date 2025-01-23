<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    echo "<h2>Thank you for your order!</h2>";
    echo "<p>Your order ID is: <strong>$order_id</strong></p>";
} else {
    echo "<h2>Order not found!</h2>";
}
?>
