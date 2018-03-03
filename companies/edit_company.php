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
        if (isset($_POST['id']))
            $_SESSION['id'] = $_POST['id'];
        if ($_SESSION['id']) {
            $id = $_SESSION['id'];
            $sql_company = "SELECT * FROM company WHERE id=$id";
            $res_company = mysqli_fetch_assoc(mysqli_query($con, $sql_company));
            $imgg = $res_company['company_logourl'];
            $prev_image = $res_company['company_logourl'] ? "<p><img style='width: 100px;height: 100px;' src='../uploads/companies/$id/$imgg' />" : '';
        }
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
                $sql = "UPDATE company SET company_name='$name', company_address='$addr', company_metadescription='$desc', company_zip='$zip', company_h1='$h1', company_title='$title' where company.id= $id";
                $res = mysqli_query($con, $sql);

                if ($_FILES['company_logo']['name'] != '') {
                    $condition = '';
                    $file = rand(1000, 100000) . "-" . $_FILES['company_logo']['name'];
                    $file_loc = $_FILES['company_logo']['tmp_name'];
                    $file_size = $_FILES['company_logo']['size'];
                    $file_type = $_FILES['company_logo']['type'];
                    $folder = "../uploads/companies/$id/";
                    if (!is_dir("../uploads/companies/$id/")) {
                        mkdir("../uploads/companies/$id/");
                    }
                    move_uploaded_file($file_loc, $folder . $file);
                    $condition .= " company_logourl='" . $file . "'";
                    $sql = "UPDATE company SET $condition where company.id= $id";
                    $res = mysqli_query($con, $sql);
                    if ($res_company['company_logourl'] != '')
                        unlink($_POST['old_img']);
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

                            Edit Company

                        </div>
                        <div class="bread-crumbs"><!-- Breadcrumbs-->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Companies</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Company
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
                                <form id="companyEdit" method="POST" enctype="multipart/form-data">
                                    <div class="title-field form-group">
                                        <label>Company Title </label>
                                        <input name="company_title" type="text" value="<?php echo $res_company['company_title']; ?>" placeholder="Company Title">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Name *</label>
                                        <input type="text" name="company_name" value="<?php echo $res_company['company_name']; ?>" placeholder="Company Name" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Address *</label>
                                        <textarea name="company_address" class="text-area"><?php echo $res_company['company_address']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Zip</label>
                                        <input type="number" name="company_zip" value="<?php echo $res_company['company_zip']; ?>" placeholder="Company Zip" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Meta Description</label>
                                        <textarea name="company_metadescription" class="text-area"><?php echo $res_company['company_metadescription']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company H1</label>
                                        <input type="text" name="company_h1" value="<?php echo $res_company['company_h1']; ?>" placeholder="Company H1" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Company Logo</label>
                                        <input type="file" name="company_logo" onchange="readURL(this);"  placeholder="Company Logo" class="common-input">
                                        <!--<p><img style="width: 100px;height: 100px;" src="../uploads/companies/<?php echo $id . '/' . $res_company['company_logourl']; ?>" />-->
                                        <div id='preview_img' style="padding-top: 5px" ><?php echo $prev_image ?></div>
                                        <div style="padding-top: 5px" ><p><img id="edit_prev" style="width: 100px;height: 100px;" src="#" alt="" /></p></div>
                                        <input id="old_img" type="hidden" name="old_img" value="../uploads/companies/<?php echo $id . '/' . $res_company['company_logourl']; ?>"/>
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
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#edit_prev').attr('src', e.target.result);
                $('#preview_img').hide();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>