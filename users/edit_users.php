<?php
include "../control.inc";
include("../config.php");
if (isset($_POST['search'])) {
    postlist($_GET['id'], $con, $_POST['name'], $_POST['category'], $_POST['topic'], $_POST['searchAll']);
    return true;
}

?>
<!DOCTYPE html>
<html lang="en">

    <?php
    $active = "users";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_user = "SELECT * FROM users WHERE id=$id";
        $res_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
    }
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        if ($name == '' || $email == '' || $status == '') {

// generate error message

            $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
        } else {

            $sql = "UPDATE users SET name='" . $name . "', email='" . $email . "', status='" . $status . "' where users.id= $id";
            $res = mysqli_query($con, $sql);
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $_SERVER['REQUEST_URI'] . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $_SERVER['REQUEST_URI'] . '" />';
            echo '</noscript>';
//        header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
    include "../header.php";
    include "../head.php";

    ?>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">

        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">         
                            Edit Users

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="manage_users.php">Manage Users</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Users
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>



                <!-- Example DataTables Card-->
                <div class="card mb-3">
                    <div class="card-body">

                        <?php
                        // if there are any errors, display them
                        if (isset($error) && $error != '') {

                            echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
                        }

                        ?>
                        <div class="col-md-12 ">

                            <div class="row">

                                <div class="container pr0 mb15 pb10 border-bottom">
                                    <div class="col-sm-12 col-md-12 float-right text-right pr0">


                                        <a class="btn delete table-top-btn delete-item" onClick="return confirm('Are you sure you want to delete this?');" href='delete.php?id=<?php echo $id ?>'>Delete User</a>
                                    </div>

                                </div>
                                <form id="userEdit" method="POST">
                                    <div class="form-group">
                                        <label class="field-title">Name of User *</label>
                                        <input type="text" placeholder="Name" value="<?php echo $res_user['name']; ?>" name="name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Email ID *</label>
                                        <input type="text" placeholder="Email" value="<?php echo $res_user['email']; ?>" name="email" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Status *</label>
                                        <!--<input type="text" placeholder="Status"  class="common-input" disabled>-->
                                        <select placeholder="Status" name="status" class="common-input">
                                            <option value="">Select Status</option>
                                            <option value="1" <?php echo $res_user['status'] == 1 ? 'selected' : ''; ?>> Active</option>
                                            <option value="0" <?php echo $res_user['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="">
                                        <label class="field-title border-bottom pb10">Posts</label>
                                        <div class="table-responsive">
                                            <div class="col-md-6 float-right pr0 mb15">
                                                <div class="col-sm-12 col-md-12 float-right text-right pr0">


                                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" id="search_all" class="form-control form-control-sm" placeholder="Search Posts" aria-controls="dataTables-example"></div>
                                                </div>

                                            </div>
                                            <table class="table table-bordered" id="dataTables-example2" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Post Name</th>                 
                                                        <th>Category/Subject</th>                 
                                                        <th>Topic</th>
                                                        <th>Companies</th>
                                                        <th>Comments</th>
                                                        <th>Actions</th>


                                                    </tr>

                                                </thead>
                                                <tr class="table-search">
                                                    <td><label><input type="search" class="form-control form-control-sm" id="name_search" placeholder="Search Post" aria-controls="dataTables-example"></label></td>
                                                    <td><label><input type="search" class="form-control form-control-sm" id="category_search" placeholder="Search by Category" aria-controls="dataTables-example"></label></td>
                                                    <td><label><input type="search" class="form-control form-control-sm" id="topic_search" placeholder="Search by Topic" aria-controls="dataTables-example"></label></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                <tbody id="articleContainer">
                                                    <?php
                                                    postlist($id, $con, $name_search = '', $category_search = '', $topic_search = '', $search_all = '');

                                                    function postlist($id, $con, $name_search, $category_search, $topic_search, $search_all)
                                                    {
                                                        $conditions = '';
                                                        if ($name_search != '')
                                                            $conditions .= " AND article.article_title like '%" . $name_search . "%'";
                                                        if ($category_search != '')
                                                            $conditions .= " AND subject_name like '%" . $category_search . "%'";
                                                        if ($topic_search != '') {
                                                            $conditions .= " AND file_name like '%" . $topic_search . "%'";
                                                        }
                                                        if ($search_all != '')
                                                            $conditions .= " AND (article_title like '%" . $search_all . "%' OR subject_name like '%" . $search_all . "%' OR file_name like '%" . $search_all . "%')";
                                                        $sql_posts = "SELECT article.id,article.article_title, article.article_comment,"
                                                            . " GROUP_CONCAT(DISTINCT c.company_name SEPARATOR ', ') as company_name,"
                                                            . " GROUP_CONCAT(DISTINCT s.subject_name SEPARATOR ', ') as subject_name,"
                                                            . " GROUP_CONCAT(DISTINCT f.file_name SEPARATOR ', ') as topic FROM article  "
                                                            . "LEFT JOIN article_subject as asu ON asu.article_ID = article.id LEFT JOIN subject as s ON asu.subject_ID = s.id "
                                                            . "LEFT JOIN article_company as ac ON ac.article_ID = article.id LEFT JOIN company as c ON c.id = ac.company_ID "
                                                            . "LEFT JOIN article_file as af ON af.article_ID = article.id LEFT JOIN file as f ON af.file_ID = f.id WHERE user_id=$id $conditions Group By article.id;";

//                          echo $sql_posts;exit;
                                                        $query = mysqli_query($con, $sql_posts);
                                                        if ($query && mysqli_num_rows($query) != 0) {
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                $id = $row['id'];
                                                                echo "<tr class='normalRow'>";
                                                                echo "<td>" . $row['article_title'] . "</td>";
                                                                echo "<td>" . $row['subject_name'] . "</td>";
                                                                echo "<td>" . $row['topic'] . "</td>";
                                                                echo "<td>" . $row['company_name'] . "</td>";
                                                                echo "<td>" . $row['article_comment'] . "</td>";
                                                                echo "<td><a href = 'edit_article.php?id=" . $row['id'] . "' class = 'btn edit '>EDIT</a> <a href = 'delete_article.php?id=" . $row['id'] . "' class = 'btn delete'>DELETE</a></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6'><p align='center'>No Results Found.</p></td></tr>";
                                                        }
                                                    }
//                                                    $con->close();

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" id="editArticle" name="submit"  value="Submit"><span>Save</span></button>
                                        <button type="reset" class="btn btn-warning cancel inlline-block" onClick="$(':input').val('');">

                                            <span>Cancel</span>
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid-->
            <?php
            include "../footer.php";

            ?>
            <script>
                $(document).ready(function () {
                    $(".table-responsive input").keyup(function () {
                        var search = true;
                        $.ajax(
                                {
                                    type: 'post',
                                    data: {search: search, name: $('#name_search').val(), category: $('#category_search').val(), topic: $('#topic_search').val(), searchAll: $('#search_all').val()},
                                    success: function (data) {
                                        $('#articleContainer').html(data);

                                    }

                                });
                    });
                });
            </script>
        </div>
    </body>

</html>
