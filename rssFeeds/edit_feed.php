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
        if (isset($_POST['id']))
            $_SESSION['id'] = $_POST['id'];
        if ($_SESSION['id']) {
            $id = $_SESSION['id'];
            $sql_feed = "SELECT * FROM rssfeed WHERE id=$id";
            $res_feed = mysqli_fetch_assoc(mysqli_query($con, $sql_feed));
        }
        if (isset($_POST['rss_name']) && isset($_POST['rss_url'])) {
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
                $sql = "UPDATE rssfeed SET rss_name='" . $name . "', rss_description='" . $desc . "', rss_url='" . $url . "', rss_active='" . $status . "', updated_at='" . $date . "' where rssfeed.id= $id";
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

                            Edit Rss Feed

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Rss Feeds</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Rss Feed
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


                                <form id="topicAdd" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="form-group">
                                        <label class="field-title">Rss Name *</label>
                                        <input type="text" id="rss_name" name="rss_name" placeholder="Rss Name" value="<?php echo $res_feed['rss_name']; ?>"  class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Description</label>
                                        <textarea name="rss_description" class="text-area"><?php echo $res_feed['rss_description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Rss URL *</label>
                                        <textarea id="rss_url" name="rss_url" class="text-area"><?php echo $res_feed['rss_url']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Status</label>
                                        <!--<input type="text" placeholder="Status"  class="common-input" disabled>-->
                                        <select placeholder="Status" name="rss_active" class="common-input">
                                            <option value="1" <?php echo $res_feed['rss_active'] == 1 ? 'selected' : ''; ?>> Active</option>
                                            <option value="0" <?php echo $res_feed['rss_active'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" onclick="return validate()" name="submit"><span>Update</span></button>
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
<script type="text/javascript">
    function validate() {
        var name = document.getElementById('rss_name').value;
        var url = document.getElementById('rss_url').value;

        if (!name || !url) {
            alert('Please fill in all required fields!');
            return false;
        } else {
            return true;
        }
    }
</script>