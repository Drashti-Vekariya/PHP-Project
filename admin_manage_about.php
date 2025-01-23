<?php 
include_once('includes/config.php');

if (isset($_SESSION['admin_email'])) {
    $admin_email = $_SESSION['admin_email'];
} else {
    $admin_email = null;
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
    <title>Manage About Us</title>
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
                    <h1 class="mt-4">Manage About Us</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage About Us</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i>
                            About Us Page Content
                        </div>
                        <div class="card-body">
                            <?php
                            $query = "SELECT * FROM about_us";
                            $result = mysqli_query($con, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo htmlspecialchars_decode($row['content']); // Decoding HTML for proper rendering
                                }
                            } else {
                                echo "<p>No content available.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-edit me-1"></i>
                            Edit About Us Content
                        </div>
                        <div class="card-body">
                            <form action="admin_manage_about.php" method="post">
                                <div id="toolbar-container"></div>
                                <div id="editor">
                                    <?php
                                    // Fetch the existing content again for the editor
                                    $query = "SELECT * FROM about_us";
                                    $result = mysqli_query($con, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo htmlspecialchars_decode($row['content']);
                                        }
                                    } else {
                                        echo "<p>No content available.</p>";
                                    }
                                    ?>
                                </div>
                                <textarea id="editor-content" name="editor_content" style="display:none;"></textarea>
                                <br>
                                <input type="submit" value="Update Content" class="btn btn-dark" name="updt_about">
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>
    <script>
        DecoupledEditor.create(document.querySelector('#editor'), {
            toolbar: [
                'heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 
                'fontColor', 'fontBackgroundColor', 'undo', 'redo'
            ]
        }).then(editor => {
            document.querySelector('#toolbar-container').appendChild(editor.ui.view.toolbar.element);

            // Capture updated content whenever the editor changes
            const contentInput = document.querySelector('#editor-content');
            contentInput.value = editor.getData();  // Initial content value

            editor.model.document.on('change:data', () => {
                contentInput.value = editor.getData();  // Update textarea on editor change
            });
        }).catch(error => {
            console.error(error);
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['updt_about'])) {
    $about_content = mysqli_real_escape_string($con, $_POST['editor_content']);
    $query = "SELECT * FROM about_us";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        // Insert new content if not present
        $insert_query = "INSERT INTO about_us (content) VALUES ('$about_content')";
        if (mysqli_query($con, $insert_query)) {
            setcookie("success", 'Page Content Updated', time() + 5, "/");
        } else {
            setcookie("error", 'Failed to update page content', time() + 5, "/");
        }
    } else {
        // Update existing content
        $update_query = "UPDATE about_us SET content='$about_content'";
        if (mysqli_query($con, $update_query)) {
            setcookie("success", 'Page Content Updated', time() + 5, "/");
        } else {
            setcookie("error", 'Failed to update page content', time() + 5, "/");
        }
    }
    echo '<script>window.location.href = "admin_manage_about.php";</script>';
}
?>
