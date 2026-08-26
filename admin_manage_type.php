<?php
include("admin_header.php");
include("connection.php");
?>

<link rel="stylesheet" href="css/admin_manage_type.css">

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


    var filename = document.getElementById("txtimg").value;
    var ext = filename.substr(filename.lastIndexOf(".") + 1).toLowerCase().trim();

    if (document.getElementById("txtimg").value == "") {
        alert("Please Select Image");
        return false;
    } else {
        if (!(ext == "png" || ext == "jpg" || ext == "jpeg" || ext == "webp")) {
            alert("Please Select Proper Image File");
            return false;
        }
    }

    return true;
}

function update_validation() {
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


    var filename = document.getElementById("txtimg").value;
    var ext = filename.substr(filename.lastIndexOf(".") + 1).toLowerCase().trim();

    if (document.getElementById("txtimg").value != "") {

        if (!(ext == "png" || ext == "jpg" || ext == "jpeg" || ext == "webp")) {
            alert("Please Select Proper Image File");
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
    
    $tpath = $_FILES["txtimg"]["tmp_name"];
    $fpath = "type_img/ST".time().".png";
   
        $res2 = mysqli_query($con,"select max(type_id) from type_info");
        $tid=0;
        while($r2=mysqli_fetch_array($res2))
        {
            $tid = $r2[0];

        }   
        $tid++; 

        $query= "insert into type_info values ('$tid','$type','$desc','$price','$fpath')";
        if(mysqli_query($con,$query))
        {
            move_uploaded_file($tpath,$fpath);
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
            echo "window.location.href='admin_manage_type.php'";
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

    if($_FILES["txtimg"]["size"] > 0)
    {
        $tpath = $_FILES["txtimg"]["tmp_name"];
        $fpath = "type_img/ST".time().".png";
         move_uploaded_file($tpath,$fpath);

        $query= "update type_info set service_type='$type',Description='$desc',Price='$price',type_img='$fpath' where type_id='$tid'";
    }
    else{
        $query= "update type_info set service_type='$type',Description='$desc',Price='$price' where type_id='$tid'";
    }
    

        
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


<main class="tf-admin-page">

    <section class="tf-page-intro">
        <div class="tf-page-number">01 / SERVICE MANAGEMENT</div>
        <div class="tf-intro-grid">
            <div>
                <h1>SERVICE<br><span>TYPES.</span></h1>
            </div>
            <div class="tf-intro-copy">
                <span class="tf-kicker">TORQUE FLOW / ADMIN</span>
                <p>Define and maintain the services available across the Torque Flow network.</p>
            </div>
        </div>
    </section>

    <section class="tf-service-workspace">

        <div class="tf-form-panel">
            <div class="tf-panel-heading">
                <div>
                    <span class="tf-panel-index">01</span>
                    <h2><?php echo isset($_REQUEST["teid"]) ? 'EDIT SERVICE' : 'ADD SERVICE'; ?></h2>
                </div>
                <span class="tf-panel-status"><?php echo isset($_REQUEST["teid"]) ? 'UPDATE MODE' : 'NEW ENTRY'; ?></span>
            </div>

            <div class="tf-rule"></div>

            <form method="post" id="form1" name="form1" enctype="multipart/form-data" class="tf-service-form">

                <div class="tf-field">
                    <label for="txttype">SERVICE TYPE</label>
                    <input type="text" id="txttype" name="txttype"
                        value="<?php echo isset($r3[1]) ? $r3[1] : ''; ?>"
                        placeholder="Enter service type"
                        autocomplete="off">
                    <span class="tf-field-line"></span>
                </div>

                <div class="tf-field tf-field-textarea">
                    <label for="txtdesc">DESCRIPTION</label>
                    <textarea id="txtdesc" name="txtdesc"
                        placeholder="Describe the service..."><?php echo isset($r3[2]) ? $r3[2] : ''; ?></textarea>
                    <span class="tf-field-line"></span>
                </div>

                <div class="tf-field tf-price-field">
                    <label for="txtprice">SERVICE PRICE</label>
                    <div class="tf-price-wrap">
                        <span class="tf-currency">₹</span>
                        <input type="text" id="txtprice" name="txtprice"
                            value="<?php echo isset($r3[3]) ? $r3[3] : ''; ?>"
                            placeholder="0"
                            inputmode="numeric"
                            autocomplete="off">
                    </div>
                    <span class="tf-field-line"></span>
                </div>

                <div class="tf-upload-field">
                    <div class="tf-upload-label">
                        <label for="txtimg">SERVICE IMAGE</label>
                        <span>JPG / PNG / WEBP</span>
                    </div>

                    <?php if(isset($_REQUEST["teid"])) { ?>
                        <div class="tf-current-image">
                            <div class="tf-image-frame">
                                <img src="<?php echo $r3[4]; ?>" alt="Current service image">
                            </div>
                            <div class="tf-image-meta">
                                <span>CURRENT IMAGE</span>
                                <strong>REPLACE IF REQUIRED</strong>
                            </div>
                        </div>
                    <?php } ?>

                    <label class="tf-upload-zone" for="txtimg">
                        <input type="file" name="txtimg" id="txtimg" accept=".png,.jpg,.jpeg,.webp">
                        <span class="tf-upload-plus">+</span>
                        <span class="tf-upload-title"><?php echo isset($_REQUEST["teid"]) ? 'REPLACE IMAGE' : 'UPLOAD IMAGE'; ?></span>
                        <span class="tf-upload-file" id="tf-file-name">NO FILE SELECTED</span>
                    </label>
                </div>

                <div class="tf-form-actions">
                    <?php if(isset($_REQUEST["teid"])) { ?>
                        <button type="submit" class="tf-primary-action" name="btnupdate"
                            onclick="return update_validation()">
                            <span>UPDATE SERVICE</span><b>↗</b>
                        </button>
                        <a href="admin_manage_type.php" class="tf-secondary-action">CANCEL</a>
                    <?php } else { ?>
                        <button type="submit" class="tf-primary-action" name="btnsave"
                            onclick="return validation()">
                            <span>SAVE SERVICE</span><b>↗</b>
                        </button>
                    <?php } ?>
                </div>

            </form>
        </div>

        <div class="tf-list-panel">
            <div class="tf-panel-heading tf-list-heading">
                <div>
                    <span class="tf-panel-index">02</span>
                    <h2>SERVICE DATABASE</h2>
                </div>
                <?php
                    $service_count_query = mysqli_query($con,"select * from type_info");
                    $service_count = mysqli_num_rows($service_count_query);
                ?>
                <span class="tf-entry-count"><?php echo str_pad($service_count, 2, "0", STR_PAD_LEFT); ?> ENTRIES</span>
            </div>

            <div class="tf-rule"></div>

            <div class="tf-service-list">
                <?php
                $qur = mysqli_query($con,"select * from type_info");
                if(mysqli_num_rows($qur)> 0)
                {
                    $row_number = 1;
                    while($q1=mysqli_fetch_array($qur))
                    {
                ?>
                    <article class="tf-service-row">
                        <div class="tf-service-image">
                            <img src="<?php echo $q1[4]; ?>" alt="<?php echo htmlspecialchars($q1[1]); ?>">
                        </div>

                        <div class="tf-service-info">
                            <div class="tf-service-topline">
                                <span class="tf-service-id"><?php echo str_pad($row_number, 2, "0", STR_PAD_LEFT); ?></span>
                                <span class="tf-db-id">ID <?php echo $q1[0]; ?></span>
                            </div>

                            <h3><?php echo htmlspecialchars($q1[1]); ?></h3>
                            <p><?php echo htmlspecialchars($q1[2]); ?></p>

                            <div class="tf-service-bottom">
                                <span class="tf-service-price">₹ <?php echo htmlspecialchars($q1[3]); ?></span>

                                <div class="tf-row-actions">
                                    <a href="admin_manage_type.php?teid=<?php echo $q1[0]; ?>" class="tf-edit-action">EDIT <span>↗</span></a>
                                    <a href="admin_manage_type.php?tdid=<?php echo $q1[0]; ?>"
                                       class="tf-delete-action"
                                       onclick="return confirm('Delete this service type?');">DELETE <span>×</span></a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                        $row_number++;
                    }
                }
                else
                {
                ?>
                    <div class="tf-empty-state">
                        <span class="tf-empty-number">00</span>
                        <h3>NO SERVICE TYPES FOUND</h3>
                        <p>Create your first service using the form on the left.</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </section>

</main>

<?php
include("admin_footer.php");
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("txtimg");
    const fileName = document.getElementById("tf-file-name");

    if (imageInput && fileName) {
        imageInput.addEventListener("change", function () {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name.toUpperCase();
            } else {
                fileName.textContent = "NO FILE SELECTED";
            }
        });
    }
});
</script>
