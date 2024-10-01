<?php
require_once('dbconnect.php');
require_once('auth.php');
if (isset($_POST['change_status'])) {
    $personId = $_POST['person_id'];
    $role = $_POST['role'];
    

    
    $sql = "UPDATE dbo.raportUser SET $role = CASE WHEN $role = 1 THEN 0 ELSE 1 END WHERE userID = $personId";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt) {
        // Usunięcie hasła powiodło się
        // Możesz wyświetlić komunikat lub przekierować użytkownika na inną stronę
        header("Location: zarzadzaj.php");
        exit();
    } else {
        // Wystąpił błąd podczas usuwania hasła
        // Możesz wyświetlić odpowiedni komunikat błędu
        echo "Wystąpił błąd podczas usuwania hasła.";
    }
}
?>
