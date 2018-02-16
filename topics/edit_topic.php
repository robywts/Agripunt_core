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
        $active = "topics";
        if (isset($_POST['id']))
            $_SESSION['id'] = $_POST['id'];
        if ($_SESSION['id']) {
            $id = $_SESSION['id'];
            $sql_topic = "SELECT * FROM topic WHERE id=$id";
            $res_topic = mysqli_fetch_assoc(mysqli_query($con, $sql_topic));
        }
        if (isset($_POST['submit'])) {
// get form data, making sure it is valid
            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['topic_name']));

            $h1 = mysqli_real_escape_string($con, htmlspecialchars($_POST['topic_h1']));

            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['topic_title']));

            $description = mysqli_real_escape_string($con, htmlspecialchars($_POST['topic_metadescription']));

            $text = mysqli_real_escape_string($con, htmlspecialchars($_POST['topic_text']));



// check to make sure both fields are entered

            if ($name == '' || $title == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                $sql = "UPDATE topic SET topic_name='" . $name . "',topic_h1='" . $h1 . "', topic_title='" . $title . "', topic_metadescription='" . $description . "', topic_text='" . $text . "' where topic.id= $id";
                $res = mysqli_query($con, $sql);
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

                            Edit Topic

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">News Topics</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Topic
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


                                <form id="topicAdd" method="POST">
                                    <div class="form-group">
                                        <label class="field-title">Topic Name *</label>
                                        <input type="text" value="<?php echo $res_topic['topic_name']; ?>" name="topic_name" placeholder="Topic Name" class="common-input">
                                    </div>
                                    <div class="title-field form-group">
                                        <label>Topic H1 </label>
                                        <input name="topic_h1" value="<?php echo $res_topic['topic_h1']; ?>" type="text" placeholder="Topic H1">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Meta Description</label>
                                        <textarea name="topic_metadescription" class="text-area"><?php echo $res_topic['topic_metadescription']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Topic Text</label>
                                        <textarea  name="topic_text" class="text-area"><?php echo $res_topic['topic_text']; ?></textarea>
                                    </div>
                                    <div class="title-field form-group">
                                        <label>Topic Title *</label>
                                        <input value="<?php echo $res_topic['topic_title']; ?>" type="text" name="topic_title" placeholder="Topic Title">
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" name="submit"><span>Update</span></button>
                                        <button type="reset" class="btn btn-warning cancel inlline-block">

                                            <span>Cancel</span>
                                        </button>

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
    </div>
</body>

</html>
