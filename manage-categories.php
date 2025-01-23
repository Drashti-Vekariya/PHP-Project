<?php 
include_once('includes/config.php');

// For deleting    
if(isset($_GET['del']))
{
    $c_id = $_GET['c_id'];

    // Deleting the category
    $delete_query = mysqli_query($con, "DELETE FROM category WHERE c_id ='$c_id'");

    if ($delete_query) {
        echo "<script>alert('Data Deleted');</script>";
    } else {
        echo "<script>alert('Failed to delete data');</script>";
    }

    echo "<script>window.location.href='manage-categories.php'</script>";
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
        <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage Categories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Categories</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Categories Details
                            </div>
                            <div class="card-body table-responsive">
                                <table id="datatablesSimple" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                        <?php 
                                        $query = mysqli_query($con, "SELECT * FROM category");

                                        if (!$query) {
                                            echo "<tr><td colspan='5'>Failed to retrieve data: " . mysqli_error($con) . "</td></tr>";
                                        } else {
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                        ?>  
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row['c_id']); ?></td> 
                                                    <td><img src="img/<?php echo htmlentities($row['c_img']); ?>" height="130px" width="120px"></td>
                                                    <td><?php echo htmlentities($row['c_name']); ?></td>     
                                                    <td>
                                                        <a href="update-category.php?c_id=<?php echo $row['c_id']?>"><i class="fas fa-edit"></i></a> | 
                                                        <a href="manage-categories.php?c_id=<?php echo $row['c_id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                        <?php 
                                                $cnt++;
                                            }
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
