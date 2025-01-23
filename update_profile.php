<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['u_id'])) {
    header('Location: login_form.php');
    exit();
}

// Retrieve user information
$user_id = $_SESSION['u_id'];
$query = "SELECT name, email, profile_picture FROM user_form WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    //$email = htmlspecialchars($_POST['email']);

    // Handle profile picture upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $profilePic = basename($_FILES['profile_picture']['name']);
        $targetDir = "img/";
        $targetFile = $targetDir . $profilePic;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile);
    } else {
        $profilePic = $user['profile_picture']; // Keep current if not updated
    }

    // Update query
    $updateQuery = "UPDATE user_form SET name = '$name', profile_picture = '$profilePic' WHERE user_id = '$user_id'";
    mysqli_query($conn, $updateQuery);

    // Redirect to profile page
    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control {
            border-radius: 5px;
            color: #000; /* Ensures input text color is black */
        }

        .form-control:focus {
            color: #000; /* Ensures input text color is black when focused */
        }

        .btn-primary {
            background-color: #ff4d4d; /* Red color */
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #aaaaaa; /* Darker red on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container shadow">
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <h1>Update Profile</h1>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <!-- <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div> -->

                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture:</label>
                    <input type="file" name="profile_picture" class="form-control">
                    <!-- Display current profile picture if exists -->
                    <?php if (!empty($user['profile_picture'])) : ?>
                        <img src="img/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="img-thumbnail mt-2" width="100">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (Optional if needed for other functionalities) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
