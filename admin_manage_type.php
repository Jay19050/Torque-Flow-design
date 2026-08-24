<?php
include("admin_header.php");
include("connection.php");
?>

<script>
function validation() {
    var form1 = document.getElementById("form1");

    var v = /^[a-zA-Z ]{2,50}$/;

    if (form1.txttype.value == "") {
        alert("Please Enter Service Type");
        form1.txttype.focus();
        return false;
    } else {
        if (!v.test(form1.txttype.value)) {
            alert("Please Enter Only Alphabets in Service Type");
            form1.txttype.focus();
            return false;
        }
    }

    if (form1.txtdesc.value == "") {
        alert("Please Enter Description");
        form1.txtdesc.focus();
        return false;
    }

    var v = /^[0-9]+$/;

    if (form1.txtprice.value == "") {
        alert("Please Enter Price");
        form1.txtprice.focus();
        return false;
    } else {
        if (!v.test(form1.txtprice.value)) {
            alert("Please Enter Only Digits in Price");
            form1.txtprice.focus();
            return false;
        }
    }

    return true;
}
</script>
<?php
if(isset($_POST["btnsave"]))
{
    $type = $_POST["txttype"];
    $desc = $_POST["txtdesc"];
    $price = $_POST["txtprice"];
    
   
        $res2 = mysqli_query($con,"select max(type_id) from type_info");
        $tid=0;
        while($r2=mysqli_fetch_array($res2))
        {
            $tid = $r2[0];

        }   
        $tid++; 

        $query= "insert into type_info values ('$tid','$type','$desc','$price')";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Type Saved Successfully');";
            echo "window.location.href='admin_manage_type'";
            echo "</script>";
        }
        else{
            echo "Error in Insertion: ".mysqli_error($con);
        }
    }

    
    if(isset($_REQUEST["tdid"]))
    {
        $tid1= $_REQUEST["tdid"];
        $query = "delete from type_info where type_id='$tid1'";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Service Type Deleted Successfully');";
            echo "window.location.href='admin_manage_type'";
            echo "</script>";
        }
        else{
            echo "Error in Deletion: ".mysqli_error($con);
        }
    }

     if(isset($_REQUEST["teid"]))
    {
        $tid1= $_REQUEST["teid"];
        $res3=mysqli_query($con,"select * from type_info where type_id='$tid1'");
        $r3=mysqli_fetch_array($res3);
    }
    
if(isset($_POST["btnupdate"]))
    {
    $type = $_POST["txttype"];
    $desc = $_POST["txtdesc"];
    $price = $_POST["txtprice"];
    $tid = $_REQUEST["teid"];
    

        $query= "update type_info set service_type='$type',Description='$desc',Price='$price' where type_id='$tid'";
        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Category Updated Successfully');";
            echo "window.location.href='admin_manage_type'";
            echo "</script>";
        }
        else{
            echo "Error in Updation: ".mysqli_error($con);
        }
    }

?>


<main>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h1>Manage Service Type</h1>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-7">
                <?php 
               $qur = mysqli_query($con,"select * from type_info");
               if(mysqli_num_rows($qur)> 0)
                {
                    echo"<table class='table table-bordered table-hover'>
                            <tr>
                                <th>TYPE ID</th>
                                <th>SERVICE TYPE</th>
                                <th>DESCRIPTION</th>
                                <th>PRICE</th>
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
                        echo "<td><a href='admin_manage_type.php?teid=$q1[0]'>EDIT</a></td>";
                        echo "<td><a href='admin_manage_type.php?tdid=$q1[0]'>DELETE</a></td>";
                           
                        echo "</tr>";
                    }
                    echo"</table>";
                }
                else{
                    echo"<h2>No Service Type Found</h2>";
                }
               ?>

            </div>
            <div class="col-md-5">
                <form method="post" id="form1" name="form1">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Enter Service Type</label>
                        <input type="text" class="form-control" name="txttype" value="<?php echo $r3[1]; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Enter Description</label>
                        <textarea class="form-control"
                            name="txtdesc"><?php echo isset($r3[2]) ? $r3[2] : ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Enter Price</label>
                        <input type="text" class="form-control" name="txtprice" value="<?php echo  $r3[3]; ?>">
                    </div>

                    <?php
                        if(isset($_REQUEST["teid"]))
                        {
                    ?>
                    <button type="submit" class="btn btn-primary" name="btnupdate"
                        onclick="return validation()">UPDATE</button>
                    <?php
                        }
                        else
                        {
                    ?>
                    <button type="submit" class="btn btn-primary" name="btnsave"
                        onclick="return validation()">SAVE</button>
                    <?php
                        }

                    ?>

                </form>


            </div>
        </div>
    </div>
</main>

<?php
include("footer.php")
?>