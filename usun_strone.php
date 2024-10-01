<?php
require_once('dbconnect.php');
require_once('auth.php');
if (isset($_POST['usun_konto'])) {
    $personId = $_POST['person_id'];

    // Tutaj dodaj kod do usunięcia konta osoby o podanym identyfikatorze ($personId) z bazy danych

    // Przykładowy kod, który usuwa konto
    $sql = "DELETE FROM dbo.raportSites WHERE sitesID = $personId";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt) {
        // Usunięcie konta powiodło się
        // Możesz wyświetlić komunikat lub przekierować użytkownika na inną stronę
        
    } else {
        // Wystąpił błąd podczas usuwania konta
        // Możesz wyświetlić odpowiedni komunikat błędu
        echo "Wystąpił błąd podczas usuwania strony.";
    }

    $sql1 = "DELETE FROM dbo.raportPermission WHERE sitesID = $personId";
    $stmt1 = sqlsrv_query($conn, $sql1);
    if ($stmt1) {
        // Usunięcie konta powiodło się
        // Możesz wyświetlić komunikat lub przekierować użytkownika na inną stronę
        header("Location: strony.php");
        exit();
    } else {
        // Wystąpił błąd podczas usuwania konta
        // Możesz wyświetlić odpowiedni komunikat błędu
        echo "Wystąpił błąd podczas usuwania strony.";
    }
}
?>
