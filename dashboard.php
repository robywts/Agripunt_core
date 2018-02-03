<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
if (!(isset($_SESSION["login_user"]))) {
    header("Location: index.php");
}

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
        <?php
        $active = 'dashboard';

        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-top" id="mainNav">
            <a class="navbar-brand desktop" href="index.html"><img src="images/logo.png"></a>
              <!--<a class="navbar-brand mobile" href="index.html"><img src="images/logo-mobile.png"></a>-->
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                    <li class="nav-item <?php if ($active == 'dashboard') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa fa-fw fa-dashboard"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item  <?php if ($active == 'users') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="users/manage_users.php">
                            <i class="fa fa-fw fa-users"></i>
                            <span class="nav-link-text">Manage Users</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($active == 'posts') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Charts">
                        <a class="nav-link" href="manage_posts.html">
                            <i class="fa fa-fw fa-sticky-note"></i>
                            <span class="nav-link-text">Manage Posts</span>
                        </a>
                    </li>

                    <li class="nav-item <?php if ($active == 'categories') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="categories/news_categories.php">
                            <i class="fa fa-fw fa-newspaper-o"></i>
                            <span class="nav-link-text">News Categories</span>
                        </a>
                    </li>

                    <li class="nav-item <?php if ($active == 'topics') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="news_topics.html">
                            <i class="fa fa-fw fa-newspaper-o"></i>
                            <span class="nav-link-text">News Topics</span>
                        </a>
                    </li>


                    <li class="nav-item <?php if ($active == 'rssfeeds') echo 'active';
        else ''; ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="rss_feeds.html">
                            <i class="fa fa-fw fa-rss-square"></i>
                            <span class="nav-link-text">RSS Feeds</span>
                        </a>
                    </li>

                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="newsletter_subscribers.html">
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

                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                        <a class="nav-link" href="settings.html">
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
                        <a class="btn btn-primary btn-block" href="invite_users.php">Invite Users</a>
                    </li>
                    <li class="">
                        <a class="avtar" href="logout.php" onclick="return confirm('Are you sure want to logout')" id="alertsDropdown"><img src="images/user.png"> Admin-logout  <i class="fa fa-fw fa-caret-down"></i></a>
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
                            <div class="page-title">
                                Dashboard
                            </div>
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">
                                    <a href="#">Dashboard</a>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>



                <!-- Example DataTables Card-->
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">569</div> 
                                        <div class="dash-cat">Users</div>                

                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="users/manage_users.php" id="toggleNavPosition">View Users</a>
                                    <a class="btn btn-primary" href="users/invite_users.php" id="toggleNavPosition">Invite User</a>              </div>



                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">1024</div> 
                                        <div class="dash-cat">Posts</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="manage_posts.html" id="toggleNavPosition">View  Posts</a>
                                    <a class="btn btn-primary" href="add_new_post.html" id="toggleNavPosition">Add Post</a>
                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">153</div> 
                                        <div class="dash-cat">News Categories</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="categories/news_categories.php" id="toggleNavPosition">View Categories</a>
                                    <a class="btn btn-primary" href="categories/add_new_category.php" id="toggleNavPosition">Add Category</a>
                                </div>



                            </div>
                        </div>


                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">85</div> 
                                        <div class="dash-cat">News Topics</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="news_topics.html" id="toggleNavPosition">View Topics</a>
                                    <a class="btn btn-primary" href="add_new_topic.html" id="toggleNavPosition">Add  Topic</a>
                                </div>



                            </div>
                        </div>


                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">3</div> 
                                        <div class="dash-cat">RSS Feeds</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="rss_feeds.html" id="toggleNavPosition">View Feeds</a>

                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">3015</div> 
                                        <div class="dash-cat">Newsletter Subscribers</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="newsletter_subscribers.html" id="toggleNavPosition">View Subscribers</a>

                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">89</div> 
                                        <div class="dash-cat">Companies</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="companies.html" id="toggleNavPosition">View Companies</a>
                                    <a class="btn btn-primary" href="add_new_company.html" id="toggleNavPosition">Add Company</a>
                                </div>



                            </div>
                        </div>

                    </div>


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
                                $(document).ready(function () {
                                    $('#dataTables-example').DataTable({
                                        responsive: true
                                    });
                                });
            </script>
        </div>

    </body>

</html>