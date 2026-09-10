<?php
session_start();
include("center_header.php");
include("connection.php");


if(isset($_REQUEST["cbid"]))
{
    $bid = $_REQUEST["cbid"];
    $query = "update service_booking_info set  book_status = '1' where book_id = '$bid'";
    if(mysqli_query($con,$query))
    {
        echo "<script>";
        echo "alert('Booking Confirm Successful');";
        echo "window.location.href='center_view_new_booking.php'";
        echo "</script>";
    }
    else
    {
        echo "Error In Confirmation: ".mysqli_error($con);
    }
}

if(isset($_REQUEST["ncbid"]))
{
    $bid = $_REQUEST["ncbid"];
    $query = "update service_booking_info set  book_status = '2' where book_id = '$bid'";
    if(mysqli_query($con,$query))
    {
        echo "<script>";
        echo "alert('Booking Not Confirm Successful');";
        echo "window.location.href='center_view_new_booking.php'";
        echo "</script>";
    }
    else
    {
        echo "Error In Confirmation: ".mysqli_error($con);
    }
}


?>

<main class="tf-portal-page">

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h1>VIEW NEW SERVICE BOOKING </h1>
            </div>
        </div>

        <div class="row mt-5">
            
           
            <div class="col-md-12 mt-4">
                <?php 
                $centerid = $_SESSION["center_id"];
               $qur = mysqli_query($con,"select * from service_booking_info where center_id='$centerid' and book_status='0'");
               if(mysqli_num_rows($qur)> 0)
                {
                    echo"<div class='tf-table-wrap'><table class='tf-data-table'>
                            <tr>
                                <th>BOOKING ID</th>
                                <th>BOOKING NAME</th>
                                <th>SERVICE DATE</th>
                                <th>SERVICE TYPE</th>
                                <th>CUSTOMER NAME</th>
                                <th>CUSTOMER MOBILE NO</th>
                                <th>PROBLEM DESCRIPTION</th>
                                <th>PRICE</th>
                                <th>CONFIRM</th>
                                <th>NOT CONFIRM</th>


                            </tr>";
                    while($q1=mysqli_fetch_array($qur))
                    {
                        echo "<tr>";
                        echo "<td>$q1[0]</td>";
                        echo "<td>$q1[1]</td>";
                        echo "<td>$q1[2]</td>";
                       // echo "<td>$q1[3]</td>";
                        $qur2 = mysqli_query($con,"select * from type_info where type_id='$q1[3]'");
                        $q2=mysqli_fetch_array($qur2);
                        echo "<td>$q2[1]</td>";

                        //echo "<td>$q1[4]</td>";

                         $qur3 = mysqli_query($con,"select * from cust_regis where cust_id='$q1[5]'");
                        $q3=mysqli_fetch_array($qur3);
                        echo "<td>$q3[1]</td>";
                        echo "<td>$q3[4]</td>";
                        echo "<td>$q1[6]</td>";
                        echo "<td>&#8377 $q1[7] /-</td>";
                        echo "<td><a href='center_view_new_booking.php?cbid=$q1[0]' class='btn btn-success'>CONFIRM</a></td>";
                        echo "<td><a href='center_view_new_booking.php?ncbid=$q1[0]' class='btn btn-danger'>NOT CONFIRM</a></td>";
                        
                        echo "</tr>";
                    }
                    echo"</table></div>";
                }
                else{
                    echo"<h2>No New Bookings</h2>";
                }
               ?>

            </div>
        </div>
    </div>
</main>

<?php
include("footer.php")
?>
