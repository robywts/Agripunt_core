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
        $active = "categories";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql_category = "SELECT * FROM subject WHERE id=$id";
            $res_category = mysqli_fetch_assoc(mysqli_query($con, $sql_category));
        }
        if (isset($_POST['submit'])) {
// get form data, making sure it is valid
            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['subject_name']));

            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['subject_title']));

            $description = mysqli_real_escape_string($con, htmlspecialchars($_POST['subject_metadescription']));

            $text = mysqli_real_escape_string($con, htmlspecialchars($_POST['subject_text']));



// check to make sure both fields are entered

            if ($name == '' || $title == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                $sql = "UPDATE subject SET subject_name='" . $name . "', subject_title='" . $title . "', subject_metadescription='" . $description . "', subject_text='" . $text . "' where subject.id= $id";
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

                            Add New Category

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="news_categories.php">News Categories</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Add New Category
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
                                <form id="categoryEdit" method="POST">
                                    <div class="title-field form-group">
                                        <label>Category Title *</label>
                                        <input name="subject_title" value="<?php echo $res_category['subject_title']; ?>" type="text" placeholder="Category Title">
                                    </div>

                                    <div class="form-group">
                                        <label class="field-title">Category Name *</label>
                                        <input type="text" name="subject_name" value="<?php echo $res_category['subject_name']; ?>" placeholder="Category Name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Meta Description</label>
                                        <textarea name="subject_metadescription" value="" class="text-area"><?php echo $res_category['subject_metadescription']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Category Text</label>
                                        <textarea name="subject_text" value="" class="text-area"><?php echo $res_category['subject_text']; ?></textarea>
                                    </div>

                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" name="submit"><span>Update</span></button>
                                        <button type="reset" class="btn btn-warning cancel inlline-block" >

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
