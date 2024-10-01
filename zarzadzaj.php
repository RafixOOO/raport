<!DOCTYPE html>
<html lang="en">
    <?php
        
        require_once('dbconnect.php');
    ?>
<head>
<?php require_once 'auth.php'; 
if(!isUserAdmin()){
    header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
}
?>
   <?php require_once("globalhead.php"); ?>
</head>

<body class="p-3 mb-2 bg-light bg-gradient text-dark" id="error-container">
    <!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php if(isSidebar()==0){ ?>
<div class="container-fluid" style="width:80%;margin-left:14%;">
    <?php }else if(isSidebar()==1){ ?>
        <div class="container-fluid" style="width:90%; margin: 0 auto;">
        <?php } ?>
            <div class="table-responsive">
            <a href="dodaj.php" class="btn btn-success float-end">Dodaj</a>
            
            <table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">Imię i nazwisko</th>
      <th scope="col">Login</th>
      <th scope="col">Admin</th>
    <th scope="col">Prawa do stron</th>
      <th scope="col">Zarządzaj</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
    
        $sql = "SELECT 
    ru.userID, 
    ru.login, 
    ru.name, 
    ru.admin, 
    STRING_AGG('• ' + rs.nazwa, '<br/>') AS nazwa
FROM 
    raportUser ru
LEFT JOIN 
    raportPermission rp ON rp.userID = ru.userID and rp.permissionBool=1
LEFT JOIN 
    raportSites rs ON rs.sitesID = rp.sitesID AND rs.nazwa IS NOT NULL
GROUP BY 
    ru.userID, ru.login, ru.name, ru.admin
ORDER BY 
    ru.userID asc;";
        $stmt = sqlsrv_query($conn, $sql);
        $userID='';
        while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {           
    ?>
    <tr>
        <td><?php echo $data['name'] ?></td>
        <td><?php echo $data['login'] ?></td>
        <td>
            <form method="post" action="zmien_status.php">
                <input type="hidden" name="person_id" value="<?php echo $data['userID'] ?>">
                <input type="hidden" name="role" value="<?php echo 'admin' ?>">
                <?php if($data['admin']==1){ ?>
                <button type="submit" name="change_status" class="btn btn-success"></button><?php } else { ?>
                    <button type="submit" name="change_status" class="btn btn-danger"></button> <?php } ?>
            </form>
        </td>
        </td>
        <td>
        <?php echo $data['nazwa']; ?>
        </td>
        <td>
        <div style="float: left;margin-left:2%">
            <a href="permission_user.php?userID=<?php echo $data['userID'] ?>"><button class="btn btn-primary">
        Edytuj prawa
    </button> </a>
    </div>
        <form method="post" action="usun_haslo.php" style="float: left;margin-left:2%">
                <input type="hidden" name="person_id" value="<?php echo $data['userID'] ?>">
                <button type="submit" name="usun_haslo" class="btn btn-warning">Domyślne hasło</button>
            </form>
            <form method="post" action="usun_konto.php" style="float: left; margin-left:2%;">
                <input type="hidden" name="person_id" value="<?php echo $data['userID'] ?>">
                <button type="submit" name="usun_konto" class="btn btn-danger">Usuń konto</button>
            </form>
        </td>
    </tr>
    
    <?php } ?>
  </tbody>
</table>
</div>
        </div>
</div>
</div>
</div>
<?php require_once("globalnav.php"); ?>
</body>
</html>