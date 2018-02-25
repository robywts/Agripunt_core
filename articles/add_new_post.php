<?php
include "../control.inc";
include("../config.php");

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


        $sql_category = "SELECT id, subject_name FROM subject";

        $sql_topic = "SELECT id, topic_name FROM topic";

        $sql_company = "SELECT id, company_name FROM company";

        if (isset($_POST['submit'])) {

// get form data, making sure it is valid
            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['article_title']));

            $subject_ids = isset($_POST['subject_ID']) ? $_POST['subject_ID'] : '';

            $topic_ids = isset($_POST['topic_ID']) ? $_POST['topic_ID'] : '';

            $company_ids = isset($_POST['company_ID']) ? $_POST['company_ID'] : '';

            $article_summary = mysqli_real_escape_string($con, htmlspecialchars($_POST['article_summary']));

            $article_content = mysqli_real_escape_string($con, $_POST['article_content']);

// check to make sure both fields are entered

            if ($title == '' || $subject_ids == '' || $article_content == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';

// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {
// save the data to the database
              $sql = "INSERT article SET article_title='$title', article_summary='$article_summary', article_content='$article_content', user_id=1";
             // echo $sql;exit;  
              mysqli_query($con, "INSERT article SET article_title='$title', article_summary='$article_summary', article_content='$article_content', user_id=1")

                    or die(mysqli_error($con));
                $insert_id = mysqli_insert_id($con);
                if ($insert_id) {
                    if ($subject_ids != '') {
                        foreach ($subject_ids as $subject_id) {
                            mysqli_query($con, "INSERT article_subject SET article_ID='$insert_id', subject_ID='$subject_id'");
                        }
                    }
                    if ($topic_ids != '') {
                        foreach ($topic_ids as $topic_id) {
                            mysqli_query($con, "INSERT article_topic SET article_ID='$insert_id', topic_ID='$topic_id'");
                        }
                    }
                    if ($company_ids != '') {
                        foreach ($company_ids as $company_id) {
                            mysqli_query($con, "INSERT article_company SET article_ID='$insert_id', company_ID='$company_id'");
                        }
                    }
                    if ($_FILES['file']['name'] != '') {
                        for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
                            $condition = '';
                            $file = rand(1000, 100000) . "-" . $_FILES["file"]["name"][$i];
                            $file_loc = $_FILES["file"]['tmp_name'][$i];
                            $file_size = $_FILES['file']['size'][$i];
                            $file_type = $_FILES['file']['type'][$i];
                            $folder = "../uploads/articles/$insert_id/";
                            if (!is_dir("../uploads/articles/$insert_id/")) {
                                mkdir("../uploads/articles/$insert_id/");
                            }
                            move_uploaded_file($file_loc, $folder . $file);
                            $condition .= " image_url='" . $file . "',article_ID= $insert_id";
                            $sql = "INSERT article_image SET $condition";
                            $res = mysqli_query($con, $sql);
                        }
                    }
                } else {
                    $error = 'ERROR: Form Submission,Please Try again.!';
                }
// once saved, redirect back to the view page
                echo '<script type="text/javascript">';
                echo 'window.location.href="index.php";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=index.php" />';
                echo '</noscript>';
//                header("Location: manage_users.php");
            }
        }



        include "../header.php";

        ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="page-title">       
                            Add New Post            
                        </div>
                        <div class="bread-crumbs">
                            <!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">
                                    <a href="manage_posts.html">Manage Posts</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Add New Post
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- Example DataTables Card-->
                <div class="">
                    <div class="card mb-3">
                        <div class="card-body">
                            <?php
// if there are any errors, display them
                            if (isset($error) && $error != '') {

                                echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
                            }

                            ?>
                            <form  method="post" enctype="multipart/form-data">
                                <div class="title-field form-group">
                                    <label>Article Title *</label>
                                    <input type="text" name="article_title" placeholder="Article Title">
                                </div>
                                <div class="multi-select-field">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="multi-label">Article Subject *</label>
                                            <div class="row">
                                                <select id="dates-field2" name="subject_ID[]" class="multiselect-ui form-control" multiple="multiple" >
                                                    <?php
                                                    $category = mysqli_query($con, $sql_category);
                                                    if ($category && mysqli_num_rows($category) != 0) {
                                                        while ($category_res = mysqli_fetch_assoc($category)) {
                                                            echo "<option value = " . $category_res['id'] . ">" . $category_res['subject_name'] . "</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="multi-select-field">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="multi-label">Article Topic</label>
                                            <div class="row">
                                                <select id="dates-field2" name="topic_ID[]" class="multiselect-ui form-control" multiple="multiple" >
                                                    <?php
                                                    $topic = mysqli_query($con, $sql_topic);
                                                    if ($topic && mysqli_num_rows($topic) != 0) {
                                                        while ($topic_res = mysqli_fetch_assoc($topic)) {
                                                            echo "<option value = " . $topic_res['id'] . ">" . $topic_res['topic_name'] . "</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="multi-select-field">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="multi-label">Company</label>
                                            <div class="row">
                                                <select id="dates-field2" name="company_ID[]" class="multiselect-ui form-control" multiple="multiple" >
                                                    <?php
                                                    $company = mysqli_query($con, $sql_company);
                                                    if ($company && mysqli_num_rows($company) != 0) {
                                                        while ($company_res = mysqli_fetch_assoc($company)) {
                                                            echo "<option value = " . $company_res['id'] . ">" . $company_res['company_name'] . "</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md12 multi-file-select">
                                    <div class="row">
                                        <div class="container">
                                            <label class="field-title">Upload Image/Video</label>
                                            <!-- The file upload form used as target for the file upload widget -->
                                            <div id="file_div">
                                                <div>
                                                    <input type="file" name="file[]">
                                                    <input class="btn btn-primary" type="button" onclick="add_file();" value="ADD MORE">
                                                </div>
                                            </div>                                 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md12 multi-file-select">
                                    <div class="row">
                                        <div class="container">
                                            <label class="field-title">Enter Summary</label>
                                            <textarea name="article_summary" class="text-area"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="container">
                                            <div class="row">

                                                <div class="col-lg-12 nopadding">
                                                    <label class="field-title">Enter Article *</label>
                                                    <textarea name="article_content" id="txtEditor"></textarea> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="button-group">

                                            <button class="btn btn-primary btn-block inlline-block" name="submit"><span>Save</span></button>
                                            <button type="reset" class="btn btn-warning cancel inlline-block">

                                                <span>Cancel</span>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid-->
                <?php
                include "../footer.php";

                ?>
                <script src="../js/editor.js"></script>
                <script src="../js/multiselect.js"></script>
                <script type="text/javascript">
                                                        $(function () {
                                                            $('.multiselect-ui').multiselect({
                                                                includeSelectAllOption: true
                                                            });
                                                        });

                                                        function add_file()
                                                        {
                                                            $("#file_div").append("<div><input type='file' name='file[]'>&nbsp;<input type='button' value='REMOVE' onclick=remove_file(this);></div>");
                                                        }
                                                        function remove_file(ele)
                                                        {
                                                            $(ele).parent().remove();
                                                        }
                </script>

                <script>
                    $(document).ready(function () {
                        $("#txtEditor").Editor();
                    });
                    $(document).submit(function () {
                        $("#txtEditor").val($("#txtEditor").Editor("getText"));
                    });

                </script>
                <link href="../css/editor.css" type="text/css" rel="stylesheet"/>

                </body>
                </html>