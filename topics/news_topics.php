<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    file_list($con, $_POST['name'], $_POST['desc'], $_POST['text'], $_POST['searchAll']);
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
                            <table class="table table-bordered scrollTable" id="dataTables-example3" width="100%" cellspacing="0">
                                <thead class="fixedHeader">
                                    <tr>
                                        <th>Topic  Name</th>
                                        <th>Meta Description</th>
                                        <th>Topic Text</th>
                                        <th>Topic Title</th>
                                        <th>Posts</th>                   
                                        <th>Actions</th>


                                    </tr>

                                </thead>
                                <tr class="table-search">
                                    <td><label><input type="search" class="form-control form-control-sm" id="name_search" placeholder="Search By Topic Name" aria-controls="dataTables-example"></label></td>

                                     <td><label><input type="search" class="form-control form-control-sm" id="desc_search"  placeholder="Search By Meta Description" aria-controls="dataTables-example"></label></td>
                                    <td><label><input type="search" class="form-control form-control-sm" id="text_search"  placeholder="Search By Topic Text" aria-controls="dataTables-example"></label></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="tableDatContainer" class="scrollContent">
                                    <?php
                                    file_list($con, $name_search = '', $desc_search = '', $text_search = '', $search_all = '');

                                    function file_list($con, $name_search, $desc_search = '', $text_search = '', $search_all)
                                    {
                                        $condition = '';
                                        if ($name_search != '')
                                            $condition .= " AND f.file_name like '%" . $name_search . "%'";
                                        if ($desc_search != '')
                                            $condition .= " AND f.file_metadescription like '%" . $desc_search . "%'";
                                        if ($text_search != '')
                                            $condition .= " AND f.file_text like '%" . $text_search . "%'";
                                        if ($search_all != '')
                                            $condition .= " AND (f.file_name like '%" . $search_all . "%' OR f.file_metadescription like '%" . $search_all . "%' OR f.file_text like '%" . $search_all . "%')";
                                        $sql = "SELECT f.id, f.file_name, f.file_metadescription, f.file_title, f.file_text, (SELECT COUNT(1) AS other FROM article_file as aff 
    where aff.file_ID = afi.file_ID GROUP BY aff.file_ID) as count FROM file as f Left JOIN article_file as afi
    ON f.id = afi.file_ID where 1=1" . $condition . " GROUP BY f.id";


//                                        echo $sql;
                                        $query = mysqli_query($con, $sql);
                                        if ($query && mysqli_num_rows($query) != 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row['id'];
                                                echo "<tr class='normalRow'>";
                                                echo "<td>" . $row['file_name'] . "</td>";
                                                echo "<td>" . $row['file_metadescription'] . "</td>";
                                                echo "<td>" . $row['file_text'] . "</td>";
                                                echo "<td>" . $row['file_title'] . "</td>";
                                                echo "<td>" . $row['count'] . "</td>";
                                                echo "<td><a href = 'edit_topic.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_topic.php?id=" . $row['id'] . "' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class = 'btn delete'>DELETE</a></td>";
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