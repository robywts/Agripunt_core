<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    unset($_SESSION['condition']);
    topic_list($con, $_POST['name'], $_POST['h1'], $_POST['desc'], $_POST['text'], $_POST['searchAll']);
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
        $active = "topics";
        include "../header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            News Topics
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">News Topics</li>
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


                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" id="search_all" class="form-control form-control-sm" placeholder="Search Topic" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="add_new_topic.php">Add New Topic</a>
                                </div>

                            </div>
                            <table class="table table-bordered" id="dataTables-example3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Topic  Name</th>
                                        <th>Topic H1</th>
                                        <th>Meta Description</th>
                                        <th>Topic Text</th>
                                        <th>Topic Title</th>
                                        <th>Posts</th>                   
                                        <th>Actions</th>


                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" class="form-control form-control-sm" id="name_search" placeholder="Search By Topic Name" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" id="h1_search"  placeholder="Search By H1" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" id="desc_search"  placeholder="Search By Meta Description" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" id="text_search"  placeholder="Search By Topic Text" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer">
                                    <?php
                                    topic_list($con, $name_search = '', $h1_search = '', $desc_search = '', $text_search = '', $search_all = '');

                                    function topic_list($con, $name_search, $h1_search, $desc_search = '', $text_search = '', $search_all)
                                    {
                                        $condition = '';
                                        if (isset($_SESSION['condition']) && isset($_GET['currentpage']))
                                            $condition = $_SESSION['condition'];
                                        if ($name_search != '')
                                            $condition .= " AND f.topic_name like '%" . $name_search . "%'";
                                        if ($h1_search != '')
                                            $condition .= " AND f.topic_h1 like '%" . $h1_search . "%'";
                                        if ($desc_search != '')
                                            $condition .= " AND f.topic_metadescription like '%" . $desc_search . "%'";
                                        if ($text_search != '')
                                            $condition .= " AND f.topic_text like '%" . $text_search . "%'";
                                        if ($search_all != '')
                                            $condition .= " AND (f.topic_name like '%" . $search_all . "%' OR f.topic_metadescription like '%" . $search_all . "%' OR f.topic_text like '%" . $search_all . "%'  OR f.topic_h1 like '%" . $search_all . "%')";

                                        $_SESSION['condition'] = $condition;
                                        $sqll = "SELECT COUNT(*) FROM topic as f where 1=1 $condition";
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

                                        $sql = "SELECT f.id, f.topic_name, f.topic_h1, f.topic_metadescription, f.topic_title, f.topic_text, (SELECT COUNT(1) AS other FROM article_topic as aff 
    where aff.topic_ID = afi.topic_ID GROUP BY aff.topic_ID) as count FROM topic as f Left JOIN article_topic as afi
    ON f.id = afi.topic_ID where 1=1" . $condition . " GROUP BY f.id";
                                        $sql .= " LIMIT $offset, $rowsperpage";

//                                        echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['id'];
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['topic_name'] . "</td>";
                                                echo "<td>" . $row['topic_h1'] . "</td>";
                                                echo "<td>" . $row['topic_metadescription'] . "</td>";
                                                echo "<td>" . $row['topic_text'] . "</td>";
                                                echo "<td>" . $row['topic_title'] . "</td>";
                                                echo "<td>" . $row['count'] . "</td>";
//                                                echo "<td><a href = 'edit_topic.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_topic.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_topic.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete_topic.php'><input type='hidden' name='id' value=" . $row['id'] . "><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
                                                echo "</tr>";
                                            }
                                            /*                                             * ****  build the pagination links ***** */
// range of num links to show
                                            $range = 3;

// if not on page 1, don't show back links
                                            echo "<tr><td style='text-align:right;margin: 0px;border:1px solid white;' colspan='7'>";
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
                                            echo "<td colspan='7'><p align='center'>No Results Found.</p></td>";
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
                        data: {search: search, name: $('#name_search').val(), h1: $('#h1_search').val(), desc: $('#desc_search').val(), text: $('#text_search').val(), searchAll: $('#search_all').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);

                        }

                    });
        });
    });
</script>
