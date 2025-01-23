<?php
@include 'config.php'; 
session_start(); 

$error = '';
$success = '';

if (!isset($_SESSION['admin_user'])) {
    $error = 'Admin user is not set in session. Please login again.';
} else {
    $em = $_SESSION['admin_user'];

    if (isset($_POST['change_password'])) {
        
        $old_pwd = mysqli_real_escape_string($conn, $_POST['old_password']);
        $new_pwd = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_pwd = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if (!empty($old_pwd) && !empty($new_pwd) && !empty($confirm_pwd)) {

            $q = "SELECT * FROM user_form WHERE email='$em'";
            $result = mysqli_query($conn, $q);

            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $hashed_old_pwd = $user['password']; 

                if (md5($old_pwd) === $hashed_old_pwd) {
                   
                    if ($new_pwd === $confirm_pwd) {
                   
                        $new_pwd_hashed = md5($new_pwd);

                        $update_q = "UPDATE user_form SET password='$new_pwd_hashed' WHERE email='$em'";
                        if (mysqli_query($conn, $update_q)) {
                            $success = "Password changed successfully!";
                        } else {
                            $error = "Failed to change password!";
                        }
                    } else {
                        $error = "New password and confirm password do not match!";
                    }
                } else {
                    $error = "Incorrect old password!";
                }
            } else {
                $error = "User not found!";
            }
        } else {
            $error = "All fields are required!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

    <script>
        // Show toast message
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

        $(document).ready(function() {
            // jQuery validation
            $("form[name='changePasswordForm']").validate({
                rules: {
                    old_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 6
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    old_password: "Please enter your old password.",
                    new_password: {
                        required: "Please enter a new password.",
                        minlength: "Your password must be at least 6 characters long."
                    },
                    confirm_password: {
                        required: "Please confirm your new password.",
                        equalTo: "Password confirmation does not match."
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
</head>
<body>

<div class="container mt-5">
    <div class="row text-center">
        <div class="col-12 bg-dark text-white p-4">
            <h1>Change Password</h1>
        </div>
    </div>

    <form name="changePasswordForm" action="" method="post" class="mt-4">
        <div class="form-group">
            <label for="old_password"><b>Old Password:</b></label>
            <input type="password" class="form-control" id="old_password" placeholder="Enter old password" name="old_password">
        </div>
        <br>
        <div class="form-group">
            <label for="new_password"><b>New Password:</b></label>
            <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password">
        </div>
        <br>
        <div class="form-group">
            <label for="confirm_password"><b>Confirm New Password:</b></label>
            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm new password" name="confirm_password">
        </div>
        <br>
        <button type="submit" class="btn btn-dark" name="change_password">Change Password</button><br/>
        <br/>
        <a href="dashboard.php" class="btn btn-secondary">Go to Dashboard</a>
    </form>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
            <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessageBody"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
