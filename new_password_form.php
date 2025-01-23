<?php
@include 'includes/config.php';
session_start();

$error = '';
$success = '';

if (isset($_POST['reset_pwd_btn'])) {
    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $password = md5($_POST['password']); 

        $update_query = "UPDATE user_form SET password = '$password' WHERE email = '$email'";
        if (mysqli_query($con, $update_query)) {
            // Delete the OTP after a successful password reset
            $delete_query = "DELETE FROM password_token WHERE email = '$email'";
            mysqli_query($con, $delete_query);
            unset($_SESSION['forgot_email']);

            // Password reset successful, set cookie and redirect
            setcookie('success', 'Password has been reset successfully.', time() + 5, '/');
            echo "<script>window.location.href = 'login_form.php';</script>";
        } else {
            setcookie('error', 'Error in resetting Password.', time() + 5, '/');
            echo "<script>window.location.href='Forgot_password.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login-style.css">

    <script>
        function validateForm() {
            const password = document.forms["resetForm"]["password"].value;
            const confirm_password = document.forms["resetForm"]["confirm_password"].value;
            let valid = true;

            document.getElementById("password-error").innerHTML = "";
            document.getElementById("confirm-password-error").innerHTML = "";

            if (password === "") {
                document.getElementById("password-error").innerHTML = "Password must be filled out";
                valid = false;
            } else if (password.length < 8) {
                document.getElementById("password-error").innerHTML = "Password must be at least 8 characters long";
                valid = false;
            }

            if (confirm_password === "") {
                document.getElementById("confirm-password-error").innerHTML = "Please confirm your password";
                valid = false;
            } else if (password !== confirm_password) {
                document.getElementById("confirm-password-error").innerHTML = "Passwords do not match";
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>

<div class="form-container">
    <form name="resetForm" action="new_password_form.php" method="post" onsubmit="return validateForm()">
        <div class="logo">
            <img src="img/interiorlogo.jpg.webp" alt="logo" height="100px">
        </div><br>

        <h3 style="color:red;">Reset Password</h3>

        <input type="password" name="password" id="password" placeholder="Enter new password" class="form-control">
        <span id="password-error" style="color: red;"></span><br>

        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" class="form-control">
        <span id="confirm-password-error" style="color: red;"></span><br>

        <input type="submit" name="reset_pwd_btn" value="Submit" class="form-btn btn btn-primary">
        <p>Remembered your password? <a href="login_form.php">Login now</a></p>
    </form>
</div>

</body>
</html>
