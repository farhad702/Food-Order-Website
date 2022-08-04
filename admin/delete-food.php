<?php
include('../config/constants.php');

//check whether the id and image_name value is set or not

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //get the value and delete
    //echo "get the value and delete";

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file is available
    if($image_name != "") //if image name is not blank
    {
        //image is available. so remove it
        $path = "../images/food/".$image_name;

        //remove the image
        $remove = unlink($path);

        //if failed to remove image then add an error message and stop the process
        if ($remove ==false)
        {
            //set the session message

            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
            //redirect to manage category page

            header('location:'.SITEURL.'admin/manage-food.php');
            // stop the process
            die();
        }
    }

    //delete data from database

    //sql query to delete data from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //execute the query

    $res = mysqli_query($conn,$sql);

    //check whether the data is delete from database or not

    if($res==true)
    {
        //set success message and redirect

        $_SESSION['delete']="<div class='success'>Food Category Deleted successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //set fail message and redirect
        $_SESSION['delete']="<div class='error'>Failed to Delete Food Category.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

    //redirect to manage category page with message

}
else
{
    // redirect to manage-category page
    $_SESSION['unauthorize']= "<div class='error'> Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>
