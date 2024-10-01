<?php
require_once('dbconnect.php');
require_once('auth.php');
if (isset($_POST['usun_haslo'])) {
    $personId = $_POST['person_id'];

    // Tutaj dodaj kod do usunięcia hasła osoby o podanym identyfikatorze ($personId) w bazie danych

    // Przykładowy kod, który usuwa hasło
    $sql = "UPDATE dbo.raportUser SET password = '$2y$10\$dnApSj6bPkO5WWojdCBfU.ICc5DwRik4cux69mVReWBUcDrZ2yXF6' WHERE userID = $personId";
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
