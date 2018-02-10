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
        $active = "subscribers";
        if (isset($_POST['id']))
            $_SESSION['id'] = $_POST['id'];
        if ($_SESSION['id']) {
            $id = $_SESSION['id'];
            $sql_subscriber = "SELECT * FROM subscribers WHERE id=$id";
            $res_subscriber = mysqli_fetch_assoc(mysqli_query($con, $sql_subscriber));
        }
        if (isset($_POST['submit'])) {
// get form data, making sure it is valid
            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['subscriber_name']));

            $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['subscriber_email']));

          //  $date = mysqli_real_escape_string($con, htmlspecialchars($_POST['subscribed_date']));



// check to make sure both fields are entered

            if ($name == '' || $email == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                $sql = "UPDATE subscribers SET name='" . $name . "', email='" . $email . "' where subscribers.id= $id";
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

                            Edit News Letter Subscriber

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">News Letter Subscribers</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit News Letter Subscriber
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


                                <form id="subscriberEdit" method="POST">
                                    <div class="form-group">
                                        <label class="field-title">Subscriber Name *</label>
                                        <input type="text" value="<?php echo $res_subscriber['name']; ?>" name="subscriber_name" placeholder="Subscriber Name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Subscriber Email *</label>
                                        <input type="text" value="<?php echo $res_subscriber['email']; ?>" name="subscriber_email" placeholder="Subscriber Email" class="common-input">
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
