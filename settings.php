<?php
include "control.inc";
include("config.php");

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Agripunt</title>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <!-- Navigation-->
        <?php
        $active = "settings";
        $admin_user = "SELECT * FROM users WHERE type=1";
        $res_user = mysqli_fetch_assoc(mysqli_query($con, $admin_user));

        if (isset($_POST['btn-upload'])) {
            if ($_POST['name'] == '' || $_POST['email'] == '' || $_POST['password'] == '') {
                $error = 'ERROR: Please fill in all fields!';
            } else {
                $condition = '';
                if ($_FILES['file']['name'] != '') {
                    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
                    $file_loc = $_FILES['file']['tmp_name'];
                    $file_size = $_FILES['file']['size'];
                    $file_type = $_FILES['file']['type'];
                    $folder = "uploads/";
                    move_uploaded_file($file_loc, $folder . $file);
                    $condition .= ",image_url='" . $file . "'";
                    unlink($_POST['old_img']);
                }
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $sql = "UPDATE users SET name='" . $_POST['name'] . "', email='" . $_POST['email'] . "'$condition, password='" . $password . "' where users.type= 1";
                $res = mysqli_query($con, $sql);
                echo '<script type="text/javascript">';
                echo 'window.location.href="' . $_SERVER['REQUEST_URI'] . '";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=' . $_SERVER['REQUEST_URI'] . '" />';
                echo '</noscript>';
            }
        }

        ?>
        <!-- Navigation-->
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-top" id="mainNav">
            <a class="navbar-brand desktop" href="index.html"><img src="images/logo.png"></a>
              <!--<a class="navbar-brand mobile" href="index.html"><img src="images/logo-mobile.png"></a>-->
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                    <li class="nav-item <?php
                    if ($active == 'dashboard')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa fa-fw fa-dashboard"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item  <?php
                    if ($active == 'users')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="users/index.php">
                            <i class="fa fa-fw fa-users"></i>
                            <span class="nav-link-text">Manage Users</span>
                        </a>
                    </li>
                    <li class="nav-item <?php
                    if ($active == 'posts')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Charts">
                        <a class="nav-link" href="manage_posts.html">
                            <i class="fa fa-fw fa-sticky-note"></i>
                            <span class="nav-link-text">Manage Posts</span>
                        </a>
                    </li>

                    <li class="nav-item <?php
                    if ($active == 'categories')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="categories/index.php">
                            <i class="fa fa-fw fa-newspaper-o"></i>
                            <span class="nav-link-text">News Categories</span>
                        </a>
                    </li>

                    <li class="nav-item <?php
                    if ($active == 'topics')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="topics/index.php">
                            <i class="fa fa-fw fa-newspaper-o"></i>
                            <span class="nav-link-text">News Topics</span>
                        </a>
                    </li>


                    <li class="nav-item <?php
                    if ($active == 'rssfeeds')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="rss_feeds.html">
                            <i class="fa fa-fw fa-rss-square"></i>
                            <span class="nav-link-text">RSS Feeds</span>
                        </a>
                    </li>

                    <li class="nav-item <?php if ($active == 'subscribers') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="subscribers/index.php">
                            <i class="fa fa-fw fa-envelope-open"></i>
                            <span class="nav-link-text">Newletter Subscribers</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="companies.html">
                            <i class="fa fa-fw fa-building"></i>
                            <span class="nav-link-text">Companies</span>
                        </a>
                    </li>

                    <li class="nav-item <?php
                    if ($active == 'settings')
                        echo 'active';
                    else
                        '';

                    ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="settings.php">
                            <i class="fa fa-fw fa-cog"></i>
                            <span class="nav-link-text">Settings</span>
                        </a>
                    </li>


                </ul>
                <ul class="navbar-nav sidenav-toggler">
                    <li class="nav-item">
                        <a class="nav-link text-center" id="sidenavToggler">
                            <i class="fa fa-fw fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="mr15"><a class="btn btn-primary btn-block " href="add_new_post.html">Add New Post</a>

                    </li>
                    <li class="mr15">
                        <a class="btn btn-primary btn-block" href="users/invite_users.php">Invite Users</a>
                    </li>
                    <li class="">
                        <a class="avtar" href="logout.php" onclick="return confirm('Are you sure want to logout')" id="alertsDropdown"><img src="uploads/<?php echo $res_user['image_url']; ?>"> Admin-logout  <i class="fa fa-fw fa-caret-down"></i></a>
                        <div class="dropdown-menu show" aria-labelledby="alertsDropdown" style="display:none;">
                            <h6 class="dropdown-header">New Alerts:</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-success">
                                    <strong>
                                        <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-danger">
                                    <strong>
                                        <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-success">
                                    <strong>
                                        <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small" href="#">View all alerts</a>
                        </div>
                    </li>


                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            Settings
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>



                <!-- Example DataTables Card-->
                <div class="card mb-3">
                    <?php
                    if (isset($error) && $error != '') {

                        echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
                    }

                    ?>
                    <form id="profile_settings" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="col-md-12 profile-edit">
                                <div class="profile-edit-wrap">
                                    <img id="img" src="uploads/<?php echo $res_user['image_url']; ?>">
                                    <div class="image-upload">
                                        <label for="file-input">
                                            <i style="cursor:pointer;" class="fa fa-fw  fa-edit"></i>
                                        </label>
                                        <input id="file-input" onchange="readURL(this);"  name="file" type="file"/>
                                        <input id="old_img" type="hidden" name="old_img" value="uploads/<?php echo $res_user['image_url']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-details">

                                <div class="input-group">
                                    <label>Name</label>
                                    <div class="input-block"><input type="text" name="name" value="<?php echo $res_user['name']; ?>" ></div>
                                </div>
                                <div class="input-group">
                                    <label>Email</label>
                                    <div class="input-block"><input type="text" name="email" value="<?php echo $res_user['email']; ?>" ></div>
                                </div>
                                <div class="input-group">
                                    <label>Password</label>
                                    <div class="input-block"><input type="password" name="password" value="" ><span><button class="btn btn-primary btn-block inlline-block" style="font-size:11px;cursor:pointer;" type="submit" name="btn-upload">SAVE</button></span></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.container-fluid-->
            <!-- /.content-wrapper-->
            <footer class="sticky-footer">
                <div class="container">
                    <div class="text-center">
                        <small>Copyright © Agripunt 2017</small>
                    </div>
                </div>
            </footer>
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>
            <!-- Logout Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="login.html">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Page level plugin JavaScript-->
            <script src="vendor/datatables/jquery.dataTables.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin.min.js"></script>
            <!-- Custom scripts for this page-->
            <script src="js/sb-admin-datatables.min.js"></script>
            <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();

                                                    reader.onload = function (e) {
                                                        $('#img').attr('src', e.target.result);
                                                    }

                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                            $(document).ready(function () {
                                                $('#dataTables-example').DataTable({
                                                    responsive: true
                                                });

                                            });
            </script>
        </div>
    </body>

</html>
<style>
    .image-upload > input
    {
        display: none;
    }
</style>