<?php

// Check if order ID is passed in the URL
if (!isset($_GET['order_id'])) {
    echo "No order ID provided. Please go back and select a product.";
    exit;
}

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

// Fetch the order details from the database
$order_query = "SELECT order_id, sub_order_id, delivery_status, payment_status, sub_total, delivery_address, email FROM orders WHERE order_id = '$order_id'";
$order_result = mysqli_query($conn, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order = mysqli_fetch_assoc($order_result);
    // Safely extract the values
    $sub_total = isset($order['sub_total']) ? $order['sub_total'] : 'N/A';
    $delivery_address = isset($order['delivery_address']) ? $order['delivery_address'] : 'N/A';
    $email = isset($order['email']) ? $order['email'] : 'N/A';
    $sub_order_id = isset($order['sub_order_id']) ? $order['sub_order_id'] : 'N/A';
    $delivery_status = isset($order['delivery_status']) ? $order['delivery_status'] : 'N/A';
    $payment_status = isset($order['payment_status']) ? $order['payment_status'] : 'N/A';
} else {
    echo "Order not found.";
    exit;
}

require 'vendor/autoload.php';
use Razorpay\Api\Api;

// Razorpay API credentials
$api_key = 'rzp_test_iicY1ZqsBx3QED';
$api_secret = 'kB89nJEPSKHaTn3ca3TrC6Y3';
$api = new Api($api_key, $api_secret);

// Create Razorpay Order
try {
    $order_data = [
        'receipt' => 'order_rcptid_' . time(),
        'amount' => $sub_total * 100, // Amount in paise (multiply by 100)
        'currency' => 'INR'
    ];
    
    $razorpay_order = $api->order->create($order_data);
    $razorpay_order_id = $razorpay_order->id;
    $_SESSION['razorpay_order_id'] = $razorpay_order_id;
} catch (Exception $e) {
    echo "Error creating Razorpay order: " . $e->getMessage();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout -  Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<div class="container">
    <h1>Order Confirmation</h1>
    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
    <p><strong>Sub Order ID:</strong> <?php echo htmlspecialchars($sub_order_id); ?></p>
    <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($delivery_address); ?></p>
    <p><strong>Delivery Status:</strong> <?php echo htmlspecialchars($delivery_status); ?></p>
    <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($payment_status); ?></p>
    <p><strong>Subtotal:</strong> ₹<?php echo number_format($sub_total, 2); ?></p>

    <!-- Razorpay Payment Button -->
    <form action="payment_success.php" method="POST">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="razorpay_order_id" value="<?php echo htmlspecialchars($razorpay_order_id); ?>">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">

        <button id="rzp-button" type="submit">Pay Now</button>
    </form>

    <script>
        var options = {
            "key": "<?php echo $api_key; ?>", // Your Razorpay API key
            "amount": "<?php echo $sub_total * 100; ?>", // Amount in paise
            "currency": "INR",
            "name": "Drashti Vekariya",
            "description": "Order Payment",
            "image": "https://upload.wikimedia.org/wikipedia/en/5/5b/RK_University_logo.png", // Your logo image URL
            "order_id": "<?php echo $razorpay_order_id; ?>",
            "prefill": {
                "name": "Drashti Vekariya",
                "email": "<?php echo $email; ?>",
                "contact": "7436002729"
            },
            "theme": {
                "color": "#ff000"
            },
            "handler": function(response) {
                // Get the payment details
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                // Submit the form to the server
                document.forms[0].submit();
            }
        };

        var rzp = new Razorpay(options);
        document.getElementById('rzp-button').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        };
    </script>
</div>

</body>
</html>
