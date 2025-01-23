<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>INTERIOR - Search Results</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .blurred {
            filter: blur(1px);
            opacity: 0.6;
        }
        .featured-item {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .featured-item:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .featured-item .thumb img {
            border-radius: 5px 5px 0 0;
            width: 100%;
            height: auto;
        }
        .featured-item .down-content {
            padding: 15px;
        }
        .featured-item .text-button a {
            display: inline-block;
            background-color: #fff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .featured-item .text-button a:hover {
            background-color: #fff;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <?php include("header.php"); ?>
    </div>

    <section class="banner banner-secondary" id="top" style="background-color:rgba(255, 0, 0, 0.66);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <h3 style="color:white; text-align:center;">Search Results</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <?php
                    @include 'config.php';

                    $query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

                    if ($query) {
                        $sql = "SELECT * FROM products WHERE p_name LIKE '%$query%' OR p_desc LIKE '%$query%'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $p_id = $row['p_id'];
                                $p_name = $row['p_name'];
                                $p_img = $row['p_img'];
                                $p_mrp = $row['p_mrp'];
                                $p_price = $row['p_price'];
                                $p_desc = $row['p_desc'];
                                $qty = $row['qty'];
                                $p_discount = $row['p_discount'];

                                if ($p_discount > 0) {
                                    $final_price = $p_price - ($p_price * $p_discount / 100);
                                } else {
                                    $final_price = $p_price;
                                }

                                $formatted_mrp = number_format($p_mrp, 2);
                                $formatted_final_price = number_format($final_price, 2);
                                $formatted_price = number_format($p_price, 2);
                                ?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="featured-item">
                                        <div class="thumb">
                                            <img src="img/<?php echo htmlspecialchars($p_img); ?>" alt="<?php echo htmlspecialchars($p_name); ?>" class="<?php echo ($qty > 0) ? '' : 'blurred'; ?>">
                                        </div>
                                        <div class="down-content">
                                            <h4><?php echo htmlspecialchars($p_name); ?></h4>
                                            <p><?php echo htmlspecialchars($p_desc); ?></p>
                                            <span>
                                                <?php if ($p_discount > 0) { ?>
                                                    <del><sup>₹</sup><?php echo $formatted_price; ?></del>
                                                    <strong><sup>₹</sup><?php echo $formatted_final_price; ?></strong>
                                                    <small style="color: green;">(<?php echo $p_discount; ?>% off)</small>
                                                <?php } else { ?>
                                                    <strong><sup>₹</sup><?php echo $formatted_price; ?></strong>
                                                <?php } ?>
                                            </span>
                                            <div class="text-button">
                                                <?php if ($qty > 0) { ?>
                                                    <a href="product-details.php?p_id=<?php echo $p_id; ?>">Buy now</a>
                                                <?php } else { ?>
                                                    <span style="color: red; font-weight: bold;">Out of Stock</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No results found for \"$query\".</p>";
                        }
                    } else {
                        echo "<p>Please enter a search query.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <?php include("footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
