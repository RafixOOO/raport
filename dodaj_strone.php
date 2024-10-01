<?php
// Sprawdź, czy formularz został wysłany
require_once('dbconnect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pobieranie danych z formularza za pomocą tablicy $_POST
    $nazwa = isset($_POST['nazwa']) ? $_POST['nazwa'] : '';
    $link = isset($_POST['link']) ? $_POST['link'] : '';

    // Walidacja danych
    if (!empty($nazwa) && !empty($link)) {
        // Tutaj możesz przetworzyć dane, np. dodać je do bazy danych
        $sql = "INSERT INTO PartCheck.dbo.raportSites
            (strona, nazwa)
            VALUES('$link', '$nazwa');";
        $stmt = sqlsrv_query($conn, $sql);

    }
    if ($stmt) {
        // Usunięcie hasła powiodło się
        // Możesz wyświetlić komunikat lub przekierować użytkownika na inną stronę
        header("Location: strony.php");
        exit();
    } else {
        // Wystąpił błąd podczas usuwania hasła
        // Możesz wyświetlić odpowiedni komunikat błędu
        echo "Wystąpił błąd podczas usuwania hasła.";
    }
}
?>
