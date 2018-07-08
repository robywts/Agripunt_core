<?php
header("Content-Type: text/html; charset=ISO-8859-1");
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
        if (isset($_POST['id']))
            $_SESSION['id'] = $_POST['id'];
        if ($_SESSION['id']) {
            $id = $_SESSION['id'];
            $sql_article = "SELECT * FROM article WHERE id=$id";
            $res_article = mysqli_fetch_assoc(mysqli_query($con, $sql_article));

            $sql_subject = "SELECT subject_ID FROM article_subject WHERE article_ID=$id";
            $res_subject = mysqli_fetch_all(mysqli_query($con, $sql_subject));

            $sql_company = "SELECT company_ID FROM article_company WHERE article_ID=$id";
            $res_company = mysqli_fetch_all(mysqli_query($con, $sql_company));

            $sql_topic = "SELECT topic_ID FROM article_topic WHERE article_ID=$id";
            $res_topic = mysqli_fetch_all(mysqli_query($con, $sql_topic));
        }
        $sql_category = "SELECT id, subject_name FROM subject";

        $sql_topic = "SELECT id, topic_name FROM topic";

        $sql_company = "SELECT id, company_name FROM company";

        if (isset($_POST['article_title']) && isset($_POST['subject_ID']) && isset($_POST['article_content'])) {
// get form data, making sure it is valid
            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['article_title']));

            $subject_ids = isset($_POST['subject_ID']) ? $_POST['subject_ID'] : '';

            $topic_ids = isset($_POST['topic_ID']) ? $_POST['topic_ID'] : '';

            $company_ids = isset($_POST['company_ID']) ? $_POST['company_ID'] : '';

            $article_summary = mysqli_real_escape_string($con, htmlspecialchars($_POST['article_summary']));

            $article_content = mysqli_real_escape_string($con, $_POST['article_content']);
            $date = date('Y-m-d H:i:s');

            if ($_FILES['file']['name'] != '') {
                for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
                    //echo $_FILES["file"]["size"][$i];exit;
                    if ((($_FILES["file"]["type"][$i] == "video/mp4") || ($_FILES["file"]["type"][$i] == "audio/mp3") || ($_FILES["file"]["type"][$i] == "audio/wma") || ($_FILES["file"]["type"][$i] == "image/pjpeg") || ($_FILES["file"]["type"][$i] == "image/gif") || ($_FILES["file"]["type"][$i] == "image/jpeg")) && ($_FILES["file"]["size"][$i] > 10485760))
                        $file_rrror = 1;
                }
            }
// check to make sure both fields are entered

            if ($title == '' || $subject_ids == '' || $article_content == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';

// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else if (isset($file_rrror)) {
                $error = 'ERROR: Please select Image/Video having size less than 10MB!';
            } else {
                $article_user = $res_article['user_id'];
// save the data to the database
                $sql = "UPDATE article SET article_title='$title', article_summary='$article_summary', article_content='$article_content', user_id='$article_user', updated_at='" . $date . "' where article.id= $id";
                $res = mysqli_query($con, $sql);

                $result2 = mysqli_query($con, "DELETE FROM article_subject WHERE article_ID=$id");
                $result3 = mysqli_query($con, "DELETE FROM article_company WHERE article_ID=$id");
                $result4 = mysqli_query($con, "DELETE FROM article_topic WHERE article_ID=$id");
                if ($subject_ids != '') {
                    foreach ($subject_ids as $subject_id) {
                        mysqli_query($con, "INSERT article_subject SET article_ID='$id', subject_ID='$subject_id'");
                    }
                }
                if ($topic_ids != '') {
                    foreach ($topic_ids as $topic_id) {
                        mysqli_query($con, "INSERT article_topic SET article_ID='$id', topic_ID='$topic_id'");
                    }
                }
                if ($company_ids != '') {
                    foreach ($company_ids as $company_id) {
                        mysqli_query($con, "INSERT article_company SET article_ID='$id', company_ID='$company_id'");
                    }
                }

                if (count($_FILES["file"]["name"]) > 0 && $_FILES['file']['size'][0] > 0) {
                    mysqli_query($con, "DELETE FROM article_image WHERE article_ID=$id");
                    array_map('unlink', glob($_POST['old_img']));
                    for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
                        $condition = '';
                        $file = rand(1000, 100000) . "-" . $_FILES['file']['name'][$i];
                        $file_loc = $_FILES['file']['tmp_name'][$i];
                        $file_size = $_FILES['file']['size'][$i];
                        $file_type = $_FILES['file']['type'][$i];
                        $folder = "../uploads/articles/$id/";
                        if (!is_dir("../uploads/articles/$id/")) {
                            mkdir("../uploads/articles/$id/");
                        }
                        move_uploaded_file($file_loc, $folder . $file);
                        $condition .= " image_url='" . $file . "',article_ID= $id";
                        $sql = "INSERT article_image SET $condition";
                        $res = mysqli_query($con, $sql);
                    }
                }
// once saved, redirect back to the view page
                echo '<script type="text/javascript">';
                echo 'window.location.href="' . $_SERVER['REQUEST_URI'] . '";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=' . $_SERVER['REQUEST_URI'] . '" />';
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

                            Edit Post

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Posts</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Post
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
                                <form  method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="title-field form-group">
                                        <label>Article Title *</label>
                                        <input id="article_title" type="text" name="article_title" value="<?php echo $res_article['article_title']; ?>" placeholder="Article Title">
                                    </div>
                                    <div class="multi-select-field">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="multi-label">Article Subject *</label>
                                                <div class="row">
                                                    <select class="js-example-basic-multiple form-control" id="subjectList" name="subject_ID[]" multiple="multiple">
                                                        <?php
                                                        $category = mysqli_query($con, $sql_category);
                                                        if ($category && mysqli_num_rows($category) != 0) {
                                                            while ($category_res = mysqli_fetch_assoc($category)) {
                                                                foreach ($res_subject as $subject) {
                                                                    $selected_cat = '';
                                                                    if ($subject[0] == $category_res['id']) {
                                                                        $selected_cat = 'selected';
                                                                        break;
                                                                    }
                                                                }
                                                                echo "<option $selected_cat value = " . $category_res['id'] . ">" . $category_res['subject_name'] . "</option>";
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
                                                    <select class="js-example-basic-multiple form-control" id="topicList" name="topic_ID[]" multiple="multiple">
                                                        <?php
                                                        $topic = mysqli_query($con, $sql_topic);
                                                        if ($topic && mysqli_num_rows($topic) != 0) {
                                                            while ($topic_res = mysqli_fetch_assoc($topic)) {
                                                                foreach ($res_topic as $restopic) {
                                                                    $selected_topic = '';
                                                                    if ($restopic[0] == $topic_res['id']) {
                                                                        $selected_topic = 'selected';
                                                                        break;
                                                                    }
                                                                }
                                                                echo "<option $selected_topic value = " . $topic_res['id'] . ">" . $topic_res['topic_name'] . "</option>";
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
                                                    <select class="js-example-basic-multiple form-control" id="companyList" name="company_ID[]" multiple="multiple">
                                                        <?php
                                                        $company = mysqli_query($con, $sql_company);
                                                        if ($company && mysqli_num_rows($company) != 0) {
                                                            while ($company_res = mysqli_fetch_assoc($company)) {
                                                                foreach ($res_company as $rescompany) {
                                                                    $selected_comp = '';
                                                                    if ($rescompany[0] == $company_res['id']) {
                                                                        $selected_comp = 'selected';
                                                                        break;
                                                                    }
                                                                }
                                                                echo "<option $selected_comp value = " . $company_res['id'] . ">" . $company_res['company_name'] . "</option>";
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
                                                        <input type="file" name="file[]" value="">
                                                        <input class="btn btn-primary" type="button" onclick="add_file();" value="ADD MORE">
                                                        <input id="old_img" type="hidden" name="old_img" value="../uploads/articles/<?php echo $id . '/*' ?>"/>
                                                    </div>
                                                </div>  
                                                <i>Note: Select all files of this article.</i><p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md12 multi-file-select">
                                        <div class="row">
                                            <div class="container">
                                                <label class="field-title">Enter Summary</label>
                                                <textarea name="article_summary" class="text-area"><?php echo $res_article['article_summary']; ?></textarea>
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

                                                <button class="btn btn-primary btn-block inlline-block" onclick="return validate()" name="submit"><span>Save</span></button>
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
                                                    function validate() {
                                                        $("#txtEditor").val($("#txtEditor").Editor("getText"));
                                                        var title_exist = document.getElementById('article_title').value;
                                                        var subject_exist = document.getElementById('subjectList').value;
                                                        var content_exist = document.getElementById('txtEditor').value;

                                                        if (!title_exist || !subject_exist || !content_exist) {
                                                            alert('Please fill in all required fields!');
                                                            return false;
                                                        } else {
                                                            return true;
                                                        }
                                                    }
                                                    
                                                    /*  $(function () {
                                                     $('.multiselect-ui').multiselect({
                                                     includeSelectAllOption: true
                                                     });
                                                     });*/

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
                $('.js-example-basic-multiple').select2();
                $("#subjectList").select2({
                    placeholder: "Select Subject(s)",
                    allowClear: true
                });
                $("#topicList").select2({
                    placeholder: "Select Topic(s)",
                    allowClear: true
                });
                $("#companyList").select2({
                    placeholder: "Select Company(s)",
                    allowClear: true
                });
                $("#txtEditor").Editor("setText", '<?php echo str_replace("'", "/", $res_article['article_content']); ?>');
            });
            $(document).submit(function () {
                $("#txtEditor").val($("#txtEditor").Editor("getText"));
            });
        </script>
        <link href="../css/editor.css" type="text/css" rel="stylesheet"/>

    </body>
</html>