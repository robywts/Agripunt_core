<?php
/*

  delete_categories.PHP

  Deletes a specific entry from the 'subject' table

 */


//session check
include "../control.inc";

// connect to the database
include("../config.php");



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_POST['id']) && is_numeric($_POST['id'])) {

// get id value

    $id = $_POST['id'];

    //Checking article associated with company
    $sqll = "SELECT COUNT(*) FROM article_company where company_ID=$id";
    $result = mysqli_query($con, $sqll);
    $r = mysqli_fetch_row($result);
    $numrows = $r[0];
    if ($numrows > 0) {
// generate error message
//        $error = 'ERROR: One or more article associated with this company, Please delete article first.!';
        echo "<script type='text/javascript'>alert('One or more article associated with this company, Please delete article first.!'); location.href='index.php' </script>";
//        session_start();
//        $_SESSION['err_message'] = $error;
       // header("Location: index.php");
    } else {
// delete the entry

        $result = mysqli_query($con, "DELETE FROM company WHERE id=$id")

            or die(mysqli_error());
        //unlinking company logo
        $dir = "../uploads/companies/$id";
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }


// redirect back to the view page

        header("Location: index.php");
    }
} else {

// if id isn't set, or isn't valid, redirect back to view page

    header("Location: index.php");
}

?>