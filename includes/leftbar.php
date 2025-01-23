<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>

                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="add-product.php">Add</a>
                        <a class="nav-link" href="manage-product.php">Manage</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1"
                    aria-expanded="false" aria-controls="collapseLayouts1">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                    Orders
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <!-- <a class="nav-link" href="add-category.php">Add</a> -->
                        <a class="nav-link" href="manage-orders.php">Manage</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="add-category.php">Add</a>
                        <a class="nav-link" href="manage-categories.php">Manage</a>
                    </nav>
                </div>
   
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2"
                    aria-expanded="false" aria-controls="collapseLayouts2">
                    <div class="sb-nav-link-icon"><i class="fas fa-quote-left"></i></div>
                    Testimonial
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="add-testimonials.php">Add</a>
                        <a class="nav-link" href="manage-testimonials.php">Manage</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3"
                    aria-expanded="false" aria-controls="collapseLayouts3">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    User
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <!-- <a class="nav-link" href="add-category.php">Add</a> -->
                        <a class="nav-link" href="manage-user.php">Manage</a>
                    </nav>
                </div>

                 <!-- <div class="sb-sidenav-menu-heading">Profile Setting</div> -->
                <a class="nav-link" href="admin_manage_about.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                    About Us
                </a>
                <a class="nav-link" href="admin-banner.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                    Banner
                </a> 
                <a class="nav-link" href="my-profile.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                    My Profile
                </a> 


                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                    Logout
                </a>
            </div>
        </div>
        

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo "Admin"; ?>
        </div>
    </nav>
</div>