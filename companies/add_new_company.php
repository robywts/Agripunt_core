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
        $active = "companies";

        if (isset($_POST['submit'])) {
// get form data, making sure it is valid
            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_name']));

            $addr = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_address']));

            $desc = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_metadescription']));

            $zip = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_zip']));

            $h1 = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_h1']));

            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_title']));

//            $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['company_metadescription']));
// check to make sure both fields are entered

            if ($name == '' || $addr == '') {

// generate error message

                $error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
            } else {

// save the data to the database
                mysqli_query($con, "INSERT company SET company_name='$name', company_address='$addr', company_metadescription='$desc', company_zip='$zip', company_h1='$h1', company_title='$title'")

                    or die(mysqli_error($con));

                $insert_id = mysqli_insert_id($con);
                if ($insert_id) {
                    if ($_FILES['company_logo']['name'] != '') {
                        $condition = '';
                        $file = rand(1000, 100000) . "-" . $_FILES['company_logo']['name'];
                        $file_loc = $_FILES['company_logo']['tmp_name'];
                        $file_size = $_FILES['company_logo']['size'];
                        $file_type = $_FILES['company_logo']['type'];
                        $folder = "../uploads/companies/$insert_id/";
                        if (!is_dir("../uploads/companies/$insert_id/")) {
                            mkdir("../uploads/companies/$insert_id/");
                        }
                        move_uploaded_file($file_loc, $folder . $file);
                        $condition .= " company_logourl='" . $file . "'";
                        $sql = "UPDATE company SET $condition where company.id= $insert_id";
                        $res = mysqli_query($con, $sql);
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

                            Add New Company

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">News Company</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Add New Company
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
                                <form id="companyAdd" method="POST" enctype="multipart/form-data">
                                    <div class="title-field form-group">
                                        <label>Company Title </label>
                                        <input name="company_title" type="text" placeholder="Company Title">
                                    </div>

                                    <div class="form-group">
                                        <label class="field-title">Company Name *</label>
                                        <input type="text" name="company_name" placeholder="Company Name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Address *</label>
                                        <textarea name="company_address" class="text-area"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Zip</label>
                                        <input type="number" name="company_zip" placeholder="Company Zip" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Meta Description</label>
                                        <textarea name="company_metadescription" class="text-area"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company H1</label>
                                        <input type="text" name="company_h1" placeholder="Company H1" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Logo</label>
                                        <input type="file" name="company_logo" placeholder="Company Logo" class="common-input">
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" name="submit"><span>Add</span></button>
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
        </div>
        <!-- /.container-fluid-->
        <?php
        include "../footer.php";

        ?>
    </div>
</body>

</html>
