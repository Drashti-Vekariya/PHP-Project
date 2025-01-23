<?php 
include_once('includes/config.php');

    if (isset($_POST['submit'])) 
    {
        $p_id = intval($_GET['p_id']);
        $c_id = $_POST['c_id'];
        $p_name = $_POST['p_name'];
        $p_mrp = $_POST['p_mrp'];
        $p_price = $_POST['p_price'];
        $p_desc = $_POST['p_desc'];
        $p_img = $_FILES['p_img']['name'];
        $qty = $_POST['qty'];
        $p_discount = $_POST['p_discount'];
        if($p_img==NULL)
        {
           $p_img=$_POST['img']; 
           $sql = mysqli_query($con, "update products set p_name='$p_name',p_mrp='$p_mrp',p_price='$p_price',p_desc=\"$p_desc\",p_img='$p_img',qty='$qty',p_discount='$p_discount',c_id='$c_id' where p_id='$p_id'");
           echo "<script>alert('Product Details updated');</script>";
           echo "<script>window.location.href='manage-product.php'</script>";
        }
        else
        {
            $sql = mysqli_query($con, "update products set p_name='$p_name',p_mrp='$p_mrp',p_price='$p_price',p_desc=\"$p_desc\",p_img='$p_img',qty='$qty',p_discount='$p_discount',c_id='$c_id' where p_id='$p_id'");
            
            move_uploaded_file($_FILES['p_img']['tmp_name'],"img/$p_img");

            echo "<script>alert('Product Details updated');</script>";
            echo "<script>window.location.href='manage-product.php'</script>";
        }
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
                        <h1 class="mt-4">Update Product</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Product</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                            <?php
                                $p_id = intval($_GET['p_id']);
                                
                                $query = mysqli_query($con, "select * from products where p_id='$p_id'");
                                
                                while ($row = mysqli_fetch_array($query)) 
                                {
                                    $c_id = $row['c_id'];
                                    $p_name = $row['p_name'];
                                    $p_img = $row['p_img'];
                                    $p_mrp = $row['p_mrp'];
                                    $p_price = $row['p_price'];
                                    $p_desc = $row['p_desc'];
                                    $qty = $row['qty'];
                                    $p_discount = $row['p_discount'];
                                    ?>
                                    
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-2">Category Name</div>
                                        <div class="col-6">
                                            <select name="c_id"  class="form-control" required>
                                                
                                                <?php 
                                                $query1 = mysqli_query($con, "select * from category ");
                                                while ($row = mysqli_fetch_array($query1)) { ?>
                                                <?php if($row['c_id']==$c_id)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row['c_id']; ?>" selected><?php echo $row['c_name']; ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                
                                                    <option value="<?php echo $row['c_id']; ?>"><?php echo $row['c_name']; ?></option>
                                                    <?php
                                                }
                                                ?>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Name</div>
                                        <div class="col-6"><input type="text" name="p_name" value="<?php echo $p_name; ?>" class="form-control" required/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Image</div>
                                        <div class="col-6"><input type="file" name="p_img"
                                                 value="<?php echo $p_img; ?>" class="form-control"/>
                                        </div>
                                        <div><input type="hidden" value="<?php echo $p_img; ?>" name="img"/></div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product MRP</div>
                                        <div class="col-6"><input type="text" name="p_mrp"
                                                 value="<?php echo $p_mrp; ?>" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Price</div>
                                        <div class="col-6"><input type="text" name="p_price"
                                                 value="<?php echo $p_price; ?>" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Qty</div>
                                        <div class="col-6"><input type="text" name="qty"
                                         value="<?php echo $qty; ?>"
                                                class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Discount</div>
                                        <div class="col-6"><input type="text" name="p_discount"
                                         value="<?php echo $p_discount; ?>"
                                                class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Product Description</div>
                                            <div class="col-6">
                                                <textarea name="p_desc"  class="form-control"><?php echo $p_desc; ?></textarea>
                                            </div>
                                    </div> 

                                    <div class="row" style="margin-top:1%">
                                        <div class="col-2">&nbsp;</div>
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

    </html>
