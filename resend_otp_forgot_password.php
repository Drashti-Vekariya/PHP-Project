<?php
@include 'includes/config.php';
session_start(); 

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];

    $query = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) == 0) {
        setcookie('error', "An OTP has already been sent. Please wait for it to expire.", time() + 5, "/");
        echo "<script>window.location.href = 'otp_form.php';</script>";
       
    }

    else {
        // Generate OTP
        $otp = rand(100000, 999999);

        $mail = new PHPMailer();
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'drashtivekariya209@gmail.com'; 
        $mail->Password = 'fapl nqax zhxh xhcp';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('drashtivekariya209@gmail.com', 'Drashti Vekariya');
        $mail->addAddress($email);

        // Content
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

        if ($mail->send()) {
            
            $created_at = date("Y-m-d H:i:s");
            $expiers_at = date("Y-m-d H:i:s", strtotime('+1 minutes')); // OTP valid for 1 minute
            $query = "INSERT INTO password_token (email, otp, created_at, expires_at) VALUES ('$email', '$otp', '$email_time', '$expiry_time')";
            mysqli_query($con, $query);

            
            setcookie('success', "New OTP has been sent to email.", time() + 5, "/");
            echo "<script>window.location.href = 'otp_form.php';</script>";
      
        } else {
           
            echo "<script>alert('Failed to send OTP email. Please try again later.');</script>";
        }
        
    }
} else {
  
    setcookie('error', "No email found. Please try again.", time() + 5, "/");
    echo "<script>window.location.href = 'Forgot_password.php';</script>";
}
