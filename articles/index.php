<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    unset($_SESSION['condition']);
    article_list($con, $_POST['title'], $_POST['user'], $_POST['subject'], $_POST['topic'], $_POST['searchAll']);
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
        $active = "posts";
        include "../header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            Manage Posts
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Manage Posts</li>
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


                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" id="search_all" class="form-control form-control-sm" placeholder="Search Posts" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="add_new_post.php">Add New Post</a>
                                </div>

                            </div>
                            <table class="table table-bordered" id="dataTables-example2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Recent Posts</th>
                                        <th>Posts By</th>
                                        <th>Category/Subject</th>
                                        <th>News Order</th>
                                        <th>Topic</th>
                                        <th>Companies</th>
                                        <th>Comments</th>
                                        <th>Actions</th>


                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search Post" id="title_search" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by User" id="user_search" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Category" id="category_search" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td><label><input type="search" class="form-control form-control-sm" placeholder="Search by Topic" id="topic_search" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer">
                                    <?php
                                    article_list($con, $title_search = '', $user_search = '', $category_search = '', $topic_search = '', $search_all = '');

                                    function article_list($con, $title_search = '', $user_search = '', $category_search = '', $topic_search = '', $search_all = '')
                                    {
                                        $condition = '';
                                        if (isset($_SESSION['condition']) && isset($_GET['currentpage']))
                                            $condition = $_SESSION['condition'];
                                        if ($title_search != '')
                                            $condition .= " AND at.article_title like '%" . $title_search . "%'";
                                        if ($user_search != '')
                                            $condition .= " AND u.name like '%" . $user_search . "%'";
                                        if ($category_search != '')
                                            $condition .= " AND s.subject_name like '%" . $category_search . "%'";
                                        if ($topic_search != '')
                                            $condition .= " AND t.topic_name like '%" . $topic_search . "%'";
                                        if ($search_all != '')
                                            $condition .= " AND at.article_title like '%" . $search_all . "%' OR u.name like '%" . $search_all . "%' OR s.subject_name like '%" . $search_all . "%'  OR t.topic_name like '%" . $search_all . "%'";
                                        $_SESSION['condition'] = $condition;
                                        $sqll = "SELECT COUNT(*) FROM article as at LEFT JOIN users u on u.id=at.user_id LEFT JOIN article_subject on article_subject.article_ID=at.id LEFT JOIN subject s on s.id=article_subject.subject_ID LEFT JOIN article_topic on article_topic.article_ID=at.id LEFT JOIN topic t on t.id=article_topic.topic_ID LEFT JOIN article_company as ac ON ac.article_ID = at.id LEFT JOIN company as c ON c.id = ac.company_ID  where 1=1 $condition";
                                        $result = mysqli_query($con, $sqll);
//                                        echo $sqll;
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

                                        $sql = "SELECT at.id as article_id, at.article_comment, at.article_title, at.sort_order, u.name,GROUP_CONCAT(DISTINCT s.subject_name SEPARATOR ', ') as subject_name,GROUP_CONCAT(DISTINCT t.topic_name SEPARATOR ', ') as topic_name, GROUP_CONCAT(DISTINCT c.company_name SEPARATOR ', ') as company_name FROM article as at LEFT JOIN users u on u.id=at.user_id LEFT JOIN article_subject on article_subject.article_ID=at.id LEFT JOIN subject s on s.id=article_subject.subject_ID LEFT JOIN article_topic on article_topic.article_ID=at.id LEFT JOIN topic t on t.id=article_topic.topic_ID LEFT JOIN article_company as ac ON ac.article_ID = at.id LEFT JOIN company as c ON c.id = ac.company_ID where 1=1" . $condition . " GROUP BY at.id ORDER BY at.sort_order";

                                        $sql .= " LIMIT $offset, $rowsperpage";
                                        //echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['article_id'];
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['article_title'] . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['subject_name'] . "</td>";
                                                echo "<td>" . $row['sort_order'] . "</td>";
                                                echo "<td>" . $row['topic_name'] . "</td>";
                                                echo "<td>" . $row['company_name'] . "</td>";
                                                echo "<td>" . $row['article_comment'] . "</td>";
//                                                echo "<td><a href = 'edit_category.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_category.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_post.php'><input type='hidden' name='id' value=" . $row['article_id'] . "><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete_post.php'><input type='hidden' name='id' value=" . $row['article_id'] . "><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
                                                echo "</tr>";
                                            }
                                            /*                                             * ****  build the pagination links ***** */
// range of num links to show
                                            $range = 3;

// if not on page 1, don't show back links
                                            echo "<tr><td style='text-align:right;margin: 0px;border:1px solid white;' colspan='8'>";
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
                                            echo "<td colspan='8'><p align='center'>No Results Found.</p></td>";
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
                        data: {search: search, title: $('#title_search').val(), user: $('#user_search').val(), subject: $('#category_search').val(), topic: $('#topic_search').val(), searchAll: $('#search_all').val()},
                        success: function (data) {
                            $('#tableDatContainer').html(data);

                        }

                    });
        });
    });
</script>