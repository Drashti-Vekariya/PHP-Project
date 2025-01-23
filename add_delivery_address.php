<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>INTERIOR</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Ensure all form input text is black */
        input, select, textarea {
            color: black  !important;
        }
    </style>    
    
    <!-- jQuery and Validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <?php include("header.php"); ?>
    </div>

    
    <?php
// Include database connection
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $person_name = $_POST['person_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $address_line_1 = $_POST['address_line_1'];
    $address_line_2 = $_POST['address_line_2'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $delivery_address = $person_name . "<br>" . $address_line_1 . "<br>" . $address_line_2 . "<br>" . $city . "-" . $zip . "<br>" . $state . "<br>" . $country . "<br>Mobile: " . $mobile_number . "<br>Email::" . $email;
    $query = "INSERT INTO `address`(`email`, `delivery_address`) VALUES ('$email','$delivery_address')";
   

    // Prepare the SQL query to insert data
    // $query = "INSERT INTO address(person_name, email, mobile_number, address_line_1, address_line_2, city, zip_code, state, country) 
    //           VALUES ('$person_name', '$email', '$mobile_number', '$address_line_1', '$address_line_2', '$city', '$zip_code', '$state', '$country')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Address added successfully!'); window.location.href='cart.php';</script>";
    } else {
        echo "<script>alert('Error adding address.');</script>";
    }
}

?>


    <div class="container my-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h1 class="text-danger">Add Delivery Address</h1></br>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="add_delivery_address.php" method="post" id="addressForm" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="person_name">Person Name</label>
                                <input type="text" id="person_name" name="person_name" class="form-control" placeholder="Enter person's name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="Enter mobile number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="line_1">Address Line 1</label>
                                <input type="text" id="line_1" name="address_line_1" class="form-control" placeholder="Enter address line 1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address Line 2</label>
                                <input type="text" id="address" name="address_line_2" class="form-control" placeholder="Enter address line 2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="Enter city" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zip">Zip Code</label>
                                <input type="text" id="zip" name="zip" class="form-control" placeholder="Enter zip code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" id="state" name="state" class="form-control" placeholder="Enter state" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country" class="form-control" placeholder="Enter country" required>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col">
                            <button type="submit" class="btn btn-danger">Add Address</button>
                        </div>
                    </div>
</br>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $("#addressForm").on("submit", function (e) {
            e.preventDefault(); // Prevent form submission until validation is passed

            let isValid = true;
            let messages = [];

            // Get form inputs
            const personName = $("#person_name").val();
            const email = $("#email").val();
            const mobileNumber = $("#mobile_number").val();
            const addressLine1 = $("#line_1").val();
            const city = $("#city").val();
            const zipCode = $("#zip").val();
            const state = $("#state").val();
            const country = $("#country").val();

            // Validation rules
            if (!personName) messages.push("Person Name is required.");
            if (!email) {
                messages.push("Email is required.");
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                messages.push("Please enter a valid Email.");
            }
            if (!mobileNumber || !/^\d{10,15}$/.test(mobileNumber)) {
                messages.push("Valid Mobile Number (10-15 digits) is required.");
            }
            if (!addressLine1) messages.push("Address Line 1 is required.");
            if (!city) messages.push("City is required.");
            if (!zipCode || !/^\d{5,10}$/.test(zipCode)) {
                messages.push("Valid Zip Code (5-10 digits) is required.");
            }
            if (!state) messages.push("State is required.");
            if (!country) messages.push("Country is required.");

            // If there are errors, display alerts
            if (messages.length > 0) {
                isValid = false;
                alert(messages.join("\n"));
            }

            // If valid, submit the form
            if (isValid) {
                this.submit();
            }
        });
    });
</script>
<?php include("footer.php"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/datepicker.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>

</html>
