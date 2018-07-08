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

        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['status'])) {
// get form data, making sure it is valid

            $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['name']));

            $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));

            $status = mysqli_real_escape_string($con, htmlspecialchars($_POST['status']));

            $password = password_hash($_POST['name'], PASSWORD_DEFAULT);

            $select = mysqli_query($con, "SELECT `email` FROM `users` WHERE `email` = '" . $email . "'") or exit(mysql_error());
            if ($name == '' || $email == '' || $status == '') {

                $error = 'ERROR: Please fill in all required fields!';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $error = 'ERROR: Please enter a valid email.';
            } else if ($select && mysqli_num_rows($select) != 0) {
                $error = 'ERROR: Email Id already exist. Please use another email.';
            } else {

                //mail start
                require_once "../vendor/autoload.php";
                require ('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
                require ('../vendor/phpmailer/phpmailer/src/SMTP.php');
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/demo/adminTest";
                $mail = new \PHPMailer\PHPMailer\PHPMailer();
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
//Enable SMTP debugging. 
                $mail->CharSet = 'utf-8';
                $mail->SMTPDebug = 0;
//Set PHPMailer to use SMTP.
                $mail->isSMTP();
//Set SMTP host name                          
                $mail->Host = 'mail.agripunt.com';
                $mail->Mailer = "smtp";
//Set this to true if SMTP host requires authentication to send email
                $mail->SMTPAuth = true;
//Provide username and password     
                $mail->Username = "agripunt15";
                $mail->Password = "DCT1lbRM8#";
//If SMTP requires TLS encryption then set it
                $mail->SMTPSecure = "tls";
//Set TCP port to connect to 
                $mail->Port = 587;

                $mail->From = "admin@agripunt.com";
                $mail->FromName = "Agripunt";

                $mail->addAddress($email, $name);

                $mail->isHTML(true);

                $mail->Subject = "Welcome to Agripunt";
                $mail->Body = "Please use the below credentials to sign-in to Agripunt.<br>Site Url: " . $actual_link . "<br><br><i>Email Address: " . $email . " and Password: " . $name . "</i>";
                $mail->AltBody = "Please contact Agripunt admin.";

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    // echo "Message has been sent successfully";
                }//exit;
                //mail end

                mysqli_query($con, "INSERT users SET name='$name', email='$email', status='$status', type='2', password='$password', image_url=''")

                    or die(mysqli_error($con));
// once saved, redirect back to the view page
                echo '<script type="text/javascript">';
                echo 'window.location.href="index.php";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=index.php" />';
                echo '</noscript>';
//                header("Location: index.php");
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
                                    <a href="index.php">Manage Users</a>
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


                                <form id="userAdd" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="form-group">
                                        <label class="field-title">Name of User *</label>
                                        <input type="text" id="name" name="name" placeholder="Name of User" class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Email ID *</label>
                                        <input type="text" id="email" name="email" placeholder="Email"  class="common-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="field-title">Status *</label>
                                        <!--<input type="text" placeholder="Status"  class="common-input" disabled>-->
                                        <select id="status" placeholder="Status" name="status" class="common-input">
                                            <option value="">Select Status</option>
                                            <option value="1" > Active</option>
                                            <option value="0" >Inactive</option>
                                        </select>
                                    </div>
                                    <div class="button-group">

                                        <button class="btn btn-primary btn-block inlline-block" onclick="return validate()" id="addArticle" name="submit"  value="Submit"><span>Invite</span></button>
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

<script type="text/javascript">
    function validate() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var status = document.getElementById('status').value;

        if (!name || !email || !status) {
            alert('Please fill in all required fields!');
            return false;
        } else {
            return true;
        }
    }
</script>