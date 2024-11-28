

<?php require('auth.php'); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        header {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-sizing: border-box;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        .date {
            font-size: 16px;
        }
        iframe {
            width: 100%;
            height: 830px;
            border: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php if(isSidebar()==0){ ?>
<div class="container-fluid" style="width:80%;margin-left:14%;">
    <?php }else if(isSidebar()==1){ ?>
        <div class="container-fluid" style="width:90%; margin: 0 auto;">
        <?php } ?>
<header>
    <h1>Raporty</h1>
    <div class="date">Data: <span id="currentDate"></span></div>
</header>
<br />

<?php
$id = isIdent();
require_once("dbconnect.php");
$sql = "SELECT distinct rs.nazwa, rs.strona, rs.sitesID, rp.permissionBool
FROM PartCheck.dbo.raportSites rs 
 left JOIN PartCheck.dbo.raportPermission rp on rs.sitesID = rp.sitesID and rp.userID=$id";

$stmt = sqlsrv_query($conn, $sql);

// Sprawdzenie, czy zapytanie zostało poprawnie wykonane
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$counter = 0; // Licznik raportów
if(isLoggedIn()){
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    
    // Rozpocznij nowy wiersz dla co drugiego raportu
    if ($counter % 2 == 0) {
        echo '<div class="row mb-4">'; // Nowy rząd i margines na dole
    }
?>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <center><h5 class="card-title"><?php echo $row['nazwa']; ?></h5></center>
                <?php if($row['permissionBool']==1){ ?>
                <a style="float:right;margin-right:5%;" href="<?php echo 'raport.php?ID=' . $row['sitesID']; ?>" class="btn btn-primary">Idź do raportu</a>
                <?php }else{ ?>
                    <button style="float:right;margin-right:5%;" class="btn btn-danger">Brak dostępu</button>
                    <?php } ?>
            </div>
        </div>
    </div>

<?php 
    $counter++;

    // Zamknij wiersz po wyświetleniu dwóch raportów
    if ($counter % 2 == 0) {
        echo '</div>'; // Koniec rzędu
    }
} 

// Zamknij otwarty wiersz, jeśli liczba raportów jest nieparzysta
if ($counter % 2 != 0) {
    echo '</div>'; // Koniec rzędu
}

// Komunikat, jeśli brak raportów
}else {
    echo "<center><h4>Aby uzyskać dostęp do raportów, zaloguj się na swoje konto. Jeśli nie posiadasz konta lub masz problem z logowaniem, skontaktuj się z administratorem w celu utworzenia konta lub resetu hasła.</h4></center>";
}
?>
</div>
<script>
    // Skrypt do wstawienia aktualnej daty
    document.getElementById("currentDate").innerText = new Date().toLocaleDateString();
</script>
</div>
<?php require_once("globalhead.php"); ?>
<?php require_once("globalnav.php"); ?>
</body>
</html>

