<?php

/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-10
 * Time: 20:31
 */

include ("../db/dbconnection.php");
?>


            <?php
            $user = $_SESSION['customerEmail'];

            $getCust = "select * from customers WHERE customerEmail='$user'";

            $runCust = mysqli_query($dbcon,$getCust);

            $rowCust = mysqli_fetch_array($runCust);


            $custID = $rowCust['customerID'];
            $newName = $rowCust['customerName'];
            $newEmail = $rowCust['customerEmail'];
            $newPass = $rowCust['customerPass'];
            $newCountry = $rowCust['customerCountry'];
            $newCity = $rowCust['customerCity'];
            $newContact = $rowCust['customerContact'];
            $newImg = $rowCust['customerImg'];


            ?>

            <form action="" method="post" enctype="multipart/form-data">

                <table align="center" width="600px">

                    <tr>
                        <td><h2>Ändra konto-uppgifter</h2></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td align="right">Namn:</td>
                        <td><input type="text" name="custName" value="<?php echo $newName; ?>" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">E-post:</td>
                        <td><input type="text" name="custEmail" value="<?php echo $newEmail; ?>" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Lösenord:</td>
                        <td><input type="password" name="custPass" value="<?php echo $newPass; ?>" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Profilbild:</td>
                        <td><input type="file" name="custImg"/><img src="img/<?php echo $newImg; ?>" height="50" width="50"/> </td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td align="right">Land:</td>
                        <td>
                            <select name="custCountry" disabled>

                                <option><?php echo $newCountry; ?> </option>
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
                        <td><input type="text" name="custCity" value="<?php echo $newCity; ?>" required /></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td align="right">Adress:</td>
                        <td><input type="text" name="custContact" value="<?php echo $newContact; ?>" required/></td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>


                    <tr>
                        <td><input type="submit" name="update" value="Skicka"/></td>
                    </tr>

                </table>

            </form>

<?php

if(isset($_POST['update'])){

    $ip = getIp();

    $thisCustID = $custID;
    $custName = $_POST['custName'];
    $custEmail = $_POST['custEmail'];
    $custPass = $_POST['custPass'];

    $custImg = $_FILES['custImg']['name'];
    $custImgTmp = $_FILES['custImg']['tmp_name'];

    move_uploaded_file($custImgTmp,"img/$custImg");

    $custCity = $_POST['custCity'];
    $custContact = $_POST['custContact'];



    $updateCust = "update customers set customerName='$custName',customerEmail='$custEmail',customerPass='$custPass',customerCity='$custCity',customerContact='$custContact',customerImg='$custImg' WHERE customerID='$thisCustID'";

    $runUpdate = mysqli_query($dbcon,$updateCust);

   if($runUpdate){

       echo "<script>alert('Ditt konto har uppdaterats')</script>";
       echo "<script>window.open('custProfile.php','_self')</script>";
   }


}


?>


