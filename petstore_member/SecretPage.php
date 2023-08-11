<?php
    session_start();

    if (!isset($_SESSION['auth'])) {              
        header("Location:login.php");

        exit();
    }
    
    if (isset($_POST['logoutBtn'])) {
        header("Location:/catalog/");

        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
</head>
<body>
    <h1>welcome to your profile</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <input type="submit" name="logoutBtn" value="Logout">
    </form>
</body>
</html>
