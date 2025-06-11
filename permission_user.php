<?php

require_once('dbconnect.php');
require_once('auth.php');
if (!isUserAdmin()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

<head>
    <?php require_once 'auth.php'; ?>
    <?php require_once("globalhead.php"); ?>
</head>

<body class="p-3 mb-2 bg-light bg-gradient text-dark" id="error-container" style="width:40%; margin-left: auto;margin-right:auto;">
    <!-- 2024 Created by: Rafał Pezda-->
    <!-- link: https://github.com/RafixOOO -->
    <?php
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
    }
    $sql = "SELECT rs.sitesID, rs.nazwa, rp.permissionBool 
                            FROM raportSites rs
                            LEFT JOIN raportPermission rp ON rp.sitesID = rs.sitesID AND rp.userID = $userID";
    $stmt = sqlsrv_query($conn, $sql);
    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    ?>
        <form method="post" action="zmien_status_permission.php">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <input type="hidden" name="person_id" value="<?php echo $userID; ?>">
                <input type="hidden" name="role" value="<?php echo $data['sitesID']; ?>">
                <label><?php echo $data['nazwa']; ?></label>
                <?php if ($data['permissionBool'] == 1) { ?>
                    <button type="submit" name="change_status" class="btn btn-success">Zmień status</button><?php } else { ?>
                    <button type="submit" name="change_status" class="btn btn-danger">Zmień status</button> <?php } ?>
            </div>
        </form>
        <hr>
    <?php } ?>
    <div style="float:right;">
        <a href="zarzadzaj.php"> <button type="button" class="btn btn-secondary">wróć</button></a>
    </div>
</body>

</html>