<?php 
include_once('includes/config.php');

    if (isset($_POST['submit'])) {
        $c_id = $_POST['category'];
        $p_name = $_POST['p_name'];
        $p_mrp = $_POST['p_mrp'];
        $p_price = $_POST['p_price'];
        $p_desc = $_POST['p_desc'];
        $p_img = $_FILES['p_img']['name'];
        $qty = $_POST['qty'];
        

        $sql = mysqli_query($con, "insert into products (p_name,p_img,p_mrp,p_price,p_desc,c_id,qty) values('$p_name','$p_img','$p_mrp','$p_price','$p_desc','$c_id','$qty')");
        
        move_uploaded_file($_FILES['p_img']['tmp_name'],"img/$p_img");
        
        echo "<script>alert('Product Added  successfully');</script>";
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

    <body>
        <?php include_once('includes/header.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Add Product</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-2">Category Name</div>
                                        <div class="col-6">
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                <?php $userid = 10;
                                                $query = mysqli_query($con, "select c_id, c_name from category ");
                                                while ($row = mysqli_fetch_array($query)) { ?>

                                                    <option value="<?php echo $row['c_id']; ?>"><?php echo $row['c_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Name</div>
                                        <div class="col-6"><input type="text" name="p_name"
                                                placeholder="Enter the Product Name" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Image</div>
                                        <div class="col-6"><input type="file" name="p_img"
                                                 class="form-control" required/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product MRP</div>
                                        <div class="col-6"><input type="text" name="p_mrp"
                                                placeholder="Enter the Product MRP" class="form-control"/>
                                        </div>
                                    </div>

                                    

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Price</div>
                                        <div class="col-6"><input type="text" name="p_price"
                                                placeholder="Enter the Product Price" class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Qty</div>
                                        <div class="col-6"><input type="text" name="qty"
                                                placeholder="Enter the Product Qty" value="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Description</div>
                                            <div class="col-6">
                                                <textarea name="p_desc" rows="6" class="form-control"></textarea>
                                            </div>
                                    </div>                                    

                                    <div class="row" style="margin-top:1%">
                                        <div class="col-2">&nbsp;</div>
                                        <div class="col-2">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </form>
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

    </html>
