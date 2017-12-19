<?php

session_start();

include 'functions/funcs.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datanördarna</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" >
  <!--  <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/js/bootstrap.js"> -->
</head>

<body>

<!-- start page-wrapper -->
    <div class=wrapper>

    <!-- navigation menu -->
    <div class="header">
        
        <ul id="menu">
            <li><a href="#" class='active-page'>Hem</a></li>
            <li><a href="custRegister.php">Registrera dig</a></li>
            <li><a href="cart.php">Kundvagn</a></li>
            <br><br>
            <li><a href="customer/custProfile.php">Min profil</a></li>

        </ul> 

    </div>
    <!-- end navigation menu -->

    <!-- <div id=sidemenu>
        <p>This will be sidemenu</p>
     </div> -->

    <div id=content>

        <?php cart(); ?>

        <div id="cartstyle">

            <span style=" font-size: 20px; padding: 5px;">

                <?php

                if(isset($_SESSION['customerEmail'])){

                    echo "<b style='color:white'>Välkommen</b>" . $_SESSION['customerEmail'];
                }else{
                    echo "<b style='color:white'>Välkommen gäst!</b>";
                }

                ?>


                <a style="float: right; margin-right: 10px; color: yellow" href="cart.php">Din kundvagn</a>


                <?php
                if(!isset($_SESSION['customerEmail'])){

                    echo "<a style='color: yellow; text-decoration: none' href='checkout.php'>Logga in</a>";

                }else{

                    echo "<a style='color: yellow; text-decoration: none' href='logout.php'>Logga ut</a>";
                }

                ?>

            </span>

        </div>

        <div id="productBox">

            <?php getProds(); ?>
        </div>



    </div> <!-- end content -->

</div> <!-- end wrapper -->

 <div id=footer>
    <p>footer</p>
 </div>


</body>

</html>