<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
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

                                        <td ><label><input type="search" class="form-control form-control-sm" placeholder="Search by User" id="user_search" name="user_search" aria-controls="dataTables-example"></label></td>
                                        <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Email" id="email_search" name="email_search" aria-controls="dataTables-example" ></label></td>
                                        <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Status" id="status_search" name="status_search" aria-controls="dataTables-example" ></label></td>

                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </form>
                                    <tbody id="tableDatContainer" class="scrollContent">
                                        <?php
                                        userlist($con, $user_search = '', $email_search = '', $status_search = '', $search_all = '');

                                        function userlist($con, $user_search, $email_search, $status_search, $search_all)
                                        {
                                            $sql = "SELECT * FROM users WHERE type=2";
                                            if ($user_search != '')
                                                $sql .= " AND name like '%" . $user_search . "%'";
                                            if ($email_search != '')
                                                $sql .= " AND email like '%" . $email_search . "%'";
                                            if ($status_search != '' && ($status_search == 'inactive' || $status_search == 'active')) {
                                                $status = ($status_search == 'inactive') ? 0 : 1;
                                                $sql .= " AND status='$status'";
                                            }
                                            if ($search_all != '')
                                                $sql .= " AND (name like '%" . $search_all . "%' OR email like '%" . $search_all . "%')";
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
                                                    echo "<td><a href = 'edit_users.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<p align='center'>No Results Found.</p>";
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
<style>


    html>body tbody.scrollContent {
        display: block;
        height: 362px;
        overflow: auto;
        width: 100%
    }


    html>body thead.fixedHeader tr {
        display: block
    }

    html>body thead.fixedHeader th { /* TH 1 */
        width: 225px  
    }

    html>body thead.fixedHeader th + th { /* TH 2 */
        width: 225px  
    }

    html>body thead.fixedHeader th + th + th { /* TH 3 +16px for scrollbar */
        width: 225px  
    }
    html>body thead.fixedHeader th + th + th + th { /* TH 3 +16px for scrollbar */
        width: 100px  
    }

    html>body thead.fixedHeader th + th + th + th + th { /* TH 3 +16px for scrollbar */
        width: 252px  
    }


    html>body tr.table-search  {
        display: block
    }

    html>body tr.table-search td { /* TH 1 */
        width: 225px  
    }

    html>body tr.table-search td + td { /* TH 2 */
        width: 225px  
    }

    html>body tr.table-search td + td + td { /* TH 3 +16px for scrollbar */
        width: 225px  
    }

    html>body tr.table-search td + td + td + td { /* TH 3 +16px for scrollbar */
        width: 100px  
    }
    html>body tr.table-search td + td + td + td + td { /* TH 3 +16px for scrollbar */
        width: 252px  
    }
    html>body tbody.scrollContent td { /* TD 1 */
        width: 225px  
    }

    html>body tbody.scrollContent td + td { /* TD 2 */
        width: 225px  
    }

    html>body tbody.scrollContent td + td + td { /* TD 3 +16px for scrollbar */
        width: 225px  
    }

    html>body tbody.scrollContent td + td + td + td { /* TD 3 +16px for scrollbar */
        width: 100px  
    }
    html>body tbody.scrollContent td + td + td + td + td { /* TD 3 +16px for scrollbar */
        width: 237px  
    }
</style>

