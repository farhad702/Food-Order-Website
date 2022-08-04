<?php
include ('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1> Add Food</h1>

        <br><br>

        <?php 

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description :</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price :</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td> Category :</td>
                    <td>
                        <select name ="category">
                            <?php 
                            // create php code to display categories from database

                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            
                            //execute the query

                            $res = mysqli_query($conn, $sql);

                            //count rows to check whether we have categories or not

                            $count = mysqli_num_rows($res);

                            // if count is greater than zer0, we have categories else we dont have caategories

                            if($count > 0)
                            {
                                //we have categories
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    // get the details of categories

                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //we dont have categoreis
                                ?>
                                <option value="0"> No Category Found</option>
                                <?php
                            }
                            //1. create sql to get all active categories from database
                            // 2.display on dropdown 
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured :</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active :</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        // check wheather the button is clicked or not
        if(isset($_POST['submit']))
        {
            // add the food in database
            //1. Get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            //check whether radio button for featured and active are checked or not

            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No"; // set the default value
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }

            // 2. upload the image if selected
            // check whether the select image is clicked or not and upload the image only if the image is selected

            if(isset($_FILES['image']['name']))
            {
                // get the details of the selected image

                $image_name = $_FILES['image']['name'];

                // check whether the image is selected or not and upload image only if selected

                if($image_name!="")
                {

                    // image is selected
                    //auto rename our image
                    //get the extension of our image(jpg,png,gif, etc) e.g-"food1-jpg"

                    $ext = end(explode('.', $image_name));

                    // rename the image or create new name for image

                    $image_name = "Food_Category_".rand(000,999).'.'.$ext; // e.g Food_Category_834.jpg
                
                    $source_path= $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/".$image_name;

                    //finally upload image

                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image is uploaded or not
                    // and if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload ==false)
                    {
                        //set message
                        $_SESSION['upload']="<div class='error'>Failed to upload image.</div>";

                        //redirect to add category page

                        header('location:'.SITEURL.'admin/add-food.php');

                        // stop the process

                        die();
                    }    
                }
            }
            else
            {
                $image_name = ""; // setting default value as blank
            }

            // 3. insert into database
            // For numerical we do not need to pass value insdie quotes '' But for string value
            // it is compulsory to add quotes ''
            $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ";

            // execute the query

            $res2 = mysqli_query($conn,$sql2);

            // check whether data is inserted or not 

            if (res2 == true)
            {
                // Data inserted successfully

                $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                // Failed to insert data

                $_SESSION['add'] = "<div class='error'>Failed to Added</div>";
                header('location:'.SITEURL.'admin/manage-food.php');

            }
        }
        ?>
            
    </div>

<?php
include ('partials/footer.php');
?>