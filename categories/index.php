<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    category_list($con, $_POST['name'], $_POST['desc'], $_POST['text'], $_POST['searchAll']);
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
        $active = "categories";
        include "../header.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">
                            News Categories
                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">News Categories</li>
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


                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" class="form-control form-control-sm" id="search_all"  placeholder="Search Category" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="add_new_category.php">Add New Category</a>
                                </div>

                            </div>
                            <table class="table table-bordered scrollTable" id="dataTables-example3" width="100%" cellspacing="0">
                                <thead class="fixedHeader">
                                    <tr class="alternateRow">
                                        <th>Category Name</th>
                                        <th>Meta Description</th>
                                        <th>Category Text</th>
                                        <th>Category Title</th>
                                        <th>Posts</th>                   
                                        <th>Actions</th>


                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" class="form-control form-control-sm" id="name_search"  placeholder="Search By Category Name" aria-controls="dataTables-example"></label></td>

                                    <td><label><input type="search" class="form-control form-control-sm" id="desc_search"  placeholder="Search By Meta Description" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" id="text_search"  placeholder="Search By Category Text" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer" class="scrollContent">
                                    <?php
                                    category_list($con, $name_search = '', $desc_search = '', $text_search = '', $search_all = '');

                                    function category_list($con, $name_search, $desc_search = '', $text_search = '', $search_all)
                                    {
                                        $condition = '';
                                        if ($name_search != '')
                                            $condition .= " AND s.subject_name like '%" . $name_search . "%'";
                                        if ($desc_search != '')
                                            $condition .= " AND s.subject_metadescription like '%" . $desc_search . "%'";
                                        if ($text_search != '')
                                            $condition .= " AND s.subject_text like '%" . $text_search . "%'";
                                        if ($search_all != '')
                                            $condition .= " AND (s.subject_name like '%" . $search_all . "%' OR s.subject_metadescription like '%" . $search_all . "%' OR s.subject_text like '%" . $search_all . "%')";
                                        $sql = "SELECT s.id, s.subject_name, s.subject_metadescription, s.subject_title, s.subject_text, (SELECT COUNT(1) AS other FROM article_subject as ass 
    where ass.subject_ID = asub.subject_ID GROUP BY ass.subject_ID) as count FROM subject as s Left JOIN article_subject as asub
    ON s.id = asub.subject_ID where 1=1" . $condition . " GROUP BY s.id";


                                        //echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['id'];
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['subject_name'] . "</td>";
                                                echo "<td>" . $row['subject_metadescription'] . "</td>";
                                                echo "<td>" . $row['subject_text'] . "</td>";
                                                echo "<td>" . $row['subject_title'] . "</td>";
                                                echo "<td>" . $row['count'] . "</td>";
//                                                echo "<td><a href = 'edit_category.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_category.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
                                                echo "<td><div style='margin-left:5px;float: left;'><form method='post' action='edit_category.php'><input type='hidden' name='id' value=".$row['id']."><input type='submit' value='Edit' id='edit_btn' class='btn edit'></form></div><div style='margin-left:5px;float:left;'><form method='post' action='delete_category.php'><input type='hidden' name='id' value=".$row['id']."><input type='submit' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete' value='Delete' id='delete_btn' class='btn delete'></form></div></td>";
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
                        data: {search: search, name: $('#name_search').val(), desc: $('#desc_search').val(), text: $('#text_search').val(), searchAll: $('#search_all').val()},
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
        width: 200px  
    }

    html>body thead.fixedHeader th + th { /* TH 2 */
        width: 200px  
    }

    html>body thead.fixedHeader th + th + th { /* TH 3 +16px for scrollbar */
        width: 210px  
    }
    html>body thead.fixedHeader th + th + th + th { /* TH 3 +16px for scrollbar */
        width: 150px  
    }

    html>body thead.fixedHeader th + th + th + th + th { /* TH 3 +16px for scrollbar */
        width: 65px  
    }

    html>body thead.fixedHeader th + th + th + th + th + th { /* TH 3 +16px for scrollbar */
        width: 201px  
    }
    html>body tr.table-search  {
        display: block
    }

    html>body tr.table-search td { /* TH 1 */
        width: 200px  
    }

    html>body tr.table-search td + td { /* TH 2 */
        width: 200px  
    }

    html>body tr.table-search td + td + td { /* TH 3 +16px for scrollbar */
        width: 210px  
    }

    html>body tr.table-search td + td + td + td { /* TH 3 +16px for scrollbar */
        width: 150px  
    }
    html>body tr.table-search td + td + td + td + td { /* TH 3 +16px for scrollbar */
        width: 65px  
    }
    html>body tr.table-search td + td + td + td + td + td{ /* TH 3 +16px for scrollbar */
        width: 201px  
    }
    html>body tbody.scrollContent td { /* TD 1 */
        width: 200px  
    }

    html>body tbody.scrollContent td + td { /* TD 2 */
        width: 200px  
    }

    html>body tbody.scrollContent td + td + td { /* TD 3 +16px for scrollbar */
        width: 210px  
    }

    html>body tbody.scrollContent td + td + td + td { /* TD 3 +16px for scrollbar */
        width: 150px  
    }
    html>body tbody.scrollContent td + td + td + td + td { /* TD 3 +16px for scrollbar */
        width: 65px  
    }

    html>body tbody.scrollContent td + td + td + td + td + td { /* TD 3 +16px for scrollbar */
        width: 185px  
    }
</style>