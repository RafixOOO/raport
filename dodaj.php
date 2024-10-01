<?php 
require_once('dbconnect.php');
require_once('auth.php');
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once("globalhead.php"); ?>
</head id="error-container">
<body class="p-3 mb-2 bg-light bg-gradient text-dark">
    <!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
            <div class="container">
        <h2 class="text-uppercase">Dodaj</h2>
        <br />
        <form method="POST" action="">
            <br />
            <div class="form-group">
                <label for="new_password">Imię i Nazwisko</label>
                <input type="text" class="form-control" id="nazwa" name="nazwa" placeholder="Imię i Nazwisko" required>
            </div>
            <br />
            <div class="form-group">
                <label for="new_password">Login</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
            </div>
            <br />
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Dodaj</button>
            <a href="zarzadzaj.php" type="button" class="btn btn-outline-success my-2 my-sm-0">Anuluj</a>
        </form>
            </div>
            <input type="hidden" id="darkModeButton" />
   
</body>
<?php 

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nazwa = $_POST['nazwa'];
                $login = $_POST['login'];

                $sql = "INSERT INTO dbo.raportUser ( [name], [login],[password]) VALUES (?, ?, '$2y$10\$dnApSj6bPkO5WWojdCBfU.ICc5DwRik4cux69mVReWBUcDrZ2yXF6')";
                $params = array($nazwa, $login);


                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }else{
                header("Location: zarzadzaj.php");
                exit();
            }
            }
    

?>
</html>