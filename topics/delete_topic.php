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



// delete the entry

    $result = mysqli_query($con, "DELETE FROM file WHERE id=$id")

        or die(mysqli_error());



// redirect back to the view page

    header("Location: index.php");
} else {

// if id isn't set, or isn't valid, redirect back to view page

    header("Location: index.php");
}

?>