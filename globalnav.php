<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="assets/css/plugins.min.css"/>
<link rel="stylesheet" href="assets/css/kaiadmin.min.css"/>
<script src="assets/js/plugin/webfont/webfont.min.js"></script>
<script>
  WebFont.load({
    google: { families: ["Public Sans:300,400,500,600,700"] },
    custom: {
      families: [
        "Font Awesome 5 Solid",
        "Font Awesome 5 Regular",
        "Font Awesome 5 Brands",
        "simple-line-icons",
      ],
      urls: ["assets/css/fonts.min.css"],
    },
    active: function () {
      sessionStorage.fonts = true;
    },
  });
</script>
<?php if(isSidebar()==0){ ?>
<div class="wrapper" style="padding-bottom: 0; width:0; height:0;">
  <?php }else if(isSidebar()==1){ ?>
    <div class="wrapper sidebar_minimize" style="padding-bottom: 0; width:0; height:0;">
      <?php } ?>
  <!-- Sidebar -->
  <div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
      
        <a href="#" class="logo" style="position: relative;
      display: inline-block;";>
        <img
            src="assets/img/logo.svg"
            alt="navbar brand"
            class="navbar-brand"
            height="90"
            width="220"
          />
          <div style="position: absolute;
      top: 20%;
      left: 20%;
      transform: translate(-20%, -520%);
      width: 20%;  /* Szerokość klikalnego obszaru (np. 50% szerokości obrazka) */
      height: 20%; /* Wysokość klikalnego obszaru (np. 50% wysokości obrazka) */
      cursor: pointer;"></div>
        </a>
        <button class="btn btn-toggle toggle-sidebar" style="top: 1.04%;
      left: 0.094%; position:fixed;width:140%;">
							<i class="gg-menu-right"></i>
						</button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Profil</h4>
          </li>
          <?php if(!isLoggedIn()) { ?>
          <li class="nav-item">
            <a href="login.php">
              <i class="fa fa-user"></i>
              <p>Zaloguj się</p>
            </a>
          </li>
          <?php } ?>
          <?php if(isLoggedIn()) { ?>
          <li class="nav-item">
            <a href="logout.php">
              <i class="fa fa-user"></i>
              <p><?php echo $_SESSION['username']; ?> (Wyloguj się)</p>
            </a>
          </li>
          <?php } ?>
            <?php if(isUserAdmin()){ ?>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#settings">
              <i class="fa fa-cogs"></i>
              <p>ustawienia</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="settings">
              <ul class="nav nav-collapse">
                <li>
                  <a href="strony.php">
                    <span class="sub-item" >Zarządzaj stronami</span>
                  </a>
                </li>
                <li>
                  <a href="zarzadzaj.php">
                    <span class="sub-item" >Panel Administratora</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <?php } ?>
        </ul>
        <ul class="nav nav-secondary">
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Aplikacje</h4>
          </li>
          <?php
          require_once("dbconnect.php");
            $id=isIdent();
          $sql="SELECT rs.nazwa, rs.strona, rs.sitesID 
FROM PartCheck.dbo.raportPermission rp
INNER JOIN PartCheck.dbo.raportSites rs on rs.sitesID = rp.sitesID
where rp.userID=$id and rp.permissionBool=1 ;";

$stmt = sqlsrv_query($conn, $sql);

// Sprawdzenie, czy zapytanie zostało poprawnie wykonane
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  echo '<li class="nav-item">
<a href="raport.php?ID='.$row['sitesID'].'">
  <i class="fas fa-table"></i>
  <p>'.$row['nazwa'] .'</p>
</a>
</li>';
}

?>
              </ul>
              
            </div>
            </li>
            <!--<li class="nav-item">
            <a href="cutlogic/main.php">
              <i class="fa fa-laptop"></i>
              <p>Cutlogic (W Rozbudowie)</p>
            </a>
          </li>-->
          
        </ul>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $(".btn-toggle").click(function(){
      $.ajax({
        url: "sidebar.php", // Ścieżka do pliku PHP
        type: "POST", // Wysyłamy żądanie POST
        data: { status: "nowyStatus" }, // Możesz przekazać dowolne dane, np. status
        success: function(response){
          // Pokaż komunikat o sukcesie
          location.reload();
          $("#status-message").html("<p>Status został zaktualizowany pomyślnie.</p>");
        },
        error: function(xhr, status, error){
          // Pokaż komunikat o błędzie
          $("#status-message").html("<p>Wystąpił błąd: " + error + "</p>");
        }
      });
    });
  });
</script>
<!-- End Sidebar -->
<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- jQuery Sparkline -->
<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>


<!-- Kaiadmin JS -->
<script src="assets/js/kaiadmin.min.js"></script>