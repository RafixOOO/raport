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
}?>
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
            
            <table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">Nazwa</th>
      <th scope="col">Link</th>
      <th scope="col">Zarządzaj</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
    
        $sql = "SELECT rs.sitesID ,rs.strona, rs.nazwa 
FROM raportSites rs";
        $stmt = sqlsrv_query($conn, $sql);
        while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {           
    ?>
    <tr>
        <td><?php echo $data['nazwa'] ?></td>
        <td><?php echo $data['strona'] ?></td>
        <td>
    <input type="hidden" name="person_id" value="<?php echo $data['sitesID'] ?>">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal" 
                onclick="editSite('<?php echo $data['nazwa'] ?>', '<?php echo $data['strona'] ?>', '<?php echo $data['sitesID'] ?>')">
            Edytuj
        </button>
            <form method="post" action="usun_strone.php" style="float: left; margin-right:2%;">
                <input type="hidden" name="person_id" value="<?php echo $data['sitesID'] ?>">
                <button type="submit" name="usun_konto" class="btn btn-danger">Usuń</button>
            </form>
        </td>
    </tr>
    
    <?php } ?>
  </tbody>
  <tfoot>
  <form method="post" action="dodaj_strone.php" style="float: left; margin-left:2%;">
    <tr>
      <td>
      <div style="width: 100%; padding: 10px;">
    <input type="text" name="nazwa" placeholder="Nazwa..." style="width: 100%;"  required/>
</div>
      </td>
      <td>
      <div style="width: 100%; padding: 10px;">
    <input type="text" name="link" placeholder="Link..." style="width: 100%;" required/>
</div>
      </td>
      <td>
      
                <button type="submit" name="dodaj_konto" class="btn btn-success">Dodaj</button>
            
      </td>
    </tr>
    </form>
  </tfoot>
</table>
</div>
        </div>
</div>
</div>
</div>
<!-- Modal Bootstrap -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edytuj stronę</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" method="post" action="update_strone.php">
          <input type="hidden" name="sitesID" id="edit-site-id">

          <div class="mb-3">
            <label for="edit-nazwa" class="form-label">Nazwa</label>
            <input type="text" class="form-control" id="edit-nazwa" name="nazwa" required>
          </div>

          <div class="mb-3">
            <label for="edit-strona" class="form-label">Strona</label>
            <input type="text" class="form-control" id="edit-strona" name="strona" required>
          </div>

          <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once("globalnav.php"); ?>
</body>
<script>
  function editSite(nazwa, strona, id) {
    // Wypełnij pola modal danymi z wiersza
    document.getElementById('edit-nazwa').value = nazwa;
    document.getElementById('edit-strona').value = strona;
    document.getElementById('edit-site-id').value = id;
  }
</script>
</html>