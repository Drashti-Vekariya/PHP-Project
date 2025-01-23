<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['u_id'])) {
    // Redirect to login page if user is not logged in
    header('Location: login_form.php');
    exit();
}

// Retrieve user information from the session
$user_id = $_SESSION['u_id'];
$query = "SELECT name, email, profile_picture FROM user_form WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    // Handle user not found
    echo "User not found.";
    exit();
}

// Prepare user data
$email = htmlspecialchars($user['email']);
$profilePic = !empty($user['profile_picture']) ? 'img/' . htmlspecialchars($user['profile_picture']) : 'img/default-profile.png'; // Fallback image
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile-style.css">
    <title>User Profile</title>
</head>

<body>
    <div class="main-container">
        <!-- LEFT-CONTAINER -->
        <div class="left-container container" style="margin-left: -70px;">
            <div class="menu-box block"> <!-- MENU BOX (LEFT-CONTAINER) -->
                <h2 class="titular" style="color:white">MENU BOX</h2>
                <ul class="menu-box-menu">
                    <li>
                        <a class="menu-box-tab" href="cart.php"><span class="icon entypo-basket scnd-font-color"></span>Cart</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="wishlist.php"><span class="icon entypo-heart scnd-font-color"></span>Wishlist</a>
                    </li>
                    <!-- <li>
                        <a class="menu-box-tab" href="track-order.php" target="_blank"><span class="icon entypo-location scnd-font-color"></span>Track Order</a>
                    </li> -->
                     <li>
                        <a class="menu-box-tab" href="products.php" target="_blank"><span class="icon entypo-tag scnd-font-color"></span>Products</a>
                    </li> 
                    <li>
                        <a class="menu-box-tab" href="index.php"><span class="icon entypo-home scnd-font-color"></span>Home Page</a>
                    </li>
                </ul>
            </div>

            <!-- MIDDLE-CONTAINER -->
             
            <div class="middle-container container" style="margin-left: 380px; margin-top: -380px;">
           
                <div class="profile block"> <!-- PROFILE (MIDDLE-CONTAINER) -->
                <h1 class="titular" style="color:red">Profile</h1>
                    <div style="padding-top: -10px;"></div>
                    <div class="profile-picture big-profile-picture clear">
                        <img width="150px" alt="user-profile" src="<?php echo htmlspecialchars($profilePic); ?>">
                    </div>
                    <h1 class="user-name">
                       Name : <?php echo htmlspecialchars($user['name']); ?>
                    </h1>
                    <p class="user-email" style="font-weight: bold; color: #333;">
                        Email: <span style="color: #007BFF;"><?php echo $email; ?></span>
                    </p>

                    <div class="profile-description">
                        <p class="scnd-font-color">Welcome To Interior!</p>
                    </div>
                    <a class="subscribe button" href="update_profile.php" style="color: white">EDIT</a>
                    <a class="subscribe button" href="logout.php" style="color: white">LOG OUT</a>
                </div>

                <!-- RIGHT-CONTAINER -->
                <div class="right-container container" style="margin-left: 380px; margin-top: -390px;">
                    <div class="join-newsletter block"> <!-- JOIN NEWSLETTER (RIGHT-CONTAINER) -->
                        <h2 class="titular">JOIN THE NEWSLETTER</h2>
                        <div class="input-container">
                            <input type="text" placeholder="yourname@gmail.com" class="email text-input">
                            <div class="input-icon envelope-icon-newsletter"><span class="fontawesome-envelope scnd-font-color"></span></div>
                        </div>
                        <a class="subscribe button" href="" style="color: white">SUBSCRIBE</a>
                    </div>
                </div> <!-- end right-container -->
            </div> <!-- end middle-container -->
        </div> <!-- end left-container -->
    </div> <!-- end main-container -->
</body>

</html>
