<?php
/*

  DELETE.PHP

  Deletes a specific entry from the 'users' table

 */


//session check
include "../control.inc";

// connect to the database
include("../config.php");



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

// get id value

    $id = $_GET['id'];



// delete the entry

    $result = mysqli_query($con, "DELETE FROM users WHERE id=$id")

        or die(mysqli_error());



// redirect back to the view page

    header("Location: manage_users.php");
} else {

// if id isn't set, or isn't valid, redirect back to view page

    header("Location: manage_users.php");
}

?>