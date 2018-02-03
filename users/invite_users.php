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
        $active = "users";

        if (isset($_POST['submit'])) {
// get form data, making sure it is valid

            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['name']));

            $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));

            $status = mysqli_real_escape_string($con, htmlspecialchars($_POST['status']));

            $password = password_hash($_POST['name'].'123', PASSWORD_DEFAULT);

// check to make sure both fields are entered

            if ($name == '' || $email == '' || $status == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                mysqli_query($con, "INSERT users SET name='$name', email='$email', status='$status', type='2', password='$password'")

                    or die(mysqli_error($con));
// once saved, redirect back to the view page
                echo '<script type="text/javascript">';
                echo 'window.location.href="manage_users.php";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=manage_users.php" />';
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

                            Invite Users

                        </div>

                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="manage_users.php">Manage Users</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Invite Users
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


                                <form id="userAdd" method="POST">
                                    <div class="form-group">
                                        <label class="field-title">Name of User *</label>
                                        <input type="text" name="name" placeholder="Name of User" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Email ID *</label>
                                        <input type="text" name="email" placeholder="Email"  class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Status *</label>
                                        <!--<input type="text" placeholder="Status"  class="common-input" disabled>-->
                                        <select placeholder="Status" name="status" class="common-input">
                                            <option value="">Select Status</option>
                                            <option value="1" > Active</option>
                                            <option value="0" >Inactive</option>
                                        </select>
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" id="addArticle" name="submit"  value="Submit"><span>Invite</span></button>
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
        </div>
    </body>

</html>

