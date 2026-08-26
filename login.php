<?php
include("header.php");
include("connection.php");

if(isset($_POST["btnlogin"]))
{
    $email = $_POST["txtemail"];
    $pwd = $_POST["txtpwd"];

    $res = mysqli_query($con,"select * from admin_detail where email_id='$email' and pwd='$pwd'");

    if(mysqli_num_rows($res)>0)
    {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $admin_row = mysqli_fetch_assoc($res);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin_row['email_id'];
        $_SESSION['admin_id'] = $admin_row['admin_id'];

        echo "<script>";
        echo "alert('Admin Login Successful');";
        echo "window.location.href='admin_manage_type.php';";
        echo "</script>";
    }
    else
    {       
        $res2 = mysqli_query($con,"select * from cust_regis where email_id='$email' and pwd='$pwd'");

        if(mysqli_num_rows($res2)>0)
        {
            echo "<script>";
            echo "alert('Client Login Successful');";
            echo "</script>";
        }
        else
        {       
            $res3 = mysqli_query($con,"select * from service_center_info where email_id='$email' and pwd='$pwd'");

            if(mysqli_num_rows($res3)>0)
            {
                echo "<script>";
                echo "alert('Service Center Login Successful');";
                echo "</script>";
            }
            else
            {       
                echo "<script>";
                echo "alert('Check Your Email ID or Password');";
                echo "window.location.href='login.php'";
                echo "</script>";
            }
        }
    }
}
?>


<main id="main-content" class="login-page">

    <section class="login-section">

       
        <div class="login-container">

            <div class="login-inner">

                <div class="login-heading">

                    <div class="login-number">
                        02 / CLIENT ACCESS
                    </div>

                    <h1>
                        WELCOME<br>
                        BACK.
                    </h1>

                    <p>
                        Enter your credentials to access your
                        Torque Flow account.
                    </p>

                </div>


                <form method="post" class="login-form">

                    <div class="login-field">

                        <label for="login-email">
                            EMAIL ADDRESS
                        </label>

                        <input
                            type="email"
                            id="login-email"
                            name="txtemail"
                            autocomplete="email"
                            spellcheck="false"
                            autocapitalize="none"
                            placeholder="e.g., alex@example.com…"
                            required
                        >

                    </div>


                    <div class="login-field">

                        <label for="login-password">
                            PASSWORD
                        </label>

                        <input
                            type="password"
                            id="login-password"
                            name="txtpwd"
                            autocomplete="current-password"
                            spellcheck="false"
                            placeholder="Enter your password…"
                            required
                        >

                    </div>


                    <button type="submit" class="login-submit" name="btnlogin">

                        <span>
                            LOGIN
                        </span>

                        <span class="login-arrow" aria-hidden="true">
                            ↗
                        </span>

                    </button>

                </form>


                

                <div class="login-register">

                    <span>
                        DON’T HAVE AN ACCOUNT?
                    </span>

                    <a href="registration.php">
                        REGISTER
                        <span aria-hidden="true">↗</span>
                    </a>

                </div>

            </div>

        </div>


      

        <div class="login-image">

            <div class="login-image-overlay"></div>


            <div class="login-image-content">

                <div class="login-image-top">
                    <span>
                        TORQUE FLOW
                    </span>
                </div>


                <div class="login-image-title">

                    <h2>
                        DRIVE<br>
                        WITH<br>
                        PURPOSE.
                    </h2>

                </div>


                <div class="login-image-bottom">

                    <span>
                        PRECISION
                    </span>

                    <span class="login-dot" aria-hidden="true">
                        /
                    </span>

                    <span>
                        PERFORMANCE
                    </span>

                    <span class="login-dot" aria-hidden="true">
                        /
                    </span>

                    <span>
                        TRUST
                    </span>

                </div>

            </div>

        </div>

    </section>

</main>


<?php
include("footer.php");
?>