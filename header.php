<?php 
session_start();
@include 'config.php';
date_default_timezone_set('Asia/Kolkata');
 ob_start();
 
$current_time = date("Y-m-d H:i:s");
 $delete_query = "DELETE FROM password_token WHERE expires_at < '$current_time'";
 mysqli_query($conn, $delete_query);
 // setcookie("error", "hjdsgj", time() - 5);
 $url = $_SERVER['REQUEST_URI'];
 $parsed_url = parse_url($url);
 $url1 = $parsed_url['path'];
 $parts = explode("/", $url1);
?>
<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button id="primary-nav-button" type="button">Menu</button>
                <a href="index.php">
                    <div class="logo">
                        <img src="img/interiorlogo.jpg.webp" height="90px">
                    </div>
                </a>
                <nav id="primary-nav" class="dropdown cf">
                    <ul class="dropdown menu">
                        <li class='active'><a href="index.php">Home</a></li>
                        <li>
                            <a href="#">Products</a>
                            <ul class="sub-menu">
                                <li><a href="products.php">All Products</a></li>
                                <li><a href="chair.php">CHAIR</a></li>
                                <li><a href="sofa.php">SOFA</a></li>
                                <li><a href="table.php">TABLE</a></li>
                                <li><a href="couch.php">COUCH</a></li>
                                <li><a href="carpet.php">CARPET</a></li>
                                <li><a href="swing.php">SWING</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">About</a>
                            <ul class="sub-menu">
                                <li><a href="about-us.php">About Us</a></li>
                                <li><a href="testimonials.php">Testimonials</a></li>
                                <!-- <li><a href="terms.php">Terms</a></li> -->
                            </ul>
                        </li>
                        <li><a href="contact.php">Contact Us</a></li>
                        
                        <li>
    <form id="search-form" method="get" action="search1.php" class="search-form" style="display: inline-flex; align-items: center;">
        <div style="position: relative; display: inline-block;">
            <input 
                type="text" 
                name="query" 
                class="form-control" 
                placeholder="Search" 
                style="padding-left: 30px; width: 150px;" 
                required 
            />
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                width="12" 
                height="15" 
                fill="currentColor" 
                class="bi bi-search" 
                viewBox="0 0 16 16" 
                style="position: absolute; top: 30%; left: 8px; transform: translateY(-50%); color: #6c757d;">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.098ZM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0Z" />
            </svg>
        </div>
        
    </form>

<div id="search-results" style="margin-top: 20px;"></div>
</li>


                        
                        <li><a href="wishlist.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                            </svg>
                        </a></li>
                        <li><a href="cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                        </a></li>

                        <?php 
                        if (isset($_SESSION['u_id'])) {
                            // Fetch user details
                            $user_id = $_SESSION['u_id'];
                            $query = "SELECT * FROM user_form WHERE user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            $user = mysqli_fetch_assoc($result);
                            if ($user) {
                        ?>
                        <li><a href="profile.php">
                            <img src="<?php echo !empty($user['profile_picture']) ? 'img/' . htmlspecialchars($user['profile_picture']) : 'img/default-profile.png'; ?>" 
                                 alt="Profile Picture" 
                                 class="rounded-circle" width="30" height="30" style="margin-right:5px;">
                            <?php echo htmlspecialchars($user['name']); ?>
                            </a>
                        </li> 
                        <?php 
                            } else {
                                // Handle case where user is not found
                                echo "<li><a href='login_form.php'>Login</a></li>";
                            }
                        } else { ?>
                            <li><a href="login_form.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-person" viewBox="0 0 15 15">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                </nav><!-- / #primary-nav -->
            </div>
        </div>
    </div>
</header>  
