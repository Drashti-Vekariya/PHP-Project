<?php
include_once('includes/config.php');
if (isset($_GET['del'])) {
    $o_id = $_GET['o_id'];
    mysqli_query($con, "DELETE FROM orders WHERE order_id ='$o_id'");
    echo "<script>alert('Data Deleted');</script>";
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

<body class="sb-nav-fixed">
    <?php include_once('includes/header.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Orders</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Orders</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Order Details
                        </div>
                        <div class="card-body table-responsive">
                            <table id="datatablesSimple" class="table table-striped table-bordered" >
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Order ID</th>
                                        <th>Sub Order ID</th>
                                        <th>Product ID </th>
                                        <th>Quantity</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Email</th>
                                        <th>Delivery Address</th>
                                        <th>Sub Total</th>
                                        <th>Delivery Status </th>
                                        <th>Payment Status</th>
                                        <!-- <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Order ID</th>
                                        <th>Pre Name</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>phone no.</th>
                                        <th>Address 1</th>
                                        <th>Address 2</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip</th>
                                        <th>Country</th>
                                        <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                    <?php
                                    
                                    $query = mysqli_query($con, "select * from orders");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>

                                        <tr>
                                            <td>
                                                <?php echo htmlentities($cnt); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['order_id']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['sub_order_id']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['p_id']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['qty']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['rating']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['review']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['email']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['delivery_address']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['sub_total']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['delivery_status']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['payment_status']); ?>
                                            </td>
                                            <!-- <td>
                                            ₹  <?php echo htmlentities($row['total']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['payment']); ?>
                                            </td>
                                            
                                            <td>
                                            <?php echo htmlentities($row['status']); ?>
                                            </td> -->

                                            <td>
                                                <!-- <a href="update-orders.php?order_id=<?php echo $row['order_id'] ?>"><i
                                                        class="fas fa-refresh"></i></a> | -->

                                                <a href="manage-orders.php?o_id=<?php echo $row['order_id'] ?>&del=delete"
                                                    onClick="return confirm('Are you sure you want to delete?')"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                            
                                        </tr>
                                        <?php $cnt = $cnt + 1;
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
            </footer>
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