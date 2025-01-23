<?php
 
@include 'config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$error = '';
$success = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/login-style.css">

    <script>
        function validateForm() {
            var email = document.forms["forgotPasswordForm"]["email"].value;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var emailError = document.getElementById("email-error");
            var errors = 0;

           
            emailError.innerHTML = "";

            if (email == "") {
                emailError.innerHTML = "Email must be filled out";
                showToast("Email must be filled out", false);
                errors++;
            } else if (!emailPattern.test(email)) {
                emailError.innerHTML = "Please enter a valid email address";
                showToast("Please enter a valid email address", false);
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
    <form name="forgotPasswordForm" action="Forgot_password.php" id="form1" method="post" onsubmit="return validateForm()"><br>
        <div class="logo">
            <img src="img/interiorlogo.jpg.webp" alt="logo" height="100px">
        </div><br>

        <h3 style="color:red;">Forgot Password</h3>

        <input type="email" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? $email : ''; ?>">
        <span id="email-error" style="color: red;"></span><br>

        <input type="submit" name="submit" value="Submit" class="form-btn">
        <p>Remember your password? <a href="login_form.php">Login here</a></p>
    </form>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
            <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessageBody">
                        <!-- Sample Message -->
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);
    $_SESSION['forgot_email'] = $email;

    if (mysqli_num_rows($result) > 0) {
        
        $otp = rand(100000, 999999);

       
        $mail = new PHPMailer(true); 

        try
        {
        
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'drashtivekariya209@gmail.com'; 
            $mail->Password = 'fapl nqax zhxh xhcp'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('drashtivekariya209@gmail.com', 'Drashti Vekariya');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                    h1 { color: black; }
                    .otp { font-size: 24px; font-weight: bold; color: #007bff; }
                    .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Forgot Your Password?</h1>
                    <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                    <p class='otp'>$otp</p>
                    <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                    <p>If you did not request a password reset, please ignore this email.</p>
                    <div class='footer'>
                        <p>This is an automated message, please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();

            $_SESSION['otp'] = $otp;
            $_SESSION['forgot_email'] = $email;
            $success = "OTP has been sent to your email.";

            $email_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime('+10 minutes')); 
            $query = "INSERT INTO password_token (email, otp, created_at, expires_at) VALUES ('$email', '$otp', '$email_time', '$expiry_time')";
            mysqli_query($conn, $query);

            $_SESSION['forgot_email'] = $email;
             setcookie('success', "OTP for resetting your password is sent to the registered mail address", time() + 2, "/");
             echo "<script>setTimeout(function(){ window.location.href = 'otp_form.php'; }, 2000);</script>";
            exit;

        }
        catch (Exception $e) 
        {
            setcookie('error', $mail->ErrorInfo, time() + 2, "/");
            echo "<script>setTimeout(function(){ window.location.href = 'Forgot_password.php'; }, 2000);</script>";
        }
    } 
    else 
    {
        $error = "Email is not registered";
    }
    
    // echo $_SESSION['forgot_email'];


           
    //     }
    //     else 
    //     {
    //     setcookie('error', "Email is not registered", time() + 5, "/");
    //     echo "<script>setTimeout(function(){ window.location.href = 'Forgot_password.php'; }, 2000);</script>";
    //     }

}
?>