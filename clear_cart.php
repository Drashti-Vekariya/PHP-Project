<?php
session_start();
include("config.php");

if (isset($_POST['clear_cart']) && $_POST['clear_cart'] == 1) {
    $u_id = $_SESSION['u_id'];
    
    // Clear cart items for the user
    $clear_cart_query = "DELETE FROM `cart` WHERE user_id = '$u_id'";
    if (mysqli_query($conn, $clear_cart_query)) {
        echo "Cart cleared successfully.";
    } else {
        echo "Error clearing cart.";
    }
}
?>
