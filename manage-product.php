<?php 
include_once('includes/config.php');

// For deleting    
if(isset($_GET['del'])){
$p_id=$_GET['p_id'];

mysqli_query($con,"delete from products where p_id ='$p_id'");
echo "<script>alert('Product Deleted');</script>";
echo "<script>window.location.href='manage-product.php'</script>";
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
                        <h1 class="mt-4">Manage Products</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Products</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Product Details
                            </div>
                            <div class="card-body table-responsive">
                            <table id="datatablesSimple" class="table table-striped table-bordered" >
                                    <thead>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Mrp</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Category ID</th>
                                            <th>Qty</th>
                                            <th>Discount </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                        <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Mrp</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Category ID</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                    <?php 
                                    
                                    $query=mysqli_query($con,"select * from products");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>  

                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['p_id']);?></td>
                                            <td><img src="img/<?php echo htmlentities($row['p_img']);?>" height=170px; width=150px;></img></td>
                                            <td><?php echo htmlentities($row['p_name']);?></td>
                                            <td><?php echo htmlentities($row['p_mrp']);?></td>
                                            <td><?php echo htmlentities($row['p_price']);?></td>
                                            <td><?php echo htmlentities($row['p_desc']);?></td>
                                            <td><?php echo htmlentities($row['c_id']);?></td>
                                            <td><?php echo htmlentities($row['qty']);?></td>
                                            <td><?php echo htmlentities($row['p_discount']);?></td>
                                            <td>
                                            <a href="update-product.php?p_id=<?php echo $row['p_id']?>"><i class="fas fa-refresh"></i></a> | 
                                            <a href="manage-product.php?p_id=<?php echo $row['p_id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>

                                        </tr>
                                        <?php $cnt=$cnt+1; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include_once('includes/footer.php');?>
                </footer>
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
