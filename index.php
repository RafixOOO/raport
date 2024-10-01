

<?php require('auth.php'); ?>
<!DOCTYPE html>
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
        <?php } ?>
<header>
    <h1>Raporty</h1>
    <div class="date">Data: <span id="currentDate"></span></div>
</header>

<script>
    // Skrypt do wstawienia aktualnej daty
    document.getElementById("currentDate").innerText = new Date().toLocaleDateString();
</script>
</div>
<?php require_once("globalhead.php"); ?>
<?php require_once("globalnav.php"); ?>
</body>
</html>

