<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-12
 * Time: 22:20
 * INDEX FOR ADMINSITE
 */

session_start();

if(!isset($_SESSION['userEmail'])){

    echo "<script>window.open('logon.php?denied=Du har ej loggat in!','_self')</script>";
}else{




include("admindbcon.php");

?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Datanördarna</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
        <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/js/bootstrap.js">

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

            <h2>Admin Site</h2>

        </div>

        <div id="subadminhead">


        </div>
        <!-- end navigation menu -->

        <div id=sidemenu>
            <div class="vertical-menu">
                <a href="index.php" class="active">Admin</a>
                <a href="index.php?adminInsert">Skapa ny produkt</a>
                <a href="index.php?adminView">Visa/redigera produkter</a>
                <a href="index.php?adminViewCust">Visa kunder</a>
                <a href="logout.php">Utloggning</a>
            </div>
        </div>

        <div id=content>

            <?php

                if(isset($_GET['adminInsert'])){

                    include ("adminInsert.php");
                }
                if(isset($_GET['adminView'])){

                include ("adminView.php");
                }
                if(isset($_GET['adminEdit'])){

                include ("adminEdit.php");
                }
                if(isset($_GET['adminViewCust'])){

                    include ("adminViewCust.php");
                }

            ?>

        </div> <!-- end content -->

    </div> <!-- end wrapper -->

    <div id=footer>
        <p>footer</p>
    </div>


    </body>

    </html>
<?php } ?>