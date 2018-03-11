<?php
//header("Content-Type: text/html; charset=ISO-8859-1");
$admin_user = "SELECT * FROM users WHERE type=1";
$res_user = mysqli_fetch_assoc(mysqli_query($con, $admin_user));

?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-top" id="mainNav">
    <a class="navbar-brand desktop" href="../dashboard.php"><img src="../images/logo.png"></a>
      <!--<a class="navbar-brand mobile" href="index.html"><img src="images/logo-mobile.png"></a>-->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <?php if ($_SESSION["login_user_type"] == 1) { ?>
                <li class="nav-item <?php
                if ($active == 'dashboard')
                    echo 'active';
                else
                    '';

                ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="../dashboard.php">
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
                    <a class="nav-link" href="../users/index.php">
                        <i class="fa fa-fw fa-users"></i>
                        <span class="nav-link-text">Manage Users</span>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item <?php
            if ($active == 'posts')
                echo 'active';
            else
                '';

            ?>" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="../articles/index.php">
                    <i class="fa fa-fw fa-sticky-note"></i>
                    <span class="nav-link-text">Manage Posts</span>
                </a>
            </li>
            <?php if ($_SESSION["login_user_type"] == 1) { ?>
                <li class="nav-item <?php
                if ($active == 'categories')
                    echo 'active';
                else
                    '';

                ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                    <a class="nav-link" href="../categories/index.php">
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
                    <a class="nav-link" href="../topics/index.php">
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
                    <a class="nav-link" href="../rssFeeds/index.php">
                        <i class="fa fa-fw fa-rss-square"></i>
                        <span class="nav-link-text">RSS Feeds</span>
                    </a>
                </li>

                <li class="nav-item <?php
                if ($active == 'subscribers')
                    echo 'active';
                else
                    '';

                ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                    <a class="nav-link" href="../subscribers/index.php">
                        <i class="fa fa-fw fa-envelope-open"></i>
                        <span class="nav-link-text">Newletter Subscribers</span>
                    </a>
                </li>
                <li class="nav-item <?php
                if ($active == 'companies')
                    echo 'active';
                else
                    '';

                ?>" data-toggle="tooltip" data-placement="right" title="Tables">
                    <a class="nav-link" href="../companies/index.php">
                        <i class="fa fa-fw fa-building"></i>
                        <span class="nav-link-text">Companies</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                    <a class="nav-link <?php
                    if ($active == 'settings')
                        echo 'active';
                    else
                        '';

                    ?>" href="../settings.php">
                        <i class="fa fa-fw fa-cog"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                </li>
            <?php } ?>

        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="mr15"><a class="btn btn-primary btn-block " href="../articles/add_new_post.php">Add New Post</a>

            </li>
            <?php if ($_SESSION['login_user_type'] == 1) { ?>
                <li class="mr15">
                    <a class="btn btn-primary btn-block" href="../users/invite_users.php">Invite Users</a>
                </li>
            <?php } ?>
            <li class="">
                <?php if ($_SESSION['login_user_type'] == 1) { ?>
                    <a class="avtar" href="../logout.php" onclick="return confirm('Are you sure want to logout')" id="alertsDropdown"><img src="../uploads/<?php echo $res_user['image_url']; ?>"> Admin-logout  <i class="fa fa-fw fa-caret-down"></i></a>
                <?php } else { ?>
                    <a class="avtar" href="../logout.php" onclick="return confirm('Are you sure want to logout')" id="alertsDropdown">user-logout  <i class="fa fa-fw fa-caret-down"></i></a>
                <?php } ?>
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