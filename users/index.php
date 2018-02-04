<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    unset($_SESSION['condition']);
    userlist($con, $_POST['user'], $_POST['email'], strtolower($_POST['status']), $_POST['searchAll']);
    return true;
}

?>
<!DOCTYPE html>
<html lang="en">

    <?php
    include "../head.php"

    ?>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <?php
        $active = "users";
        include "../header.php";

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
                    <form name="search_form" id="search_form" method="post">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="col-md-6 float-right pr0 mb15">
                                    <div class="col-sm-12 col-md-12 float-right text-right pr0">


                                        <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" class="form-control form-control-sm" placeholder="Search Users" aria-controls="dataTables-example" id="search_all" name="search_all"></div><a class="btn btn-primary table-top-btn" href="invite_users.php">Invite Users</a>
                                    </div>

                                </div>
                                <!--<div id="tableContainer" class="tableContainer">-->
                                <table class="table table-bordered" id="dataTables-example2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="alternateRow">
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Posts</th>
                                            <th>Action</th>

                                        </tr>

                                    </thead>
                                    <tr class="table-search">

                                        <td ><label><input type="search" class="form-control form-control-sm" placeholder="Search by User" id="user_search" name="user_search" aria-controls="dataTables-example"></label></td>
                                        <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Email" id="email_search" name="email_search" aria-controls="dataTables-example" ></label></td>
                                        <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Status" id="status_search" name="status_search" aria-controls="dataTables-example" ></label></td>

                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </form>
                                    <tbody id="tableDatContainer">
                                        <?php
                                        userlist($con, $user_search = '', $email_search = '', $status_search = '', $search_all = '');

                                        function userlist($con, $user_search, $email_search, $status_search, $search_all)
                                        {

                                            //pagination start
                                            $condition = '';
                                            if (isset($_SESSION['condition']) && isset($_GET['currentpage']))
                                                $condition = $_SESSION['condition'];
                                            // find out how many rows are in the table 
                                            if ($user_search != '')
                                                $condition .= " AND name like '%" . $user_search . "%'";
                                            if ($email_search != '')
                                                $condition .= " AND email like '%" . $email_search . "%'";
                                            if ($status_search != '' && ($status_search == 'inactive' || $status_search == 'active')) {
                                                $status = ($status_search == 'inactive') ? 0 : 1;
                                                $condition .= " AND status='$status'";
                                            }
                                            if ($search_all != '')
                                                $condition .= " AND (name like '%" . $search_all . "%' OR email like '%" . $search_all . "%')";
                                            $_SESSION['condition'] = $condition;
                                            $sqll = "SELECT COUNT(*) FROM users WHERE type=2 $condition";
                                            $result = mysqli_query($con, $sqll);
                                            $r = mysqli_fetch_row($result);
                                            $numrows = $r[0];
// number of rows to show per page
                                            $rowsperpage = 20;
// find out total pages
                                            $totalpages = ceil($numrows / $rowsperpage);

// get the current page or set a default
                                            if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
                                                // cast var as int
                                                $currentpage = (int) $_GET['currentpage'];
                                            } else {
                                                // default page num
                                                $currentpage = 1;
                                            } // end if
// if current page is greater than total pages...
                                            if ($currentpage > $totalpages) {
                                                // set current page to last page
                                                $currentpage = $totalpages;
                                            } // end if
// if current page is less than first page...
                                            if ($currentpage < 1) {
                                                // set current page to first page
                                                $currentpage = 1;
                                            } // end if
// the offset of the list, based on current page 
                                            $offset = ($currentpage - 1) * $rowsperpage;

                                            //pagination end
                                            $sql = "SELECT * FROM users WHERE type=2 $condition";
                                            $sql .= "LIMIT $offset, $rowsperpage";

//                                            echo $sql;
                                            $query = mysqli_query($con, $sql);
                                            if ($query && mysqli_num_rows($query) != 0) {
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $id = $row['id'];
                                                    $status = ($row['status'] == 0) ? 'Inactive' : 'Active';
                                                    echo "<tr class='normalRow'>";
                                                    echo "<td>" . $row['name'] . "</td>";
                                                    echo "<td>" . $row['email'] . "</td>";
                                                    echo "<td>" . $status . "</td>";
                                                    echo "<td>" . $row['posts'] . "</td>";
                                                    echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_users.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
                                                    echo "</tr>";
                                                }
                                                /*                                                 * ****  build the pagination links ***** */
// range of num links to show
                                                $range = 3;

// if not on page 1, don't show back links
                                                echo "<tr><td style='text-align:right;margin: 0px;border:1px solid white;' colspan='5'>";
                                                if ($currentpage > 1) {
                                                    // show << link to go back to page 1

                                                    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><b><<  </b></a> ";
                                                    // get previous page num
                                                    $prevpage = $currentpage - 1;
                                                    // show < link to go back to 1 page
                                                    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>< </a> ";
                                                } // end if 
// loop to show links to range of pages around current page
                                                for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                                                    // if it's a valid page number...
                                                    if (($x > 0) && ($x <= $totalpages)) {
                                                        // if we're on current page...
                                                        if ($x == $currentpage) {
                                                            // 'highlight' it but don't make a link
                                                            echo " <b>[ $x ]</b> ";
                                                            // if not current page...
                                                        } else {
                                                            // make it a link
                                                            echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'> $x </a> ";
                                                        } // end else
                                                    } // end if 
                                                } // end for
// if not on last page, show forward and last page links        
                                                if ($currentpage != $totalpages) {
                                                    // get next page
                                                    $nextpage = $currentpage + 1;
                                                    // echo forward link for next page 
                                                    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'> > </a> ";
                                                    // echo forward link for lastpage
                                                    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'> <b> >></b></a> ";
                                                } // end if
                                                /*                                                 * **** end build pagination links ***** */
                                                echo "</td><tr>";
                                            } else {
                                                echo "<td colspan='5'><p align='center'>No Results Found.</p></td>";
                                            }
                                        }
                                        $con->close();

                                        ?>
                                    </tbody>
                                </table>
                                <!--</div>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.container-fluid-->
            <?php
            include "../footer.php";

            ?>
        </div>
    </body>

</html>
<script type="text/javascript">

    $(document).ready(function () {
        $("input").keyup(function () {
            var search = true;
            $.ajax(
                    {
                        type: 'post',
                        data: {search: search, user: $('#user_search').val(), email: $('#email_search').val(), status: $('#status_search').val(), searchAll: $('#search_all').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);

                        }

                    });
        });
    });
</script>
