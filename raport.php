<?php require('auth.php'); ?>
<?php require_once("dbconnect.php"); ?>
<?php
if (isset($_GET['ID'])) {
    // Pobierz wartość parametru 'ID'
    $id = $_GET['ID'];
} else {
    $id=0;
}
$userid = isIdent();
 
 $strona = '';
 $nazwa = '';
 $sql = "SELECT rp.permissionBool, rs.strona, rs.nazwa 
FROM raportPermission rp
inner join raportSites rs on rp.sitesID = rs.sitesID 
where rp.userID = $userid and rp.sitesID =$id";
                   $stmt = sqlsrv_query($conn, $sql);
                   while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        if($data['permissionBool']==1){
                            $strona=$data['strona'];
                            $nazwa=$data['nazwa'];
                        }
                   }
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wykres Power BI</title>
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
        <?php } ?><header>
    <h1><?php echo $nazwa; ?></h1>
    <div class="date">Data: <span id="currentDate"></span></div>
</header>

<!-- Użyj lokalnego proxy -->
<div class="iframe-container">
        <iframe id="myIframe" title="<?php echo htmlspecialchars($nazwa); ?>" src="<?php echo htmlspecialchars($strona); ?>" allowFullScreen></iframe>
    </div>

</div>

<?php require_once("globalnav.php"); ?>
</body>
<script>
    // Skrypt do wstawienia aktualnej daty
    document.getElementById("currentDate").innerText = new Date().toLocaleDateString();
</script>
</html>
