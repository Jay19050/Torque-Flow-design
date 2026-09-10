<?php
session_start();
include("cust_header.php");
include("connection.php");

$tid = $_REQUEST["tid"];
$res1 = mysqli_query($con,"select * from type_info where type_id = '$tid'");
$r1= mysqli_fetch_array($res1);
$stype1 = $r1[1];
$desc1 = $r1[2];
$price1 = $r1[3];
$img1 = $r1[4];

?>
<script>
function validation() {


    if (form1.selcenter.value == "0") {
        alert("Please Select A Center");
        form1.selcenter.focus();
        return false;
    }


    if (form1.txtdesc.value == "") {
        alert("Please Enter Car Problem");
        form1.txtdesc.focus();
        return false;
    }

    return true;
}
</script>

<?php 
if(isset($_POST["btnbook"]))
{
    $centerid = $_POST["selcenter"];
    $sdate = date("Y-m-d",strtotime($_POST["seldate"]));
    $desc = $_POST["txtdesc"];
    $bdate = date("Y-m-d");
    $custid = $_SESSION["custid"];

     $res2 = mysqli_query($con,"select max(book_id) from service_booking_info");
        $bid=0;
        while($r2=mysqli_fetch_array($res2))
        {
            $bid = $r2[0];

        }   
        $bid++; 

        $query= "insert into service_booking_info values ('$bid','$bdate','$sdate','$tid','$centerid','$custid','$desc','$price1','0')";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Booked Successfully');";
            echo "window.location.href='cust_view_service_booking_status.php'";
            echo "</script>";
        }
        else{
            echo "Error in Service Booking: ".mysqli_error($con);
        }
}
?>
<main class="tf-portal-page"><div class="tf-portal-shell"><p class="tf-page-eyebrow">01 / SERVICE BOOKING</p><header class="tf-page-heading"><h1>BOOK<br><span>SERVICE.</span></h1><p>Tell us what your vehicle needs and select the most convenient service center.</p></header><section class="tf-booking-layout"><div class="tf-booking-visual"><img src="<?php echo $img1; ?>" alt="<?php echo htmlspecialchars($stype1); ?>"></div><div class="tf-booking-form">
                <form method="post" name="form1">

                    <span class="tf-detail-label">SERVICE TYPE</span><h2 class="tf-detail-value"><?php echo $stype1; ?></h2>

                    <span class="tf-detail-label">DESCRIPTION</span><p class="tf-detail-copy"><?php echo $desc1; ?></p><span class="tf-detail-label">PRICE</span><p class="tf-detail-value">₹ <?php echo $price1; ?>/-</p>
                    <div><label class="tf-field-label">SELECT NEAREST SERVICE CENTER</label>
                        <select class="form-control" name="selcenter">
                            <option value="0">Select Service Center </option>
                            <?php 
                                $res2 = mysqli_query($con,"select * from service_center_info");
                                while($r2=mysqli_fetch_array($res2))
                                {
                                ?>
                            <option value="<?php echo $r2[0]; ?>"><?php echo $r2[3] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div><label class="tf-field-label">ENTER CAR PROBLEM</label>
                        <textarea class="form-control" name="txtdesc"></textarea>
                    </div>

                    <div><label class="tf-field-label">ENTER BOOKING DATE</label>
                        <input type="Date" class="form-control" name="seldate" value="<?php echo date("Y-m-d"); ?>"
                            min="<?php echo date("Y-m-d",strtotime("+1 Days"))?>">
                    </div>


                    <button type="submit" class="tf-action" name="btnbook" onclick="return validation();">BOOK YOUR SERVICE <b>↗</b></button>
                </form>


            </div></section></div></main>
<?php
include("footer.php")    
?>
