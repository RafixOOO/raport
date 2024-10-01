<?php
session_start();

function login($username, $password)
{
    require('dbconnect.php');

    $tsql = "SELECT * FROM dbo.raportUser WHERE [login] = ?";
    $params = array($username);
    $getResults = sqlsrv_query($conn, $tsql, $params);
    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
    $row_date = $row['passdate'];  // Convert $row['date'] to a DateTime object
$current_date = new DateTime();          // Get the current date

// Subtract 3 months from the current date
$current_date->modify('-3 months');
    if(sqlsrv_fetch($getResults)=== false){
        return "brak";
    }
    else if($row['password']==='$2y$10$dnApSj6bPkO5WWojdCBfU.ICc5DwRik4cux69mVReWBUcDrZ2yXF6' ||  $row_date < $current_date){
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $row['userID'];
            $_SESSION['sidebar'] = $row['sidebar'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['role_admin'] = $row['admin'];
            return 'haslo';
        }
    }
    else if ($row) {
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $row['userID'];
            $_SESSION['sidebar'] = $row['sidebar'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['role_admin'] = $row['admin'];
            return true;
        }
    }else{
        return false;
    }
    
    
}

?>
<!DOCTYPE html>
<html>

<head>
<?php require_once("globalhead.php"); ?>
</head>
<body class="p-3 mb-2 bg-light bg-gradient text-dark" id="error-container">

            <div class="container">
        <h2 class="text-uppercase">Login</h2>
        <br />
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nazwa użytkownika</label>
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Wpisz nazwę użytkownika" required>
            </div>
            <br />
            <div class="form-group">
                <label for="password">Hasło</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Hasło" required>
            </div>
            <br />
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Zaloguj</button>
            <a href="index.php" type="button" class="btn btn-outline-success my-2 my-sm-0">Anuluj</a>
        </form>
            </div>
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)===true) {
        header("Location: index.php");
        exit();
        
    } else if(login($username, $password)==="haslo"){
        header("Location: password.php");
        exit();
    }else if(login($username, $password)==="brak"){
        echo "<p style='color:red; text-align:center;'>Brak użytkownika!!!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Błędne dane logowania!!!</p>";
    }
}
?>
</html>