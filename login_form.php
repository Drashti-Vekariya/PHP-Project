<?php
@include 'config.php'; 
session_start(); 

$error = '';
$success = '';

if (isset($_POST['submit'])) {
  
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']); 
  

    $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass' AND status = 'active'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            
            $hashed_password = $row['password'];

            $_SESSION['admin_email'] = $row['email']; 
            $_SESSION['admin_profile_picture'] = $row['profile_picture'] ?? 'default-profile.png';  
            $_SESSION['admin_user'] = $row['email'];  
     

            $success = "Login successful as Admin!";
            // Redirect to dashboard after 2 seconds
            echo "<script>setTimeout(function(){ window.location.href = 'dashboard.php'; }, 2000);</script>";
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['u_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $success = "Login successful!";
         
            echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
        }
    } else {
        $error = "Incorrect email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/login-style.css">

    <script>
        function validateForm() {
            var email = document.forms["loginForm"]["email"].value;
            var password = document.forms["loginForm"]["password"].value;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var emailError = document.getElementById("email-error");
            var passwordError = document.getElementById("password-error");
            var errors = 0;

            emailError.innerHTML = "";
            passwordError.innerHTML = "";

            // Email validation
            if (email == "") {
                emailError.innerHTML = "Email must be filled out";
                showToast("Email must be filled out", false);
                errors++;
            } else if (!emailPattern.test(email)) {
                emailError.innerHTML = "Please enter a valid email address";
                showToast("Please enter a valid email address", false);
                errors++;
            }

            // Password validation
            if (password == "") {
                passwordError.innerHTML = "Password must be filled out";
                showToast("Password must be filled out", false);
                errors++;
            }

            return errors === 0;
        }

        function showToast(message, isSuccess = true) {
            const toastElement = document.getElementById('toastMessage');
            const toastBody = document.getElementById('toastMessageBody');

            toastBody.textContent = message;
            toastElement.classList.remove('bg-success', 'bg-danger');
            toastElement.classList.add(isSuccess ? 'bg-success' : 'bg-danger');

            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        window.onload = function() {
            <?php if ($error): ?>
                showToast('<?php echo $error; ?>', false);
            <?php elseif ($success): ?>
                showToast('<?php echo $success; ?>', true);
            <?php endif; ?>
        }
    </script>
</head>
<body>

<div class="form-container">
    <form name="loginForm" action="" method="post" onsubmit="return validateForm()"><br>
        <div class="logo">
            <img src="img/interiorlogo.jpg.webp" alt="logo" height="100px">
        </div><br>

        <h3 style="color:red;">Login Now</h3>

        <input type="email" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? $email : ''; ?>">
        <span id="email-error" style="color: red;"></span><br>

        <input type="password" name="password" placeholder="Enter your password">
        <span id="password-error" style="color: red;"></span><br>
        <a href="Forgot_password.php">Forgot Password</a></p>

        <input type="submit" name="submit" value="Login Now" class="form-btn">
        <p>Don't have an account? <a href="register_form.php">Register now</a></p>
    </form>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
            <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessageBody">
                    
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
