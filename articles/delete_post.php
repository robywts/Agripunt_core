<?php
/*

  delete_post.PHP

  Deletes a specific entry from the article, article_image, article_subject, article_company, article_topic tables

 */


//session check
include "../control.inc";

// connect to the database
include("../config.php");



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_POST['id']) && is_numeric($_POST['id'])) {

// get id value

    $id = $_POST['id'];
// delete the entry

    $result = mysqli_query($con, "DELETE FROM article WHERE id=$id");
    $result1 = mysqli_query($con, "DELETE FROM article_image WHERE article_ID=$id");
    $result2 = mysqli_query($con, "DELETE FROM article_subject WHERE article_ID=$id");
    $result3 = mysqli_query($con, "DELETE FROM article_company WHERE article_ID=$id");
    $result4 = mysqli_query($con, "DELETE FROM article_topic WHERE article_ID=$id")

        or die(mysqli_error());
    //unlinking company logo
    $dir = "../uploads/articles/$id";
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
} else {

// if id isn't set, or isn't valid, redirect back to view page

    header("Location: index.php");
}

?>