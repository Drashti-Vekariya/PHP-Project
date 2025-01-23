<?php 
include_once('includes/config.php');

if (isset($_SESSION['admin_email'])) {
    $admin_email = $_SESSION['admin_email'];
} else {
    $admin_email = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Banners</title>
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
                    <h1 class="mt-4">Manage Banners</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Banners</li>
                    </ol>

                    <!-- Upload New Banner -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-upload me-1"></i>
                            Upload New Banner
                        </div>
                        <div class="card-body">
                            <form action="admin-banner.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="banner_image">Upload Banner Image:</label>
                                    <input type="file" name="banner_image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="alt_text">Alt Text:</label>
                                    <input type="text" name="alt_text" class="form-control" required>
                                </div>
                                <button type="submit" name="upload_banner" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- Display Existing Banners -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-images me-1"></i>
                            Existing Banners
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Alt Text</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch banners from the database
                                    $sql = "SELECT * FROM banners ORDER BY id DESC";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td><img src="' . $row['image_url'] . '" alt="' . $row['alt_text'] . '" style="width:100px;"></td>';
                                            echo '<td>' . $row['alt_text'] . '</td>';
                                            echo '<td>';
                                            echo '<a href="admin-banner.php?delete=' . $row['id'] . '" class="btn btn-danger">Delete</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No banners found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
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

<?php
// Handle banner image upload
if (isset($_POST['upload_banner'])) {
    // Check if there's already a banner
    $sql = "SELECT * FROM banners LIMIT 1"; // Limit to 1 to check existence
    $result = $con->query($sql);

    if ($result->num_rows >= 1) {
        echo "<script>alert('Only one banner can be uploaded. Please delete the existing banner first.');</script>";
    } else {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["banner_image"]["name"]);
        $alt_text = $_POST['alt_text'];

        // Check if image file is a valid image type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png", "avif");

        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
                // Insert into database
                $sql = "INSERT INTO banners (image_url, alt_text) VALUES ('$target_file', '$alt_text')";
                if ($con->query($sql) === TRUE) {
                    echo "<script>alert('Banner uploaded successfully!');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG & AVIF files are allowed.');</script>";
        }
    }
}

// Handle banner deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Fetch the image path
    $sql = "SELECT image_url FROM banners WHERE id='$id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_url'];

        // Check if the image file exists before deleting it
        if (file_exists($image_path)) {
            if (unlink($image_path)) {  // Try to delete the image file
                // Delete the banner from the database
                $sql = "DELETE FROM banners WHERE id='$id'";
                if ($con->query($sql) === TRUE) {
                    echo "<script>alert('Banner deleted successfully!');</script>";
                } else {
                    echo "Error deleting banner from database: " . $con->error;
                }
            } else {
                echo "<script>alert('Failed to delete the image file.');</script>";
            }
        } else {
            echo "<script>alert('Image file does not exist.');</script>";
        }
    } else {
        echo "<script>alert('Banner not found.');</script>";
    }
}
?>
