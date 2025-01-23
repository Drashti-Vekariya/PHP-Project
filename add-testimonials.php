<?php 
    include_once('includes/config.php');
    //For Adding categories
    if (isset($_POST['submit'])) {
        
        $t_name = $_POST['testimonial_name'];
        $t_data = $_POST['testimonial_data'];
        $t_img = $_FILES['testimonial_img']['name'];

        $sql = mysqli_query($con, "insert into testimonial(name,testimonial_data,testimonial_img) values('$t_name','$t_data','$t_img')");
        
        move_uploaded_file($_FILES['testimonial_img']['tmp_name'],"img/$t_img");

        echo "<script>alert('Testimonial added successfully');</script>";
        echo "<script>window.location.href='manage-testimonials.php'</script>";
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
                        <h1 class="mt-4">Add Testimonials</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Testimonials</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">

                                        <!-- <div class="col-4">Testimonial ID</div>
                                        <div class="col-6"><input type="text" placeholder="Enter Testimonial ID"
                                                name="testimonialid" class="form-control" ></div> -->

                                        
                                        <div class="col-4" style="margin-top:10px;">Testimonial Name</div>
                                        <div class="col-6" style="margin-top:10px;"><input type="text"
                                                placeholder="Enter Testimonial Name" name="testimonial_name"
                                                class="form-control" required></div>


                                        <div class="col-4" style="margin-top:10px;">Testimonial Image</div>
                                        <div class="col-6" style="margin-top:10px;">
                                            <input type="file" name="testimonial_img" class="form-control" required/>
                                        </div> 
                                        

                                        <div class="col-4" style="margin-top:10px;">Testimonial</div>
                                        <div class="col-6" style="margin-top:10px;">
                                            <textarea name="testimonial_data" placeholder="Enter Testimonial"
                                                class="form-control" required></textarea>
                                        </div>

                                    </div>


                                    <div class="row" style="margin-left:500px; margin-top:20px">
                                        <div class="col-2"><button type="submit" name="submit"
                                                class="btn btn-primary">Submit</button></div>
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
    </body>

    </html>
