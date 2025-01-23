<?php 
include_once('includes/config.php');

    //For Adding categories
    if (isset($_POST['submit'])) {
        $c_name = $_POST['c_name'];
        $c_img = $_POST['c_img'];
        $c_id = intval($_GET['c_id']);
        
        $sql = mysqli_query($con, "update category set c_name='$c_name',c_img='$c_img' where c_id='$c_id'");
        
        move_uploaded_file($_FILES['c_img']['tmp_name'],"img/$c_img");
        
        echo "<script>alert('Category Details updated');</script>";
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
                                $c_id = intval($_GET['c_id']);
                                
                                $query = mysqli_query($con, "select * from category where c_id='$c_id'");
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <form method="post">
                                        <div class="row">

                                            <div class="col-4">Category ID</div>
                                            <div class="col-6"><input type="text"
                                                    value="<?php echo htmlentities($row['c_id']); ?>" name="c_id"
                                                    class="form-control" disabled></div>

                                            <div class="col-4" style="margin-top:10px;">Category Name</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="text"
                                                    value="<?php echo htmlentities($row['c_name']); ?>" name="c_name"
                                                    class="form-control" required></div>

                                            <div class="col-4" style="margin-top:10px;">Category Image</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="file"
                                                    value="<?php echo htmlentities($row['c_img']); ?>" name="c_img"
                                                    class="form-control" required></div>

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