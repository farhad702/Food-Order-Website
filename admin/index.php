<?php
@include('partials/menu.php');

?>
      <!----------- Main Content Section Start --------------->
    <div class="main-content">
        <div class="wrapper">
            <h1> DASHBOARD </h1>
            <br><br>
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
            ?>
            <br><br>
            <div class="col-4 text-center">

            <?php
                // sql query
                $sql = "SELECT * FROM tbl_category";

                //EXECUTE QUERY

                $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                // count the rows

                $count = mysqli_num_rows($res);

                ?>

                <h1><?php echo $count;?></h1>

                <br />

                Categories
            </div>

            <div class="col-4 text-center">

            <?php
                // sql query
                $sql2 = "SELECT * FROM tbl_food";

                //EXECUTE QUERY

                $res2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));

                // count the rows

                $count2 = mysqli_num_rows($res2);

                ?>
                <h1><?php echo $count2;?></h1>
                <br />
                Foods
            </div>

            <div class="col-4 text-center">

            <?php
                // sql query
                $sql3 = "SELECT * FROM tbl_order";

                //EXECUTE QUERY

                $res3 = mysqli_query($conn,$sql3) or die(mysqli_error($conn));

                // count the rows

                $count3 = mysqli_num_rows($res3);

                ?>
                <h1><?php echo $count3;?></h1>
                <br />
                
                Total Orders
            </div>

            <div class="col-4 text-center">

            <?php

                // Create sql query to get total revenue generated
                // aggregate function in sql

                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                // Execute the query

                $res4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));

                // Get the values

                $row4= mysqli_fetch_assoc($res4);

                // Get the total REVENUE

                $total_revenue = $row4['Total'];
            ?>

                <h1> $ <?php echo $total_revenue;?></h1>
                <br />
                Revenue Generated
            </div>

            <div class="clearfix"></div>

        </div>
    </div>
    <!----------- Main Content Section end --------------->


<?php

@include('partials/footer.php');

?>