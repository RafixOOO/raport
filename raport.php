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
<?php require_once("globalhead.php"); ?>
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
        <?php } ?><header>
    <h1><?php echo $nazwa; ?></h1>
    <div class="date">Data: <span id="currentDate"></span></div>
</header>

<?php
// Klucz szyfrujący (musisz przechowywać go bezpiecznie)
$encryption_key = '5a@d!7g^T8m#jQ2$Xk&f*Lw3*zKc9#Vr';  // 32-znakowy klucz dla AES-256
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));  // Wektor inicjalizacyjny (IV)

// Funkcja szyfrująca URL
function encrypt_url($url, $key, $iv) {
    $encrypted_url = openssl_encrypt($url, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted_url . '::' . base64_encode($iv));  // Łączymy zaszyfrowane dane i IV
}

// Funkcja deszyfrująca URL
function decrypt_url($encrypted_url, $key) {
    $parts = explode('::', base64_decode($encrypted_url));
    if (count($parts) === 2) {
        $encrypted_data = $parts[0];
        $iv = base64_decode($parts[1]);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    } else {
        return false;  // Błąd w formacie szyfrowania
    }
}

// Sprawdzamy, czy w URL-u jest zakodowany link
if (isset($_GET['url'])) {
    // Dekodowanie i deszyfrowanie URL-a, a następnie przekierowanie
    $encoded_url = $_GET['url'];
    $decoded_url = decrypt_url($encoded_url, $encryption_key);
    if ($decoded_url) {
        header("Location: $decoded_url");
        exit();
    } else {
        die("Błąd: nieprawidłowy format URL.");
    }
}

// Zakładamy, że $nazwa i $strona pochodzą z bazy danych lub innego źródła
$nazwa = htmlspecialchars($nazwa);
$strona = htmlspecialchars($strona);

// Zakodowanie (zaszyfrowanie) linku do osadzenia w iframe
$encoded_url = encrypt_url($strona, $encryption_key, $iv);
?>

<!-- Użyj lokalnego proxy -->
<div class="iframe-container">
    <!-- Osadzony iframe z zakodowanym URL-em -->
    <iframe id="myIframe" title="<?php echo $nazwa; ?>" src="?url=<?php echo urlencode($encoded_url); ?>" allowFullScreen></iframe>
</div>

<?php require_once("globalnav.php"); ?>
</body>
<script>
    // Skrypt do wstawienia aktualnej daty
    document.getElementById("currentDate").innerText = new Date().toLocaleDateString();
</script>
</html>
