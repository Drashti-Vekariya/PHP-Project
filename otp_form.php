<?php
@include 'includes/config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/login-style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script> <!-- jQuery Validation Plugin -->
    <script>
        $(document).ready(function() {
            $("#form1").validate({
                rules: {
                    otp: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    }
                },
                messages: {
                    otp: {
                        required: "Please enter the OTP",
                        digits: "Please enter a valid OTP",
                        minlength: "OTP must be 6 digits",
                        maxlength: "OTP must be 6 digits"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });
        });
    </script>
</head>
<body>

<div class="form-container">
    <form action = "otp_form.php" id="form1" method="post"><br>
        <div class="logo">
            <img src="img/interiorlogo.jpg.webp" alt="logo" height="100px">
        </div><br>

        <h3 style="color:red;">OTP Verification</h3>

        <div class="form-group">
            <label for="otp"><b>OTP:</b></label>
            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" name="otp">
            <div id="otp-error" class="invalid-feedback"></div>
        </div>
        <br>
        <div id="timer" class="text-danger"></div>
        <br>
        <input type="button" id="resend_otp" class="btn btn-warning" style="display:none;" value="Resend OTP">
        
        <script>
            let timeLeft = 60; // timer(second)
            const timerDisplay = document.getElementById('timer');
            const resendButton = document.getElementById('resend_otp');

            function startCountdown() {
                const countdown = setInterval(() => {
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        timerDisplay.innerHTML = "You can now resend the OTP.";
                        resendButton.style.display = "inline";
                        //timeLeft = 60;
                    } else {
                        timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                        timeLeft -= 1;
                    }
                   
                }, 1000);
            }

            if (sessionStorage.getItem('otpTimer')) {
                timeLeft = parseInt(sessionStorage.getItem('otpTimer'));
                startCountdown();
            } else {
                startCountdown();
            }

            setInterval(() => {
                sessionStorage.setItem('otpTimer', timeLeft);
            }, 1000);

            resendButton.onclick = function(event) {
                event.preventDefault();
                window.location.href = 'resend_otp_forgot_password.php';
            };
        </script>

        <input type="submit" class="form-btn" value="Submit" name="otp_btn" />
        <p>Didn't receive the OTP? <a href="resend_otp_forgot_password.php" id="resend_otp_link">Resend OTP</a></p>
    </form>
</div>

</body>
</html>
<?php
if (isset($_POST['otp_btn'])) {
    echo "hello";
    $_SESSION['forgot_email']="priyalkapadiya03@gmail.com";

    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $otp = $_POST['otp'];

       // echo  $email;
        
        $query = "SELECT otp FROM password_token WHERE email = '$email'";
        $result = mysqli_query($con,  $query);

         if($result && mysqli_num_rows($result)>0)
         {

            $row=mysqli_fetch_assoc($result);
            $db_otp=$row['otp'];

            if ($otp === $db_otp) {
                echo "<script>window.location.href='new_password_form.php';</script>";
            } else {
                setcookie('error', 'Incorrect OTP',  time() + 5, path: '/');
               
                echo "<script>window.location.href='otp_form.php';</script>";
              
            }
        } else {
            setcookie('error',  'OTP has expired. Regenerate New OTP', time() + 2,path:  '/');
            
            echo "<script>window.location.href='Forgot_password.php';</script>";
            
        }
    } 
}
?>