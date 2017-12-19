<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-06
 * Time: 14:43
 */


session_start();

include '../functions/funcs.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datanördarna</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" >
    <!--  <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap.css">
      <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap-responsive.css">
      <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/js/bootstrap.js"> -->

    <style>

        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;

        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #4CAF50;
            color: white;
        }

    </style>
</head>

<body>

<!-- start page-wrapper -->
<div class=wrapper>

    <!-- navigation menu -->
    <div class="header">

        <ul id="menu">
            <li><a href="../index.php">Hem</a></li>
            <li><a href="../custRegister.php">Registrera dig</a></li>
            <li><a href="../cart.php">Kundvagn</a></li>
            <br><br>
            <li><a href="#" class='active-page'>Min profil</a></li>
        </ul>

    </div>
    <!-- end navigation menu -->

     <div id=sidemenu>
         <div class="vertical-menu">
             <a href="#" class="active">Min Profil</a>

             <?php

             $user = $_SESSION['customerEmail'];

             $getImg = "select * from customers WHERE customerEmail='$user'";
             $runImg = mysqli_query($dbcon,$getImg);

             $rowImg = mysqli_fetch_array($runImg);

             $custImg = $rowImg['customerImg'];

             $custName = $rowImg['customerName'];

             echo "<img src='img/$custImg' width='200' height='200'/>";


             ?>

             <a href="custProfile.php?myOrders">Mina ordrar</a>
             <a href="custProfile.php?myAccount">Hantera konto</a>
             <!--<a href="custProfile.php?myPassword">Ändra lösenord</a>-->
             <!--<a href="custProfile.php?myErase">Radera konto</a>-->
         </div>
     </div>

    <div id=content>

        <?php cart(); ?>

        <div id="cartstyle">

            <span style=" font-size: 20px; padding: 5px;">

                <?php

                if(isset($_SESSION['customerEmail'])){

                    echo "<b style='color:white'>Välkommen </b>" . $_SESSION['customerEmail'];
                }

                ?>


                <?php
                if(!isset($_SESSION['customerEmail'])){

                    echo "<a style='color: yellow; text-decoration: none' href='../checkout.php'>Logga in</a>";

                }else{

                    echo "<a style='color: yellow; text-decoration: none' href='logout.php'>Logga ut</a>";
                }

                ?>

            </span>

        </div>

        <div id="productBox">

            <h2>Välkommen till din profilsida <?php echo $custName; ?></h2>
            <br><br>

            <?php

            if(isset($_GET['myAccount'])){

                include("myAccount.php");
            }

            if(isset($_GET['myOrders'])){

                include("myOrders.php");
            }

            ?>

        </div>



    </div> <!-- end content -->

</div> <!-- end wrapper -->

<div id=footer>
    <p>footer</p>
</div>


</body>

</html>
