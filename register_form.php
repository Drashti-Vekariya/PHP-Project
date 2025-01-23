<?php
@include 'config.php';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = []; // Initialize error array

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
  $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    // Handle file upload
    $profile_image = $_FILES['profile_image'];
    $image_name = time() . '_' . basename($profile_image['name']);
    $target_dir = "img/"; 
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if ($profile_image['size'] > 2000000) {
        echo "<script>showToast('Sorry, your file is too large.', false);</script>";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
        echo "<script>showToast('Sorry, only JPG, JPEG, PNG files are allowed.', false);</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>showToast('Sorry, your file was not uploaded.', false);</script>";
    } else {
        if (move_uploaded_file($profile_image['tmp_name'], $target_file)) {
            $select = "SELECT * FROM user_form WHERE email = '$email'";
            $result = mysqli_query($conn, $select);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>showToast('User already exists!', false);</script>";
            } else {
                if ($pass != $cpass) {
                    echo "<script>showToast('Passwords do not match!', false);</script>";
                } else {
                    $insert = "INSERT INTO user_form(name, email, password, user_type, profile_picture) VALUES('$name','$email','$pass','$user_type','$image_name')";
                    if (mysqli_query($conn, $insert)) {
                        // Send confirmation email
                        if (sendConfirmationEmail($email, $name)) {
                            echo "<script>showToast('Registration successful! Verify your email.', true);</script>";
                            header('location:login_form.php');
                        } else {
                            echo "<script>showToast('Registration successful, but email could not be sent.', false);</script>";
                        }
                    } else {
                        echo "<script>showToast('Error occurred during registration.', false);</script>";
                    }
                }
            }
        } else {
            echo "<script>showToast('Sorry, there was an error uploading your file.', false);</script>";
        }
    }
}


function sendConfirmationEmail($email, $name) {
    $mail = new PHPMailer(true); // Enable exceptions

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'drashtivekariya209@gmail.com'; 
        $mail->Password   = 'fapl nqax zhxh xhcp'; 
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; 

        $mail->setFrom('drashtivekariya209@gmail.com', 'Drashti');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $activation_link = "http://localhost/interior_design/verify_email.php?em=" . urlencode($email);
        $mail->Body    = "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; }
                    h1 { color: black; }
                    .button { display: inline-block; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px; }
                    .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                    a { text-decoration: none; color: white; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Welcome, $name!</h1>
                    <p>Thank you for registering. Please click the button below to activate your account:</p>
                    <p><a href='$activation_link' class='button'>Activate Your Account</a></p>
                    <p>If you didn't register on our website, please ignore this email.</p>
                    <div class='footer'>
                        <p>This is an automated message, please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // $_SESSION['error'] = "Error in sending email: ". $mail->ErrorInfo;
        setcookie('error', "Error in sending email: " . $mail->ErrorInfo, time() + 5);
        return false;
    }
    setcookie('success', 'Registration Successfull. Verify your Email using verification link sent to registered Email Address', time() + 5, "/");
    
}



function showToast($message, $isSuccess = true) {
    echo "<script>
            const toastElement = document.getElementById('toastMessage');
            const toastBody = document.getElementById('toastMessageBody');

            toastBody.textContent = '$message';
            toastElement.classList.remove('bg-success', 'bg-danger');
            toastElement.classList.add(" . ($isSuccess ? "'bg-success'" : "'bg-danger'") . ");

            const toast = new bootstrap.Toast(toastElement);
            toast.show();
          </script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/login-style.css">

    <script>
        function validateForm() {
            var name = document.forms["registerForm"]["name"];
            var email = document.forms["registerForm"]["email"];
            var password = document.forms["registerForm"]["password"];
            var cpassword = document.forms["registerForm"]["cpassword"];
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            document.getElementById("name-error").innerHTML = "";
            document.getElementById("email-error").innerHTML = "";
            document.getElementById("password-error").innerHTML = "";
            document.getElementById("cpassword-error").innerHTML = "";

            var isValid = true;

            if (name.value == "") {
                document.getElementById("name-error").innerHTML = "Name is required";
                showToast("Name is required", false);
                isValid = false;
            }

            if (email.value == "") {
                document.getElementById("email-error").innerHTML = "Email is required";
                showToast("Email is required", false);
                isValid = false;
            } else if (!emailPattern.test(email.value)) {
                document.getElementById("email-error").innerHTML = "Please enter a valid email address";
                showToast("Please enter a valid email address", false);
                isValid = false;
            }

            if (password.value == "") {
                document.getElementById("password-error").innerHTML = "Password is required";
                showToast("Password is required", false);
                isValid = false;
            }

            if (cpassword.value == "") {
                document.getElementById("cpassword-error").innerHTML = "Confirm Password is required";
                showToast("Confirm Password is required", false);
                isValid = false;
            } else if (password.value != cpassword.value) {
                document.getElementById("cpassword-error").innerHTML = "Passwords do not match";
                showToast("Passwords do not match", false);
                isValid = false;
            }

            return isValid;
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
    </script>

</head>
<body>

<div class="form-container">

    <form name="registerForm" action="" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
        <div class="logo">
            <img src="img/interiorlogo.jpg.webp" alt="" height="100px">
        </div>
        <h3 style="color:red;">Register Now</h3>

        <input type="text" name="name" placeholder="Enter your name">
        <span id="name-error" style="color:red;"></span><br>

        <input type="email" name="email" placeholder="Enter your email">
        <span id="email-error" style="color:red;"></span><br>

        <input type="password" name="password" placeholder="Enter your password">
        <span id="password-error" style="color:red;"></span><br>

        <input type="password" name="cpassword" placeholder="Confirm your password">
        <span id="cpassword-error" style="color:red;"></span><br>

        <input type="file" name="profile_image" accept="image/*">
        <span id="profile-image-error" style="color:red;"></span><br>

        <select name="user_type" >
            <option value="" disabled selected>Select user type</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <input type="submit" name="submit" value="Register" class="form-btn">
       
        <p>Already have an account? <a href="login_form.php">Login now</a></p>
    </form>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toastMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <!-- <div class="toast-header">
             <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> 
        </div> -->
        <div class="toast-body" id="toastMessageBody">
            
        </div>
    </div>
</div>

</body>
</html>
