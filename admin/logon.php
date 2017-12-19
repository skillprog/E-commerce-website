<?php
session_start();
?>
<!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" media="screen" href="styleLog.css" >
    </head>
        <body>
            <div class="login">
                <h1>Admin</h1>
                <form method="post" action="logon.php">
                    <input type="text" name="email" placeholder="E-mail" required="required" />
                    <input type="password" name="password" placeholder="Lösenord" required="required" />
                    <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Logga in</button>
                </form>
            </div>
        </body>
    </html>

<?php


include("admindbcon.php");



if(isset($_POST['login'])) {

    $email = ($_POST['email']);
    $pass = ($_POST['password']);

    $selUser = "select * from admins where userEmail='$email' AND userPass='$pass'";
    $runUser = mysqli_query($dbcon, $selUser);

    $checkUser = mysqli_num_rows($runUser);

    if ($checkUser == 1) {

        $_SESSION['userEmail'] = $email;
        echo "<script>window.open('index.php?logged=Du har loggat in!','_self')</script>";

    } else {

        echo "<script>alert('Lösenordet eller E-posten är felaktig!')</script>";
    }
}
?>