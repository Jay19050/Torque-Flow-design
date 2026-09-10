<?php
session_start();
include("cust_header.php");
include("connection.php");
?>
<main class="tf-portal-page"><div class="tf-portal-shell">
    <p class="tf-page-eyebrow">01 / CUSTOMER SERVICES</p>
    <header class="tf-page-heading"><h1>KEEP IT<br><span>FLOWING.</span></h1><p>Choose the service your vehicle needs, then book a time at a Torque Flow center near you.</p></header>
    <section class="tf-content-panel">
                <?php 
               $qur = mysqli_query($con,"select * from type_info");
               if(mysqli_num_rows($qur)> 0)
                {
                    ?>
                <div class="tf-service-grid">
                    <?php
                    while($q1 = mysqli_fetch_array($qur))
                    {
                        ?>
                    <article class="tf-service-card"><img src="<?php echo $q1[4];?>" alt="<?php echo htmlspecialchars($q1[1]); ?>"><div class="tf-card-body"><span class="tf-card-index">SERVICE / <?php echo str_pad($q1[0], 2, '0', STR_PAD_LEFT); ?></span><h2 class="tf-card-title"><?php echo $q1[1];?></h2><div class="tf-card-footer"><span class="tf-price">₹ <?php echo $q1[3];?>/-</span><a href="cust_book_service.php?tid=<?php echo $q1[0]; ?>" class="tf-action">BOOK SERVICE <b>↗</b></a></div></div></article>
                    <?php
                    }
                    ?>
                </div>
                <?php
                }else{
                    echo "<h2 class='tf-empty'>NO SERVICE TYPES FOUND</h2>";
                }
                ?>
    </section></div></main>
<?php
include("footer.php")
?>
