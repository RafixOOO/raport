<?php
require_once('auth.php');
require_once('dbconnect.php');
function updatePassword($username, $newPassword)
{
    $serverName = '10.100.100.48,49827';
$connectionOptions = array(
    "Database" => "PartCheck",
    "Uid" => "Sa",
    "PWD" => "Shark1445NE\$T"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} 
    // Haszowanie nowego hasła
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Aktualizacja hasła w bazie danych
    $tsql = "UPDATE dbo.raportUser SET [password] = ?, passdate=GETDATE() WHERE userID = ?";
    $params = array($hashedPassword, $username);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    return true;
}

// Sprawdzenie, czy formularz został wysłany

?>
<!DOCTYPE html>
<html>

<head>
<?php require_once("globalhead.php"); ?>
</head>
<body class="p-3 mb-2 bg-light bg-gradient text-dark" id="error-container">
    <!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
            <div class="container">
        <h2 class="text-uppercase">Wymaganie zmiany hasła</h2>
        <br />
        <form method="POST" action="">
            <div class="form-group">
                <label for="current_password">Nowe hasło</label>
                <input type="password" class="form-control" id="current_password" name="current_password"
                    placeholder="Aktualne Hasło">
            </div>
            <br />
            <div class="form-group">
                <label for="new_password">Powtórz hasło</label>
                <input type="password" class="form-control" id="new_password" name="new_password" 
       placeholder="Nowe Hasło" 
       pattern="(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,}" 
       title="Hasło musi zawierać przynajmniej 8 znaków, przynajmniej jedną wielką literę, jeden znak specjalny i jedną liczbę" 
       required>
            </div>
            <br />
            <button type="submit" id="submit_btn" class="btn btn-outline-success my-2 my-sm-0">Zmień</button>
            <p id="error_message" style="color:red;"></p>
        </form>
            </div>
</body>
<script>
    document.getElementById("submit_btn").addEventListener("click", function(e) {
    const currentPassword = document.getElementById("current_password").value;
    const newPassword = document.getElementById("new_password").value;
    const errorMessage = document.getElementById("error_message");
    
    if (currentPassword !== newPassword) {
        e.preventDefault(); // Prevent form submission
        errorMessage.textContent = "Hasła muszą być takie same!";
    } else if(newPassword=="Tarkon2022##") {
        e.preventDefault();
        errorMessage.textContent = "Hasło nie może być hasłem domyślnym"; // Clear error message
    }else{
        errorMessage.textContent = "";
    }
});
</script>
<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        // Pobranie danych z formularza
        $username = $_SESSION['id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        // Sprawdzenie, czy aktualne hasło jest poprawne
        $tsql = "SELECT [password] FROM raportUser WHERE userID = ?";
        $params = array($username);
        $stmt = sqlsrv_query($conn, $tsql, $params);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($row && !password_verify($newPassword, $row['password'])) {
            // Aktualizacja hasła
            if (updatePassword($username, $newPassword)) {
                echo "<script>toastr.success('Hasło zostało zmienione!!!')</script>";
                header("Location: index.php");
                exit();
            } else {
                echo "<script>toastr.error('Wystąpił problem podczas zmiany hasła!!!')</script>";
            }
        }
    
    sqlsrv_close($conn);
}

?>
</html>