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

   
<style>
    .out-of-stock {
            filter: blur(5px); /* Adjust the blur intensity as needed */
            opacity: 0.5; /* Optional: reduce opacity to make it look more faded */
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
<?php
include("header.php");
if (!isset($_SESSION['u_id'])) {
    $u_id = "";
} else {
    $u_id = $_SESSION['u_id'];
}

// Fetch the user's email
$select_user = mysqli_query($conn, "SELECT email, name FROM `user_form` WHERE user_id = '$u_id'") or die('query failed');
$user = mysqli_fetch_assoc($select_user);

// Check if the query returned a result
if ($user) {
    $user_name = $user['name'];
    $email = $user['email'];  // Now we have the user's email
} else {
    $user_name = "Guest";  // Default value if user not found
    $email = "";  // Default email for guest users
}

$cart_rows_number = 0;
$select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$u_id'") or die('query failed');
$cart_rows_number = mysqli_num_rows($select_cart_number);
?>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row w-100">
            <div class="col-lg-12 col-md-12 col-12">
                <p class="mb-5 text-center">
                <center>
                 <h2>
                     <b><?php echo $user_name; ?>'s shopping Cart</b><br> 
                </h2>
                <h3>
                    <b><?php echo $cart_rows_number; ?></b> items in your cart
                </p></b>
            </center></br>
                <?php
                $sub_total = 0;
                include("config.php");
                if (isset($_SESSION['u_id'])) {
                    ?>
                    <table id="shoppingCart" class="table table-condensed table-responsive">
                        <thead>
                            <tr>
                                <th style="width:60%">Product</th>
                                <th style="width:12%">Price</th>
                                <th style="width:10%">Quantity</th>
                                <th style="width:18%">Total</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $u_id = $_SESSION['u_id'];
                            $sql = "SELECT * FROM `cart` WHERE user_id = '$u_id'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and print the product data
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cart_id = $row['cart_id'];
                                    $p_id = $row["p_id"];
                                    $p_name = $row["p_name"];
                                    $p_img = $row["p_img"];
                                    $qty = $row['qty'];
                                    $p_price = $row["p_price"];
                                    $p_desc = $row["p_desc"];
                                    
                                    // Fetch discount from the products table
                                    $product_query = "SELECT p_discount FROM `products` WHERE p_id = '$p_id'";
                                    $product_result = mysqli_query($conn, $product_query);
                                    $product = mysqli_fetch_assoc($product_result);
                                    $p_discount = isset($product['p_discount']) ? $product['p_discount'] : 0; // default to 0 if no discount

                                    if (isset($_POST['update_qty_' . $p_id])) {
                                        $new_qty = $_POST['qty_' . $p_id];
                                        mysqli_query($conn, "UPDATE `cart` SET `qty` = '$new_qty' WHERE `cart_id` = '$cart_id'") or die('query failed');
                                        echo "<script>alert('Quantity updated');";
                                        echo "window.location.href ='cart.php'</script>";
                                    }

                                    if (isset($_POST['delete_' . $p_id])) {
                                        $delete_id = $cart_id;
                                        mysqli_query($conn, "DELETE FROM `cart` WHERE `cart_id` = '$delete_id'") or die('query failed');
                                        echo "<script>alert('product removed from the cart');";
                                        echo "window.location.href ='cart.php'</script>";
                                    }

                                    // Calculate discounted price
                                    $discounted_price = $p_discount > 0 
                                    ? $p_price - ($p_price * $p_discount / 100)
                                    : $p_price;

                                    // Calculate total for this product
                                    $total_price = $discounted_price * $qty;

                                   // Check if the product is out of stock 
                                   $stock_query = "SELECT qty FROM `products` WHERE p_id = '$p_id'"; $stock_result = mysqli_query($conn, $stock_query); $stock_data = mysqli_fetch_assoc($stock_result); $stock_quantity = $stock_data['qty']; // Only add to subtotal if the product is in stock
                                    if ($stock_quantity > 0) { $sub_total += $total_price; } else { $total_price = 0; // Set total price to 0 if out of stock 
                                        }
                                    ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-md-3 text-left">
                                                    <img src="img\<?php echo $p_img; ?>" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow "
                                                    style="<?php echo ($stock_quantity == 0) ? 'filter: blur(2px);' : ''; ?>">
                                                </div>
                                                <div class="col-md-9 text-left mt-sm-2">
                                                    <h4><?php echo $p_name; ?></h4>
                                                    <?php 
                // Check if the product is out of stock
                $stock_query = "SELECT qty FROM `products` WHERE p_id = '$p_id'";
                $stock_result = mysqli_query($conn, $stock_query);
                $stock_data = mysqli_fetch_assoc($stock_result);
                $stock_quantity = $stock_data['qty'];

                if ($stock_quantity == 0) {
                    echo '<p class="text-danger" style="font-size: 24px;">Out of Stock</p>';  // Display Out of Stock message
                }
                ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">
                        <?php 
                        if ($p_discount > 0) {
                            echo '<h4><span class="text-muted" style="text-decoration: line-through;">₹' . $p_price . '</span></h4>';
                            echo '<h4>₹' . $discounted_price . '</h4>';
                            echo '<small style="color: green;">(' . $p_discount . '% off)</small>';
                        } else {
                            echo '<h4>₹' . $p_price . '</h4>';
                        }
                        ?>
                    </td>
                                        <td data-th="Quantity">
        <form action="" method="post">
            <input type="number" class="form-control form-control-lg text-center" value="<?php echo $qty; ?>" min="1" max="<?php echo $stock_quantity; ?>" name="qty_<?php echo $p_id; ?>" <?php echo ($stock_quantity == 0) ? 'disabled' : ''; ?>>  <!-- Disable quantity selection if out of stock -->
    </td>
    <td data-th="Total"> <h4>₹<?php echo ($stock_quantity == 0) ? 0 : $total_price; ?></h4> </td>
    <td class="actions" data-th="Operation">
        <div class="text-left">
            <button class="btn btn-white border-secondary bg-white btn-md mb-2" value="update" name="update_qty_<?php echo $p_id; ?>" <?php echo ($stock_quantity == 0) ? 'disabled' : ''; ?>>
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button class="btn btn-white border-secondary bg-white btn-md mb-2" value="delete" name="delete_<?php echo $p_id; ?>" <?php echo ($stock_quantity == 0) ? 'disabled' : ''; ?>>
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </td>
    
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<center>Your cart is empty</center></br></br>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="float-right text-right">
                        <h4>Subtotal:</h4>
                        <h1>₹<?php echo $sub_total; ?></h1>
                    </div>
                </div>
            </div>

            <?php

if (isset($_SESSION['u_id'])) {
    
            
// Fetch saved addresses
$addresses = [];
$result = mysqli_query($conn, "SELECT * FROM address");
if ($result)
 {
    while ($row = mysqli_fetch_assoc($result)) {
        $addresses[] = $row;
    }
}
}
?>
<!-- Select Shipping Address Section -->
<div class="row text-center mt-5">
    <div class="col">
        <h2 class="text-danger">Select Shipping Address</h2>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        
            <!-- <form action="payment_razorpay_action.php" method="post"> -->
                <div class="list-group">
                <?php if (!empty($addresses)): ?>
                    <?php foreach ($addresses as $address): ?>
                        <div class="card" style="border: 1px solid black;padding-left:10px; ">
                            <?php echo $address['delivery_address']; ?>
                            <br>
                            </div>

                        <div class="mt-3 text-right">
                            <!-- Edit and Select Address -->
                            <a href="edit_delivery_address.php?id=<?= $address['id']; ?>" class="btn btn-warning btn-sm">Edit Address</a>
                            <!-- Proceed to Payment Button -->

                            <!-- Deliver to this Address Button -->
                             <!-- Deliver to this Address Button -->
                             <button 
                                class="btn btn-danger btn-sm" 
                                onclick="deliverAddress(<?= $address['id']; ?>, '<?= htmlspecialchars($address['delivery_address']); ?>')">
                                Deliver to this Address
                            </button>
                    </div>

                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Hidden fields to pass subtotal and selected address -->
                <input type="hidden" name="sub_total" value="<?php echo $sub_total; ?>">
            </form>
        <?php else: ?>
            <p class="text-danger">No addresses available. Please add an address.</p>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col text-center">
        </br>
        
        <a href="add_delivery_address.php" class="btn btn-danger mb-4 btn-mm pl-5 pr-5">Add Another Address</a>
    </div></br>
</div>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div id="selected-address-card" class="card d-none shadow" style="border: 1px solid #ccc;margin-left:190px; padding: 15px; border-radius: 12px;">
            <h3 class="card-header text-white bg-dark text-center">Selected Address</h3>
            <div class="card-body text-center">
                <p id="selected-address-text" class="text-muted">No address selected yet.</p>
            </div>
        </div>
    </div>
</div>
        
              
    <div class="container">
    <div class="row mt-4 d-flex align-items-right" style="margin-top:20px">
        <div class="col-sm-6 order-md-2 text-right" style="margin-left:600px">
            <!-- Payment Form -->
            <form action="payment_razorpay_action.php" method="post" id="payment-form">
                <input type="hidden" name="sub_total" value="<?php echo $sub_total; ?>">
                <input type="hidden" name="delivery_address_id" id="selected-address-id">
                
                <!-- Payment Method Radio Buttons -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="pay_now" value="razorpay" checked>
                    <label class="form-check-label" for="pay_now">
                        
                        Pay Now (Razorpay)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                    <label class="form-check-label" for="cod">
                        Cash on Delivery (COD)
                    </label>
                </div>
                
                <!-- Submit Button -->
                <!-- <input type="submit" class="btn btn-dark" value="Proceed to Checkout" id="submit-btn"> -->
                <form method="post" onsubmit="return clearCart()"> 
                    <input type="hidden" name="subtotal" value="<?php echo $sub_total; ?>"> <button type="submit" class="btn btn-danger btn-lg w-100" onclick="return clearCart()">Proceed to Checkout</button> </form>
            </form>
        </div><br/><br/></br>
        
        <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left" style="margin-left:-1200px">
            <a href="products.php" class="btn btn-danger mb-4 btn-lg pl-5 pr-5">Continue Shopping</a>
        </div>
    </div>
</div>

<script>
function clearCart() {
    // Clear the cart from local storage (if used)
    localStorage.removeItem('cart');
    
    // Add your AJAX call or any other logic to clear the cart on the server-side here
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "clear_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("clear_cart=1");
    
    return true; // Proceed with form submission
}
</script>


<script>
document.getElementById('submit-btn').onclick = function(e) {
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

    if (selectedPaymentMethod === 'cod') {
        alert('Processing your Cash on Delivery order...');
        return true; // Allow form submission for COD
    }
};
</script>

        </section>


        </form>
    </div>
</div>
<script>
function deliverAddress(addressId, addressText) {
    // Prevent the default button behavior
    event.preventDefault();

    // Decode HTML entities in the address text
    const textarea = document.createElement('textarea');
    textarea.innerHTML = addressText;
    const decodedAddress = textarea.value;

    // Save the selected address to localStorage
    localStorage.setItem('selectedAddress', decodedAddress);

    // Update the UI to display the selected address
    const card = document.getElementById('selected-address-card');
    const addressField = document.getElementById('selected-address-text');

    addressField.textContent = decodedAddress; // Set the decoded address text
    card.classList.remove('d-none'); // Make the card visible
    card.classList.add('d-block');


    // Set the hidden input field with the address ID
    document.getElementById('selected-address-id').value = addressId;
    
}
</script>


<?php include("footer.php"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/datepicker.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>
</html>
