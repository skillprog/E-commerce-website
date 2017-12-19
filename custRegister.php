<?php

session_start();

include 'db/dbconnection.php';
include 'functions/funcs.php';

if(isset($_SESSION['customerEmail'])){
    echo "<script>alert('Du är redan inloggad!')</script>";
    echo "<script>window.open('index.php','_self')</script>";
}

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
            <li><a href="index.php" >Hem</a></li>
            <li><a href="#" class='active-page'>Registrera dig</a></li>
            <li><a href="cart.php">Kundvagn</a></li>
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

            </span>

        </div>

        <div style="width: 700px; height: 650px; margin-left: 25%; margin-right: 25%; border: solid red 2px;">

            <form action="custRegister.php" method="post" enctype="multipart/form-data">

                <table align="center" width="600px">

                    <tr>
                        <td><h2>Skapa konto</h2></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td align="right">Namn:</td>
                        <td><input type="text" name="custName" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">E-post:</td>
                        <td><input type="text" name="custEmail" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Lösenord:</td>
                        <td><input type="password" name="custPass" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Profilbild:</td>
                        <td><input type="file" name="custImg"/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td align="right">Land:</td>
                        <td>
                            <select name="custCountry">

                                <option>Sverige</option>
                                <option>Norge</option>
                                <option>Danmark</option>
                                <option>Finlands</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td align="right">Stad:</td>
                        <td><input type="text" name="custCity" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Adress:</td>
                        <td><input type="text" name="custContact" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td><input type="submit" name="register" value="Skapa konto"/></td>
                    </tr>

                </table>

            </form>

        </div>



        </div> <!-- end content -->

</div> <!-- end wrapper -->

 <div id=footer>
    <p>footer</p>
 </div>


</body>

</html>
<?php

    if(isset($_POST['register'])){

        $ip = getIp();

        $custName = $_POST['custName'];
        $custEmail = $_POST['custEmail'];
        $custPass = $_POST['custPass'];

        $custImg = $_FILES['custImg']['name'];
        $custImgTmp = $_FILES['custImg']['tmp_name'];

        move_uploaded_file($custImgTmp,"customer/img/$custImg");

        $custCountry = $_POST['custCountry'];
        $custCity = $_POST['custCity'];
        $custContact = $_POST['custContact'];


        $insertCust = "insert into customers (customerIP,customerName,customerEmail,customerPass,customerCountry,customerCity,customerContact,customerImg) 
         VALUES ('$ip','$custName','$custEmail','$custPass','$custCountry','$custCity','$custContact','$custImg')";

        $runCust = mysqli_query($dbcon,$insertCust);

        // get the customers selected cart with products
        $selectCart = "select * from cart WHERE prodADD='$ip'";

        $runCart = mysqli_query($dbcon,$selectCart);

        $checkCart = mysqli_num_rows($runCart);



       if($checkCart==0){

           $_SESSION['customerEmail']=$custEmail;
           echo "<script>alert('Registrering lyckades!')</script>";
           echo "<script>window.open('customer/custProfile.php','_self')</script>";

       }else{

           $_SESSION['customerEmail']=$custEmail;
           echo "<script>alert('Registrering lyckades!')</script>";
           echo "<script>window.open('checkout.php','_self')</script>";

       }

    }


?>

