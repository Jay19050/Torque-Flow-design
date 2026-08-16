<?php
include("header.php");
include("connection.php");
?>

<script>
function validation()
{
    var form1 = document.getElementById("form1");

    var v = /^[a-zA-Z ]{2,50}$/;

    if(form1.txtname.value=="")
    {
        alert("Please Enter Your Name");
        form1.txtname.focus();
        return false;
    }
    else
    {
        if(!v.test(form1.txtname.value))
        {
            alert("Please Enter Only Alphabets in Your Name");
            form1.txtname.focus();
            return false;
        }
    }

    if(form1.txtadd.value=="")
    {
        alert("Please Enter Your Address");
        form1.txtadd.focus();
        return false;
    }

    if(form1.txtcity.value=="")
    {
        alert("Please Enter Your City Name");
        form1.txtcity.focus();
        return false;
    }
    else
    {
        if(!v.test(form1.txtcity.value))
        {
            alert("Please Enter Only Alphabets in Your City Name");
            form1.txtcity.focus();
            return false;
        }
    }

    var v = /^[0-9]{10}$/;

    if(form1.txtmno.value=="")
    {
        alert("Please Enter Your Mobile No");
        form1.txtmno.focus();
        return false;
    }
    else if(form1.txtmno.value.length!=10)
    {
        alert("Please Enter Your Mobile No 10 Digit Long");
        form1.txtmno.focus();
        return false;
    }
    else
    {
        if(!v.test(form1.txtmno.value))
        {
            alert("Please Enter Only Digits in Your Mobile No");
            form1.txtmno.focus();
            return false;
        }
    }

    var v = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/;

    if(form1.txtemail.value=="")
    {
        alert("Please Enter Your Email ID");
        form1.txtemail.focus();
        return false;
    }
    else
    {
        if(!v.test(form1.txtemail.value))
        {
            alert("Please Enter Valid Email ID");
            form1.txtemail.focus();
            return false;
        }
    }

    if(form1.txtpwd.value=="")
    {
        alert("Please Enter Your Password");
        form1.txtpwd.focus();
        return false;
    }
    else if(form1.txtpwd.value.length<6)
    {
        alert("Please Enter Your Password More Than 6 Characters");
        form1.txtpwd.focus();
        return false;
    }
    else if(form1.txtpwd.value.length>10)
    {
        alert("Please Enter Your Password Less Than 10 Characters");
        form1.txtpwd.focus();
        return false;
    }

    return true;
}
</script>


<?php

if(isset($_POST["btnregis"]))
{
    $name = $_POST["txtname"];
    $add = $_POST["txtadd"];
    $city = $_POST["txtcity"];
    $mno = $_POST["txtmno"];
    $email = $_POST["txtemail"];
    $pwd = $_POST["txtpwd"];

    $res = mysqli_query($con,"select * from cust_regis where email_id='$email'");

    if(mysqli_num_rows($res)>0)
    {
        echo "<script>";
        echo "alert('Email Id already exists');";
        echo "</script>";
    }
    else
    {
        $res2 = mysqli_query($con,"select max(cust_id) from cust_regis");

        $cid=0;

        while($r2=mysqli_fetch_array($res2))
        {
            $cid = $r2[0];
        }

        $cid++;

        $query= "insert into cust_regis values ('$cid','$name','$add','$city','$mno','$email','$pwd')";

        if(mysqli_query($con,$query))
        {
            echo "<script>";
            echo "alert('Registered Successfully');";
            echo "window.location.href='login.php'";
            echo "</script>";
        }
        else
        {
            echo "Error in Registration: ".mysqli_error($con);
        }
    }
}

?>


<link rel="stylesheet" href="css/registration.css?v=1">


<main id="main-content" class="registration-page">

    <section class="registration-section">

        <!-- LEFT SIDE -->
        <div class="registration-content">

            <div class="registration-number">
                01 / REGISTRATION
            </div>

            <div class="registration-main">

                <div class="registration-label">
                    TORQUE FLOW
                </div>

                <h1>
                    CREATE<br>
                    YOUR ACCOUNT<span>.</span>
                </h1>

                <p>
                    Join Torque Flow and keep your vehicle maintained
                    with precision, performance and care.
                </p>

                <div class="registration-values">
                    <span>PRECISION</span>
                    <span aria-hidden="true">/</span>
                    <span>PERFORMANCE</span>
                    <span aria-hidden="true">/</span>
                    <span>CARE</span>
                </div>

            </div>

            <div class="registration-watermark" aria-hidden="true">
                REGISTER
            </div>

        </div>


        <!-- RIGHT SIDE -->
        <div class="registration-form-container">

            <div class="registration-form-heading">

                <div class="form-label">
                    CLIENT ACCESS
                </div>

                <h2>
                    CREATE ACCOUNT
                </h2>

                <p>
                    Enter your details to get started.
                </p>

            </div>


            <form
                method="post"
                id="form1"
                name="form1"
                class="registration-form"
            >

                <!-- FULL NAME -->
                <div class="registration-field">

                    <label for="txtname">
                        FULL NAME
                    </label>

                    <input
                        type="text"
                        id="txtname"
                        name="txtname"
                        autocomplete="name"
                        placeholder="e.g., Alex Smith…"
                        required
                    >

                </div>


                <!-- ADDRESS -->
                <div class="registration-field">

                    <label for="txtadd">
                        ADDRESS
                    </label>

                    <textarea
                        id="txtadd"
                        name="txtadd"
                        rows="3"
                        autocomplete="street-address"
                        placeholder="e.g., 123 Performance Way…"
                        required
                    ></textarea>

                </div>


                <!-- CITY + MOBILE -->
                <div class="registration-row">

                    <div class="registration-field">

                        <label for="txtcity">
                            CITY
                        </label>

                        <input
                            type="text"
                            id="txtcity"
                            name="txtcity"
                            autocomplete="address-level2"
                            placeholder="e.g., Mumbai…"
                            required
                        >

                    </div>


                    <div class="registration-field">

                        <label for="txtmno">
                            MOBILE NO.
                        </label>

                        <input
                            type="tel"
                            id="txtmno"
                            name="txtmno"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            inputmode="tel"
                            autocomplete="tel"
                            placeholder="e.g., 9408663504…"
                            required
                        >

                    </div>

                </div>


                <!-- EMAIL -->
                <div class="registration-field">

                    <label for="txtemail">
                        EMAIL ADDRESS
                    </label>

                    <input
                        type="email"
                        id="txtemail"
                        name="txtemail"
                        autocomplete="email"
                        spellcheck="false"
                        autocapitalize="none"
                        placeholder="e.g., alex@example.com…"
                        required
                    >

                </div>


                <!-- PASSWORD -->
                <div class="registration-field">

                    <label for="txtpwd">
                        PASSWORD
                    </label>

                    <input
                        type="password"
                        id="txtpwd"
                        name="txtpwd"
                        maxlength="10"
                        autocomplete="new-password"
                        spellcheck="false"
                        aria-describedby="pwd-help"
                        placeholder="Enter 6–10 characters…"
                        required
                    >

                    <small id="pwd-help">
                        6–10 CHARACTERS
                    </small>

                </div>


                <!-- REGISTER BUTTON -->
                <button
                    type="submit"
                    name="btnregis"
                    class="registration-submit"
                    onclick="return validation()"
                >

                    <span>
                        REGISTER
                    </span>

                    <span class="registration-arrow" aria-hidden="true">
                        ↗
                    </span>

                </button>

            </form>


            <!-- LOGIN LINK -->
            <div class="registration-login">

                <span>
                    ALREADY HAVE AN ACCOUNT?
                </span>

                <a href="login.php">
                    LOGIN <span aria-hidden="true">↗</span>
                </a>

            </div>

        </div>

    </section>

</main>


<?php
include("footer.php");
?>