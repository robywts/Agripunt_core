<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    unset($_SESSION['condition']);
    feed_list($con, $_POST['name'], $_POST['status']);
    return true;
}

?>
<!DOCTYPE html>
<html lang="en">

    <?php
    include "../head.php"

    ?>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <!-- Navigation-->
        <?php
        $active = "rssfeeds";
        include "../header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            RSS Feeds
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">RSS Feeds</li>
                            </ol>
                        </div>
                    </div>
                </div>



                <!-- Example DataTables Card-->
                <div class="card mb-3">

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="dataTables-example3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>RSS Feed Name</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Last Read on</th>
                                        <th>URL</th>      
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" id="name_search" class="form-control form-control-sm" placeholder="Search By Company Name" aria-controls="dataTables-example"></label></td>

                                    <td><div class="dropdown">
<!--                                            <button class="table-dropdown dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Active
                                            </button>-->
<!--                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Active</a>
                                                <a class="dropdown-item" href="#">Inactive</a>

                                            </div>-->
                                            <select placeholder="Status" name="status" id="status_search">
                                                <option value="">Status</option>
                                                <option value="1" > Active</option>
                                                <option value="0" >Inactive</option>
                                            </select>
                                        </div></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer">

                                    <?php
                                    feed_list($con, $name_search = '', $status_search = '');

                                    function feed_list($con, $name_search, $status_search = '')
                                    {
                                        $condition = '';
                                        if (isset($_SESSION['condition']) && isset($_GET['currentpage']))
                                            $condition = $_SESSION['condition'];
                                        if ($name_search != '')
                                            $condition .= " AND rs.rss_name like '%" . $name_search . "%'";
                                        if ($status_search != '')
                                            $condition .= " AND rs.rss_active =". $status_search;
                                        $_SESSION['condition'] = $condition;
                                        $sqll = "SELECT COUNT(*) FROM rssfeed as rs where 1=1 $condition";
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

                                        $sql = "SELECT * from rssfeed as rs where 1=1" . $condition;
                                        $sql .= " LIMIT $offset, $rowsperpage";
//                                        echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['id'];
                                                $status = ($row['rss_active'] == 0) ? 'Inactive' : 'Active';
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['rss_name'] . "</td>";
                                                echo "<td>" . $status . "</td>";
                                                echo "<td>" . $row['rss_description'] . "</td>";
                                                echo "<td>" . $row['rss_lastreaddate'] . "</td>";
                                                echo "<td>" . $row['rss_url'] . "</td>";
//                                                echo "<td><a href = 'edit_topic.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_topic.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_subscriber.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete_subscriber.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
                                                echo "</tr>";
                                            }
                                            /*                                             * ****  build the pagination links ***** */
// range of num links to show
                                            $range = 3;

// if not on page 1, don't show back links
                                            echo "<tr><td style='text-align:right;margin: 0px;border:1px solid white;' colspan='6'>";
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
                                            /*                                             * **** end build pagination links ***** */
                                            echo "</td><tr>";
                                        } else {
                                            echo "<td colspan='6'><p align='center'>No Results Found.</p></td>";
                                        }
                                    }
                                    $con->close();

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

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
                        data: {search: search, name: $('#name_search').val(), status: $('#status_search').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);
                        }
                    });
        });
          $("select").change(function () {
            var search = true;
            $.ajax(
                    {
                        type: 'post',
                        data: {search: search, name: $('#name_search').val(), status: $('#status_search').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);
                        }
                    });
        });
    });
</script>