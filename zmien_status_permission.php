<?php
require_once('dbconnect.php');
require_once('auth.php');
if (isset($_POST['change_status'])) {
    $personId = $_POST['person_id'];
    $role = $_POST['role'];
    
    
    
    
    // Ustal wartość zmiennych $personId i $role
$check = "SELECT * FROM raportPermission rp WHERE rp.userID = $personId AND rp.sitesID = $role";
$stmt = sqlsrv_query($conn, $check); // Poprawne użycie zmiennej $check

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Jeśli istnieje rekord, zaktualizuj permissionBool
    $sql = "UPDATE dbo.raportPermission 
            SET permissionBool = CASE 
                WHEN permissionBool = 1 THEN 0 
                ELSE 1 
            END 
            WHERE userID = $personId AND sitesID = $role";
    
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt) {
        // Operacja powiodła się, przekierowanie
        header("Location: permission_user.php?userID=".$personId);
        exit();
    } else {
        echo "Wystąpił błąd podczas aktualizacji.";
    }
} else {
    // Jeśli nie istnieje rekord, wstaw nowy
    $sql = "INSERT INTO dbo.raportPermission (userID, sitesID, permissionBool)
            VALUES ($personId, $role, 1)";
    
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt) {
        // Operacja powiodła się, przekierowanie
        header("Location: permission_user.php?userID=".$personId);
        exit();
    } else {
        echo "Wystąpił błąd podczas dodawania rekordu.";
    }
}

    
}
?>
