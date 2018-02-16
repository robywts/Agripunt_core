<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    unset($_SESSION['condition']);
    company_list($con, $_POST['name'], $_POST['desc'], $_POST['addr'], $_POST['zip'], $_POST['title'], $_POST['h1'], $_POST['searchAll']);
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
        $active = "companies";
        include "../header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            Companies
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Companies</li>
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


                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" class="form-control form-control-sm" id="search_all" placeholder="Search Company" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="add_new_company.php">Add New Company</a>
                                </div>

                            </div>
                            <table class="table table-bordered" id="dataTables-example2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Address</th>
                                        <th>Logo URL</th>
                                        <th>Logo</th>
                                        <th>Zip Code</th>
                                        <th>H1</th>
                                        <th>Meta Description</th>
                                        <th>Company Title</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" id="name_search" class="form-control form-control-sm" placeholder="Search by Company Name" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" id="addr_search" class="form-control form-control-sm" placeholder="Search by Location" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                    <td><label><input type="search" id="zip_search" class="form-control form-control-sm" placeholder="Search by Zip" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" id="h1_search" class="form-control form-control-sm" placeholder="Search by H1" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" id="desc_search" class="form-control form-control-sm" placeholder="Search by Meta Description" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" id="title_search" class="form-control form-control-sm" placeholder="Search by Title" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer">

                                    <?php
                                    company_list($con, $name_search = '', $desc_search = '', $addr_search = '', $zip_search = '', $title_search = '', $h1_search = '', $search_all = '');

                                    function company_list($con, $name_search, $desc_search, $addr_search, $zip_search, $title_search, $h1_search, $search_all)
                                    {
                                        $condition = '';
                                        if (isset($_SESSION['condition']) && isset($_GET['currentpage']))
                                            $condition = $_SESSION['condition'];
                                        if ($name_search != '')
                                            $condition .= " AND c.company_name like '%" . $name_search . "%'";
                                        if ($desc_search != '')
                                            $condition .= " AND c.company_metadescription like '%" . $desc_search . "%'";
                                        if ($title_search != '')
                                            $condition .= " AND c.company_title like '%" . $title_search . "%'";
                                        if ($addr_search != '')
                                            $condition .= " AND c.company_address like '%" . $addr_search . "%'";
                                        if ($zip_search != '')
                                            $condition .= " AND c.company_zip like '%" . $zip_search . "%'";
                                        if ($h1_search != '')
                                            $condition .= " AND c.company_h1 like '%" . $h1_search . "%'";
                                        if ($search_all != '')
                                            $condition .= " AND (c.company_name like '%" . $search_all . "%' OR c.company_metadescription like '%" . $search_all . "%' OR c.company_title like '%" . $search_all . "%' OR c.company_address like '%" . $search_all . "%' OR c.company_zip like '%" . $search_all . "%'  OR c.company_h1 like '%" . $search_all . "%')";
                                        $_SESSION['condition'] = $condition;
                                        $sqll = "SELECT COUNT(*) FROM company as c where 1=1 $condition";
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

                                        $sql = "SELECT * from company as c where 1=1" . $condition;

                                        $sql .= " LIMIT $offset, $rowsperpage";
                                        //echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['id'];
                                                $logo = '';
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['company_name'] . "</td>";
                                                echo "<td>" . $row['company_address'] . "</td>";
                                                echo "<td>" . $row['company_logourl'] . "</td>";
                                                echo "<td><img src='" . $logo . "' style='width': 50px;height: 50px;'></td>";
                                                echo "<td>" . $row['company_zip'] . "</td>";
                                                echo "<td>" . $row['company_h1'] . "</td>";
                                                echo "<td>" . $row['company_metadescription'] . "</td>";
                                                echo "<td>" . $row['company_title'] . "</td>";
//                                                echo "<td><a href = 'edit_category.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_category.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_company.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete_company.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
                                                echo "</tr>";
                                            }
                                            /*                                             * ****  build the pagination links ***** */
// range of num links to show
                                            $range = 3;

// if not on page 1, don't show back links
                                            echo "<tr><td style='text-align:right;margin: 0px;border:1px solid white;' colspan='9'>";
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
                                            echo "<td colspan='9'><p align='center'>No Results Found.</p></td>";
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
                        data: {search: search, name: $('#name_search').val(), desc: $('#desc_search').val(), addr: $('#addr_search').val(), zip: $('#zip_search').val(), title: $('#title_search').val(), h1: $('#h1_search').val(), searchAll: $('#search_all').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);

                        }

                    });
        });
    });
</script>