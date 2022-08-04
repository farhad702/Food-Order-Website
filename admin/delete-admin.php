<?php

    @include('../config/constants.php');
    // get the id of admin to be deleted
    $id = $_GET['id'];

    // create sql query to delete admin

    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //excute the query

    $res = mysqli_query($conn, $sql);

    //check whether the query executed successfull or not

    if($res==true){
        //query executed successfully and admin delete

        //echo " admin deleted";
        //create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');


    } else 
    {
        //failed to delete
        //echo "failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try again Later.</div>";
        header('location'.SITEURL.'admin/manage-admin.php'); 
    }
    

?>