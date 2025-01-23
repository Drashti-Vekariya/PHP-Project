<?php
include_once('header.php');

include_once('includes/config.php');

$email = $_GET['em'];
echo $email;

$q = "select * from user_form where email='$email'";
$result = mysqli_query($con, $q);
$count = mysqli_num_rows($result);


if ($count == 1) {
    while ($r = mysqli_fetch_array($result)) {
        if ($r[7] == "active") {
            setcookie('success', "Email is already verified", time() + 5, "/");
?>
            <script>
                window.location.href = "login_form.php";
            </script>
            <?php
        } else {
            $update = "update user_form set `status`='active' where `email`='$email'";
            if (mysqli_query($con, $update)) {
                setcookie('success', "Email verified successfully", time() + 5, "/");
            ?>
                <script>
                    window.location.href = "login_form.php";
                </script>
    <?php
            }
        }
    }
} else {
    setcookie('error', "Email is not registered", time() + 5, "/");
    ?>
    <script>
        window.location.href = "register_form.php";
    </script>
<?php
}