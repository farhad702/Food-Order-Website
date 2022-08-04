<?php
@include('../config/constants.php');
?>
<html>
    <head>
        <title> Login - Food Order System </title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br> <br>
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br> <br>
            <!-------login form start here------>

            <form action="" method="POST" class="text-center">
                Username : <br>

                <input type="text" name="username" placeholder="Enter Username"><br><br>
                Password : <br>

                <input type="password" name="password" placeholder="Enter Password"><br><br>
                <input type="submit" name="submit" value="login" class="btn-primary">
                <br><br>
            </form>
        
            <!-------login form end here------>
            <p>Created By - <a href="">Farhad Noor </a></p>
        </div>

    </body>
</html>

<?php


if(isset($_POST['submit']))
{
    //1.get the data from login form
     // mysqli_real_escape_string , we are using to save from SQL INJECTION. So that hacker cant hack by
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    //2. sql to check whether the user with username and password exist or not

    $sql = "SELECT * FROM tbl_admin WHERE username ='$username' AND password='$password'";

    // 3.execute the query
    $res=mysqli_query($conn, $sql);

    //4. count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        // user available and login success

        $_SESSION['login']="<div class='success'>Login Successfully. </div>";
        $_SESSION['user']=$username; //to check wheather the user login or not and logout will unset it.

        //redirect to home page/dashboard

        header('location:'.SITEURL.'admin/');
    }
    else 
    {
        // user not available and login fail

        $_SESSION['login']="<div class='error text-center'>Login and Password not Match. </div>";

        //redirect to home page/dashboard

        header('location:'.SITEURL.'admin/login.php');
    }
};

?>