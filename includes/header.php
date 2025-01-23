<?php
// Start the session at the beginning of the script
session_start();
date_default_timezone_set('Asia/Kolkata');


// Debugging: Check session variables
if (!isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    echo "Session variables not set. Please login to set the session variables.";
    // You may redirect the user to login if needed:
    // header("Location: login.php");
    // exit;
}

// Check the database connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Set the current time and delete expired tokens
$current_time = date("Y-m-d H:i:s");
$delete_query = "DELETE FROM password_token WHERE expires_at < '$current_time'";
mysqli_query($con, $delete_query);

// Get the current URL and its path
$url = $_SERVER['REQUEST_URI'];
$parsed_url = parse_url($url);
$url1 = $parsed_url['path'];
$parts = explode("/", $url1);

// Check if the user is logged in and if the profile picture is set in the session
if (isset($_SESSION['admin_logged_in']) && !empty($_SESSION['profile_picture'])) {
    // If a profile picture is set, use it
    $profilePic = 'img/' . htmlspecialchars($_SESSION['profile_picture']);
} else {
    // If no profile picture is set, use a default image
    $profilePic = 'img/default-profile.png';
}

// Optionally, include admin's name and email for display in the dropdown
$adminName = isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin';
$adminEmail = isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : 'No Email Set';
?>

<!-- Your HTML code for the navbar goes here -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">INTERIOR</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <form method="post" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="search-result.php">
        <div class="input-group">
            <!-- <input class="form-control" type="text" name="searchdata" placeholder="Search for note..." aria-label="Search for..." aria-describedby="btnNavbarSearch" required />
            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button> -->
        </div>
    </form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- Display Profile Image in Navbar -->
                <!-- <img src="<?php echo $profilePic; ?>" alt="User Profile" class="rounded-circle" width="30" height="30"> -->
                <span><?php echo $adminName; ?></span>
                 <!-- Admin Name -->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li class="text-center p-3">
                    <div class="card" style="width: 18rem; margin: 0 auto;">
                        <div class="card-body">
                            <!-- <img src="<?php echo $profilePic; ?>" alt="User Profile" class="rounded-circle mb-2" width="100" height="100"> -->
                            <h5 class="card-title"><?php echo $adminName; ?></h5>
                            <!-- Check if 'admin_email' is set before displaying it -->
                            <p class="card-text"><?php echo $adminEmail; ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="my-profile.php" class="btn btn-primary btn-sm mb-2">View Profile</a>
                            <a href="admin_change_password.php" class="btn btn-warning btn-sm mb-2">Change Password</a>
                            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
