<?php 
include_once('includes/config.php');

    //For Adding categories
    if (isset($_POST['submit'])) {
        $o_status = $_POST['status'];
        $o_id = intval($_GET['o_id']);
        
        $sql = mysqli_query($con, "update orders set status='$o_status' where order_id='$o_id'");
        echo "<script>alert('Order Status updated');</script>";
        echo "<script>window.location.href='manage-orders.php'</script>";
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>INTERIOR</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php include_once('includes/header.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Update Category</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Category</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <?php
                                $o_id = intval($_GET['order_id']);
                                
                                $query = mysqli_query($con, "SELECT * FROM orders WHERE order_id='$o_id'");
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <form method="post">
                                        <div class="row">

                                            <div class="col-4">Order ID</div>
                                            <div class="col-6"><input type="text"
                                                    value="<?php echo htmlentities($row['order_id']); ?>" name="o_id"
                                                    class="form-control" disabled></div>

                                            <div class="col-4" style="margin-top:10px;">Customer Name</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="text"
                                                    value="<?php echo htmlentities($row['name']); ?>" name="name"
                                                    class="form-control" disabled></div>

                                            <div class="col-4" style="margin-top:10px;">Payment</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="text"
                                                    value="<?php echo htmlentities($row['payment']); ?>" name="payment"
                                                    class="form-control" disabled></div>

                                            <div class="col-4" style="margin-top:10px;">Status</div>
                                            <div class="col-6" style="margin-top:10px;">
                                                <select name="status" id="status" class="form-control" required>

                                                    <option value="<?php echo htmlentities($row['status']); ?>" selected><?php echo htmlentities($row['status']); ?></option>
                                                    <option value="Panding">Panding</option>
                                                    <option value="Confirmed">Confirmed</option>
                                                    <option value="Out for Delivery">Out for Delivery</option>
                                                    <option value="Delivered">Delivered</option>
                                                    <option value="Cancled">Cancled</option>
                                                </select></div>
                                        </div>

                                        <div class="row" style="margin-left:500px; margin-top:20px">
                                            <div class="col-2"><button type="submit" name="submit"
                                                    class="btn btn-primary">Update</button></div>
                                        </div>

                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>    
</html>