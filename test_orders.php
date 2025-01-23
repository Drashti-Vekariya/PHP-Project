
<?php
require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Initialize Razorpay API
$api_key = 'rzp_test_iicY1ZqsBx3QED';
$api_secret = 'kB89nJEPSKHaTn3ca3TrC6Y3';

$api = new Api($api_key, $api_secret);

// Fetch payment details from the client
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$razorpay_order_id = $_POST['razorpay_order_id'];
$razorpay_signature = $_POST['razorpay_signature'];

try {
    // Verify payment signature
    $attributes = [
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    ];
    $api->utility->verifyPaymentSignature($attributes);

    // Payment verified, process the order
    $email = $_SESSION['user']; // Assuming 'user' stores the logged-in email
    $address = $_SESSION['address'];
    $order_id = $_SESSION['order_id'];
    $total = $_SESSION['total'];
   // $order_array = $_SESSION['order_array'];

    // $order_total = $order_array['total'];
    // $order_discount = $order_array['discount'];
    // $offer_code = $order_array['offer_code'];
    
    // echo($email);
    // echo($address);
    // echo($order_id);
    // echo($total);
    // print_r($order_array);
    // echo($order_total);
    // echo($order_discount);
    // echo($offer_code);

    // Fetch cart items for the user
    $cart_query = "SELECT * FROM cart WHERE email = '$email'";
    $cart_result = mysqli_query($conn, $cart_query);

    if (!$cart_result || mysqli_num_rows($cart_result) == 0) {
        throw new Exception("Cart is empty or could not be fetched.");
    }

    // Loop through each cart item and process the order
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $p_id = $cart_row['p_id'];
        $qty = $cart_row['qty'];
        $total_price = $cart_row['total_price'];

        // Fetch product details
        $product_query = "SELECT * FROM products WHERE id = $p_id";
        $product_result = mysqli_query($conn, $product_query);

        if (!$product_result || mysqli_num_rows($product_result) == 0) {
            throw new Exception("Product ID $p_id not found.");
        }

        $product = mysqli_fetch_assoc($product_result);

        // Check stock availability
        if ($product['qty'] < $qty) {
            throw new Exception("Insufficient stock for Product ID $p_id.");
        }

        // Calculate discount and actual price
        $discount_amount = ($total_price / $order_total) * $order_discount;
        $actual_price = $total_price - $discount_amount;

        // Insert order into database
        $insert_order_query = "
            INSERT INTO orders 
            (order_id, sub_order_id, p_id, qty, email, delivery_address, sub_total, offer_name, discount_amount, actual_amount) 
            VALUES 
            ('$razorpay_order_id', '$razorpay_order_id-$p_id', $p_id, $qty, '$email', '$address', $total_price, '$offer_code', $discount_amount, $actual_price)";
        //echo($insert_order_query);
        if (!mysqli_query($conn, $insert_order_query)) {
            throw new Exception("Error inserting order: " . mysqli_error($conn));
        }

        // Update product stock
        $remaining_stock = $product['qty'] - $qty;
        $update_stock_query = "UPDATE products SET qty = $remaining_stock WHERE id = $p_id";

        if (!mysqli_query($conn, $update_stock_query)) {
            throw new Exception("Error updating stock for Product ID $p_id: " . mysqli_error($conn));
        }

        // Remove item from cart
        $delete_cart_query = "DELETE FROM cart WHERE email = '$email' AND p_id = $p_id";

        if (!mysqli_query($conn, $delete_cart_query)) {
            throw new Exception("Error deleting cart item for Product ID $p_id: " . mysqli_error($conn));
        }
    }


    // If everything is successful, return success response
    echo "success";
} catch (Exception $e) {
    // Handle exceptions and rollback if needed
    error_log("Error processing payment: " . $e->getMessage());
    echo "error: " . $e->getMessage();
}
?>
