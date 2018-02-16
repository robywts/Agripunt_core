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
        $active = "rssfeeds";

        if (isset($_POST['submit'])) {
// get form data, making sure it is valid
            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['rss_name']));

            $desc = mysqli_real_escape_string($con, htmlspecialchars($_POST['rss_description']));

            $url = mysqli_real_escape_string($con, htmlspecialchars($_POST['rss_url']));

            $status = mysqli_real_escape_string($con, htmlspecialchars($_POST['rss_active']));
            $date = date('Y-m-d H:i:s');

// check to make sure both fields are entered

            if ($name == '' || $url == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                mysqli_query($con, "INSERT rssfeed SET rss_name='$name', rss_description='$desc', rss_url='$url', rss_active='$status', created_at='$date'")

                    or die(mysqli_error($con));
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

                            Add New Rss Feed

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Rss Feeds</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Add New Rss Feed
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
                                        <label class="field-title">Rss Name *</label>
                                        <input type="text" name="rss_name" placeholder="Rss Name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Description</label>
                                        <textarea name="rss_description" class="text-area"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Rss URL *</label>
                                        <textarea  name="rss_url" class="text-area"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Status</label>
                                        <!--<input type="text" placeholder="Status"  class="common-input" disabled>-->
                                        <select placeholder="Status" name="rss_active" class="common-input">
                                            <option value="1" > Active</option>
                                            <option value="0" >Inactive</option>
                                        </select>
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" name="submit"><span>Add</span></button>
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
