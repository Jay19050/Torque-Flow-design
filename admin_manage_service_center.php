<?php
include("admin_header.php");
include("connection.php");
?>

<link rel="stylesheet" href="css/admin_manage_service_center.css">
<script>
function validation() {
    var form1 = document.getElementById("form1");

    var v = /^[a-zA-Z ]{2,50}$/;

    if (form1.txtname.value == "") {
        alert("Please Enter Service Center Name");
        form1.txtname.focus();
        return false;
    } else {
        if (!v.test(form1.txtname.value)) {
            alert("Please Enter Only Alphabets in Service Center Name");
            form1.txtname.focus();
            return false;
        }
    }


    if (form1.txtadd.value == "") {
        alert("Please Enter Service Center Address");
        form1.txtadd.focus();
        return false;
    }


    if (form1.txtcity.value == "") {
        alert("Please Enter Service Center City Name");
        form1.txtcity.focus();
        return false;
    } else {
        if (!v.test(form1.txtcity.value)) {
            alert("Please Enter Only Alphabets in Service Center City Name");
            form1.txtcity.focus();
            return false;
        }
    }


    var v = /^[0-9]{10}$/;

    if (form1.txtmno.value == "") {
        alert("Please Enter Service Center Mobile No");
        form1.txtmno.focus();
        return false;
    } else if (form1.txtmno.value.length != 10) {
        alert("Please Enter Service Center Mobile No 10 Digit Long");
        form1.txtmno.focus();
        return false;
    } else {
        if (!v.test(form1.txtmno.value)) {
            alert("Please Enter Only Digits in Service Center Mobile No");
            form1.txtmno.focus();
            return false;
        }
    }


    var v = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/;

    if (form1.txtemail.value == "") {
        alert("Please Enter Service Center Email ID");
        form1.txtemail.focus();
        return false;
    } else {
        if (!v.test(form1.txtemail.value)) {
            alert("Please Enter Valid Email ID");
            form1.txtemail.focus();
            return false;
        }
    }


    if (form1.txtpwd.value == "") {
        alert("Please Enter Service Center Password");
        form1.txtpwd.focus();
        return false;
    } else if (form1.txtpwd.value.length < 6) {
        alert("Please Enter Service Center Password More Than 6 Characters");
        form1.txtpwd.focus();
        return false;
    } else if (form1.txtpwd.value.length > 10) {
        alert("Please Enter Service Center Password Less Than 10 Characters");
        form1.txtpwd.focus();
        return false;
    }

    return true;
}
</script>
<?php
if(isset($_POST["btnsave"]))
{
    $name = $_POST["txtname"];
    $add = $_POST["txtadd"];
    $city = $_POST["txtcity"];
    $mno = $_POST["txtmno"];
    $email = $_POST["txtemail"];
    $pwd = $_POST["txtpwd"];

    $res = mysqli_query($con,"select * from service_center_info where email_id='$email'");

    if(mysqli_num_rows($res)>0)
    {
        echo "<script>";
        echo "alert('Email Id already exists');";
        echo "</script>";
    }
    else{
        $res2 = mysqli_query($con,"select max(center_id) from service_center_info");
        $cid=0;
        while($r2=mysqli_fetch_array($res2))
        {
            $cid = $r2[0];

        }   
        $cid++; 

        $query= "insert into service_center_info values ('$cid','$name','$add','$city','$mno','$email','$pwd')";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Center Saved Successfully');";
            echo "window.location.href='admin_manage_service_center.php'";
            echo "</script>";
        }
        else{
            echo "Error in Insertion: ".mysqli_error($con);
        }
    }
}


 if(isset($_REQUEST["scdid"]))
    {
        $cid1= $_REQUEST["scdid"];
        $query = "delete from service_center_info where center_id='$cid1'";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Center Deleted Successfully');";
            echo "window.location.href='admin_manage_service_center.php'";
            echo "</script>";
        }
        else{
            echo "Error in Deletion: ".mysqli_error($con);
        }
    }

     if(isset($_REQUEST["sceid"]))
    {
        $cid1= $_REQUEST["sceid"];
        $res3=mysqli_query($con,"select * from service_center_info where center_id='$cid1'");
        $r3=mysqli_fetch_array($res3);
    }

    if(isset($_POST["btnupdate"]))
{
    $name = $_POST["txtname"];
    $add = $_POST["txtadd"];
    $city = $_POST["txtcity"];
    $mno = $_POST["txtmno"];
    $email = $_POST["txtemail"];
    $pwd = $_POST["txtpwd"];
    $cid1= $_REQUEST["sceid"];

    $res = mysqli_query($con,"select * from service_center_info where email_id='$email'");

        $query= "update service_center_info set center_name='$name',address='$add',city='$city',mobile_no='$mno',email_id='$email',pwd='$pwd' where center_id='$cid1'";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Center Updated Successfully');";
            echo "window.location.href='admin_manage_service_center.php'";
            echo "</script>";
        }
        else{
            echo "Error in Updation: ".mysqli_error($con);
        }
    
}
?>


<main class="tf-center-page">

    <div class="tf-center-shell">

        <header class="tf-center-page-intro">
            <div class="tf-center-page-number">02 / NETWORK MANAGEMENT</div>

            <div class="tf-center-intro-grid">
                <h1>MANAGE<br><span>SERVICE CENTER</span></h1>

                <div class="tf-center-intro-copy">
                    <span>TORQUE FLOW / ADMIN</span>
                    <p>Define and maintain the service centers that support the Torque Flow network.</p>
                </div>
            </div>
        </header>

        <section class="tf-center-workspace" aria-label="Service center management">

            <div class="tf-center-form-panel">
                <div class="tf-center-panel-heading">
                    <div>
                        <span class="tf-center-panel-index">01</span>
                        <div>
                            <span class="tf-center-panel-kicker">SERVICE CENTER</span>
                            <h2><?php echo isset($_REQUEST["sceid"]) ? 'EDIT SERVICE CENTER' : 'ADD SERVICE CENTER'; ?></h2>
                        </div>
                    </div>
                    <span class="tf-center-panel-status"><?php echo isset($_REQUEST["sceid"]) ? 'UPDATE MODE' : 'NEW ENTRY'; ?></span>
                </div>

                <div class="tf-center-rule"></div>

                <form method="post" id="form1" name="form1" class="tf-center-form">
                    <div class="tf-center-form-grid">

                        <div class="tf-center-field">
                            <label for="txtname">CENTER NAME</label>
                            <input type="text" id="txtname" name="txtname" value="<?php echo $r3[1]; ?>" autocomplete="organization">
                        </div>

                        <div class="tf-center-field tf-center-field-address">
                            <label for="txtadd">ADDRESS</label>
                            <textarea id="txtadd" name="txtadd" autocomplete="street-address"><?php echo $r3[2]; ?></textarea>
                        </div>

                        <div class="tf-center-field">
                            <label for="txtcity">CITY</label>
                            <input type="text" id="txtcity" name="txtcity" value="<?php echo $r3[3]; ?>" autocomplete="address-level2">
                        </div>

                        <div class="tf-center-field">
                            <label for="txtmno">MOBILE NO</label>
                            <input type="text" id="txtmno" name="txtmno" value="<?php echo $r3[4]; ?>" inputmode="numeric" autocomplete="tel">
                        </div>

                        <div class="tf-center-field">
                            <label for="txtemail">EMAIL</label>
                            <input type="email" id="txtemail" name="txtemail" value="<?php echo $r3[5]; ?>" autocomplete="email">
                        </div>

                        <div class="tf-center-field">
                            <label for="txtpwd">PASSWORD</label>
                            <input type="password" id="txtpwd" name="txtpwd" value="<?php echo $r3[6]; ?>" autocomplete="new-password">
                        </div>

                    </div>

                    <div class="tf-center-form-actions">
                        <?php
                                if(isset($_REQUEST["sceid"]))
                                {
                            ?>
                        <button type="submit" class="tf-center-submit" name="btnupdate" onclick="return validation()">
                            <span>UPDATE CENTER</span><b>↗</b>
                        </button>
                        <?php
                                }
                                else
                                {
                            ?>
                        <button type="submit" class="tf-center-submit" name="btnsave" onclick="return validation()">
                            <span>SAVE CENTER</span><b>↗</b>
                        </button>
                        <?php
                                }

                            ?>
                    </div>
                </form>
            </div>

            <section class="tf-center-database-panel" aria-label="Service center database">
                <div class="tf-center-panel-heading tf-center-database-heading">
                    <div>
                        <span class="tf-center-panel-index">02</span>
                        <div>
                            <span class="tf-center-panel-kicker">NETWORK DIRECTORY</span>
                            <h2>SERVICE CENTER DATABASE</h2>
                        </div>
                    </div>
                    <span class="tf-center-panel-status">LIVE DIRECTORY</span>
                </div>

                <div class="tf-center-rule"></div>

                <div class="tf-center-table-wrap">
                <?php 
               $qur = mysqli_query($con,"select * from service_center_info");
               if(mysqli_num_rows($qur)> 0)
                {
                    echo"<table class='tf-center-table'>
                            <tr>
                                <th>CENTER ID</th>
                                <th>CENTER NAME</th>
                                <th>ADDRESS</th>
                                <th>CITY</th>
                                <th>MOBILE NO</th>
                                <th>EMAIL ID</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>";
                    while($q1=mysqli_fetch_array($qur))
                    {
                        echo "<tr>";
                        echo "<td>$q1[0]</td>";
                        echo "<td>$q1[1]</td>";
                        echo "<td>$q1[2]</td>";
                        echo "<td>$q1[3]</td>";
                        echo "<td>$q1[4]</td>";
                        echo "<td>$q1[5]</td>";
                        echo "<td><a class='tf-center-action tf-center-action--edit' href='admin_manage_service_center.php?sceid=$q1[0]'>EDIT</a></td>";
                        echo "<td><a class='tf-center-action tf-center-action--delete' href='admin_manage_service_center.php?scdid=$q1[0]'>DELETE</a></td>";
                           
                        echo "</tr>";
                    }
                    echo"</table>";
                }
                else{
                    echo"<h2>No Service Center Found</h2>";
                }
               ?>
                </div>
            </section>

        </section>

    </div>
</main>

<?php
include("admin_footer.php")
?>
