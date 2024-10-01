<?php
require_once('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteID = $_POST['sitesID'];
    $nazwa = $_POST['nazwa'];
    $strona = $_POST['strona'];

    // Sprawdź czy pola nie są puste
    if (!empty($siteID) && !empty($nazwa) && !empty($strona)) {
        $sql = "UPDATE dbo.raportSites SET strona='$strona', nazwa='$nazwa' WHERE sitesID = $siteID";
    $stmt = sqlsrv_query($conn, $sql);
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
}