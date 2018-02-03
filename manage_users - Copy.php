<?php
include "control.inc";
include("config.php");

?>
<!DOCTYPE html>
<html lang="en">

    <?php
    include "head.php"

    ?>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <?php
        include "header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            Manage Users
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Manage Users</li>
                            </ol>
                        </div>
                    </div>
                </div>



                <!-- Example DataTables Card-->
                <div class="card mb-3">

                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="col-md-6 float-right pr0 mb15">
                                <div class="col-sm-12 col-md-12 float-right text-right pr0">


                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" class="form-control form-control-sm" placeholder="Search Users" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="invite_users.html">Invite Users</a>
                                </div>

                            </div>
                            <!--<div id="tableContainer" class="tableContainer">-->
                            <table class="table table-bordered scrollTable" id="dataTables-example2" width="100%" cellspacing="0">
                                <thead class="fixedHeader">
                                    <tr class="alternateRow">
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Posts</th>
                                        <th>Action</th>

                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td ><label><input type="search" class="form-control form-control-sm" placeholder="Search by User" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Email" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Status" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody class="scrollContent">
                                    <?php
                                    $sql = "SELECT * FROM users WHERE type=2";
                                    $query = mysqli_query($con, $sql);
                                    if (mysqli_num_rows($query) != 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "<tr class='normalRow'>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$row['posts']."</td>";
                                            echo "<td>".$row['status']."</td>";
                                            echo "<td><a href = 'edit_users.php/' class = 'btn edit '>EDIT</a> <a href = '#' class = 'btn delete'>DELETE</a></td>";
                                            echo "</tr>";
                                        }
                                    }


//                                    <tr>
//                                    <td>Mike Don</td>
//                                    <td>mmike@gmail.com</td>
//                                    <td>Active</td>
//                                    <td>12</td>
//                                    <td><a href = "edit_users.php/" class = "btn edit ">EDIT</a> <a href = "#" class = "btn delete">DELETE</a></td>
//                                    </tr>

                                    ?>
                                </tbody>
                            </table>
                                <!--</div>-->
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.container-fluid-->
            <?php
            include "footer.php";

            ?>
        </div>
    </body>

</html>
<style>


html>body tbody.scrollContent {
    display: block;
    height: 262px;
    overflow: auto;
    width: 100%
}


html>body thead.fixedHeader tr {
    display: block
}

html>body thead.fixedHeader th { /* TH 1 */
    width: 200px
}

html>body thead.fixedHeader th + th { /* TH 2 */
    width: 240px
}

html>body thead.fixedHeader th + th + th { /* TH 3 +16px for scrollbar */
    width: 316px
}

html>body tr.table-search  {
    display: block
}

html>body tr.table-search td { /* TH 1 */
    width: 200px
}

html>body tr.table-search td + td { /* TH 2 */
    width: 240px
}

html>body tr.table-search td + td + td { /* TH 3 +16px for scrollbar */
    width: 316px
}

html>body tbody.scrollContent td { /* TD 1 */
    width: 200px
}

html>body thead.scrollContent td + td { /* TD 2 */
    width: 240px
}

html>body thead.scrollContent td + td + td { /* TD 3 +16px for scrollbar */
    width: 316px
}

</style>