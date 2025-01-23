<?php 
session_start();
include_once('includes/config.php');

if (!isset($_SESSION['admin_name'])) {
    header('Location: login_form.php');
    exit();
}

$adminName = htmlspecialchars($_SESSION['admin_name']);
$adminEmail = htmlspecialchars($_SESSION['admin_email'] ?? 'Email not available');
$adminProfilePic = htmlspecialchars('img/' . ($_SESSION['admin_profile_picture'] ?? 'default-profile.png')); 

if (!file_exists($adminProfilePic)) {
    $adminProfilePic = 'img/default-profile.png';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['admin_name'])) {
        $adminName = htmlspecialchars($_POST['admin_name']);
        $_SESSION['admin_name'] = $adminName;

        if (isset($_FILES['admin_profile_picture']) && $_FILES['admin_profile_picture']['error'] == 0) {
            $targetDir = 'img/';
            $targetFile = $targetDir . basename($_FILES['admin_profile_picture']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['admin_profile_picture']['tmp_name'], $targetFile)) {
                    $_SESSION['admin_profile_picture'] = basename($_FILES['admin_profile_picture']['name']);
                    $adminProfilePic = htmlspecialchars($targetFile); 
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include_once('includes/header.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Admin Profile</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user me-1"></i>
                            Profile Details
                        </div>
                        <div class="card-body">
                            <div class="profile-container text-center">
                                <img src="<?php echo $adminProfilePic; ?>" alt="Admin Profile Picture" class="rounded-circle mb-3" width="150" height="150">
                                <h2><?php echo $adminName; ?></h2>
                                <p><?php echo $adminEmail; ?></p>
                                <hr>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <h3>Edit Profile</h3>
                                    <div class="mb-3">
                                        <label for="adminName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="adminName" name="admin_name" value="<?php echo $adminName; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="adminProfilePic" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" id="adminProfilePic" name="admin_profile_picture">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                    <br><br>
                                    <a href="dashboard.php" class="btn btn-secondary">Go to Dashboard</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
