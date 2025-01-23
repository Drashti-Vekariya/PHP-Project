<?php
session_start();
include 'config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if admin is not logged in
    header('Location: admin_login.php');
    exit();
}

// Retrieve admin information from the session
$admin_id = $_SESSION['admin_id'];
$query = "SELECT name, email, profile_picture FROM admin_form WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    // Handle admin not found
    echo "Admin not found.";
    exit();
}

// Prepare admin data
$adminEmail = htmlspecialchars($admin['email']);
$adminProfilePic = !empty($admin['profile_picture']) ? 'img/' . htmlspecialchars($admin['profile_picture']) : 'img/default-admin.png'; // Fallback image for admin
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile-style.css">
    <title>Admin Profile</title>
</head>

<body>
    <div class="main-container">
        <!-- LEFT-CONTAINER -->
        <div class="left-container container" style="margin-left: -70px;">
            <div class="menu-box block"> <!-- MENU BOX (LEFT-CONTAINER) -->
                <h2 class="titular" style="color:white">ADMIN MENU</h2>
                <ul class="menu-box-menu">
                    <li>
                        <a class="menu-box-tab" href="admin_dashboard.php"><span class="icon entypo-home scnd-font-color"></span>Dashboard</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="manage_users.php"><span class="icon entypo-users scnd-font-color"></span>Manage Users</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="manage_orders.php"><span class="icon entypo-box scnd-font-color"></span>Manage Orders</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="manage_products.php"><span class="icon entypo-basket scnd-font-color"></span>Manage Products</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="admin_settings.php"><span class="icon entypo-cog scnd-font-color"></span>Settings</a>
                    </li>
                </ul>
            </div>

            <!-- MIDDLE-CONTAINER -->
            <div class="middle-container container" style="margin-left: 380px; margin-top: -380px;">
                <div class="profile block"> <!-- PROFILE (MIDDLE-CONTAINER) -->
                    <h1 class="titular" style="color:red">Admin Profile</h1>
                    <div class="profile-picture big-profile-picture clear">
                        <img width="150px" alt="admin-profile" src="<?php echo htmlspecialchars($adminProfilePic); ?>">
                    </div>
                    <h1 class="user-name">
                        <?php echo htmlspecialchars($admin['name']); ?>
                    </h1>
                    <p class="user-email" style="font-weight: bold; color: #333;">
                        Email: <span style="color: #007BFF;"><?php echo $adminEmail; ?></span>
                    </p>

                    <div class="profile-description">
                        <p class="scnd-font-color">Welcome, Admin!</p>
                    </div>
                    <div class="profile-buttons">
                        <a class="subscribe button" href="update_admin_profile.php" style="color: white">Update</a>
                        <a class="subscribe button" href="admin_logout.php" style="color: white">LOG OUT</a>
                    </div>
                </div>

                <!-- RIGHT-CONTAINER -->
                <div class="right-container container" style="margin-left: 380px; margin-top: -390px;">
                    <div class="join-newsletter block"> <!-- JOIN NEWSLETTER (RIGHT-CONTAINER) -->
                        <h2 class="titular">ADMIN NEWSLETTER</h2>
                        <div class="input-container">
                            <input type="text" placeholder="adminemail@example.com" class="email text-input">
                            <div class="input-icon envelope-icon-newsletter"><span class="fontawesome-envelope scnd-font-color"></span></div>
                        </div>
                        <a class="subscribe button" href="#21" style="color: white">SUBSCRIBE</a>
                    </div>
                </div> <!-- end right-container -->
            </div> <!-- end middle-container -->
        </div> <!-- end left-container -->
    </div> <!-- end main-container -->
</body>

</html>
