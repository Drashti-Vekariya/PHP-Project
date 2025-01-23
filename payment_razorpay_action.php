<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>INTERIOR</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

    <style>
    input, textarea {
        color: black !important;
    }
</style>

</head>
<body>
<?php
require 'vendor/autoload.php';
use Razorpay\Api\Api;
include_once("header.php");
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delivery_address_id = mysqli_real_escape_string($conn, $_POST['delivery_address_id']);
    $sub_total = $_POST['sub_total'];
    $payment_method = $_POST['payment_method']; // Fetch selected payment method

    // Check if delivery address ID is valid
    if (empty($delivery_address_id)) {
        echo "Please select a delivery address.";
        exit;
    }

    // Fetch the full delivery address from the database using the selected address ID
    $select_address_query = "SELECT delivery_address FROM address WHERE id = '$delivery_address_id'";
    $address_result = mysqli_query($conn, $select_address_query);
    if ($address_result && mysqli_num_rows($address_result) > 0) {
        $address = mysqli_fetch_assoc($address_result);
        $delivery_address = $address['delivery_address'];
    } else {
        echo "Invalid delivery address. Please try again.";
        exit;
    }

    // Calculate the total amount (adjust as needed)
    $total = $sub_total; // Replace with your actual total calculation logic

    // Insert the order into the database
    $order_id = 'order_' . time(); // Generate unique order ID
    $sub_order_id = 'sub_order_' . time(); // Generate unique sub-order ID
    $email = 'drashtivekariya209@gmail.com'; 

    // Insert the order details into the 'orders' table
    // $insert_order_query = "INSERT INTO orders (order_id, p_id, qty, delivery_address, sub_total, email, delivery_status, payment_status) 
    //                         VALUES ('$order_id', 1, 1, '$delivery_address', '$total', '$email', 'Pending', 'Unpaid')";

  // Insert order into the database
  $delivery_status = ($payment_method === 'cod') ? 'Ordered' : 'Pending';
  $payment_status = ($payment_method === 'cod') ? 'Pending COD' : 'Unpaid';


    $insert_order_query = "INSERT INTO orders (order_id,sub_order_id, p_id, qty, delivery_address, sub_total, email, delivery_status, payment_status) 
VALUES ('$order_id','$sub_order_id', 1, 1, '$delivery_address', '$total', '$email', 'Ordered', 'Pending')";

    $insert_result = mysqli_query($conn, $insert_order_query);
    if (!$insert_result) {
        echo "Error inserting order: " . mysqli_error($conn);
        exit;
    }

     // If COD is selected, skip Razorpay API integration
     if ($payment_method === 'cod') {
        echo "<script>alert('Order placed successfully with Cash on Delivery!');</script>";
        echo "<script>window.location.href = 'user_order.php';</script>";
        exit;
    }

    // Initialize Razorpay API
    $api_key = 'rzp_test_iicY1ZqsBx3QED';
    $api_secret = 'kB89nJEPSKHaTn3ca3TrC6Y3';
    $api = new Api($api_key, $api_secret);

    try {
        // Create a Razorpay order
        $order = $api->order->create([
            'receipt' => 'order_rcptid_' . time(),
            'amount' => $total * 100, // Amount in paise
            'currency' => 'INR'
        ]);
        // Get the order ID
        $razorpay_order_id = $order->id;
        $_SESSION['razorpay_order_id'] = $razorpay_order_id;
    } catch (Exception $e) {
        echo "Error creating Razorpay order: " . $e->getMessage();
        exit;
    }
}
?>

<div class="container">
    <div class="row text-center">
        <div class="col-12 bg-dark text-white p-2 align-center">
            <h1>Paying to Drashti Vekariya</h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="payment_razorpay_checkout.php" method="POST">
                <div class="form-group">
                    <label for="address"><b>Delivery Address</b></label>
                    <textarea class="form-control" id="address" name="address" rows="4" readonly><?php echo htmlspecialchars($delivery_address); ?></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="total"><b>Net Payable Amount</b></label>
                    <input type="text" class="form-control" value="<?php echo $total; ?>" disabled>
                </div>
                <br>
                <div class="form-group">
                    <label for="order_id"><b>Order ID</b></label>
                    <input type="text" class="form-control" value="<?php echo $razorpay_order_id; ?>" disabled>
                </div>
                <br>
                <button id="rzp-button" class="btn btn-danger">Pay Now</button></br>
                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                    
                    var options = {
                        "key": "<?php echo $api_key; ?>", // Enter the API key here
                        "amount": "<?php echo $total * 100; ?>", // Amount in paise
                        "currency": "INR",
                        "name": "Drashti Vekariya",
                        "description": "Test Transaction",
                        "image": "https://upload.wikimedia.org/wikipedia/en/5/5b/RK_University_logo.png",
                        "order_id": "<?php echo $razorpay_order_id; ?>", // Razorpay Order ID
                        "prefill": {
                            "name": "Drashti Vekariya",
                            "email": "drashtivekariya209@gmail.com",
                            "contact": "7436002729"
                        },
                        "theme": {
                            "color": "#ff000"
                        },
                        "handler": function(response) {
                            // Handle payment success
                            alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);

                            // Update the order payment status in the database
                            window.location.href = "user_order.php?payment_id=" + response.razorpay_payment_id + 
                            "&order_id=<?php echo $razorpay_order_id; ?>";
                        }
                    };
                    var rzp = new Razorpay(options);
                    document.getElementById('rzp-button').onclick = function(e) {
                        rzp.open();
                        e.preventDefault();
                    };
                </script>
                <input type="hidden" name="hidden">
            </form>
        </div>
    </div>
</div>


<?php 
include("footer.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/datepicker.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>
</html>
