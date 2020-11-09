<!DOCTYPE html>
<html lang="en">
  <!-- header -->
  <?php include_once 'includes\layout\head.php'; ?>  
  <?php include_once 'includes\functions\functions.php'; ?>

  <!-- body -->
  <body>

    <?php
      $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
      // print_r($_GET); 
      if (!$id) {
        die('No es valido');
      }

      $response = getContact($id);
      $contact = $response->fetch_assoc();

      // print_r($contact);

    ?>

    <div class="container-bar">
      <div class="container bar">
        <a href="index.php" class="btn btn-back">Volver</a>
        <h1>Editar contacto</h1>
      </div>      
    </div>

    <div class="bg-yellow container shadow">
      <form action="#" id="contact">
        <legend>Edite un contacto</legend>
        
        <?php require_once('includes\layout\contact_form.php'); ?>
      </form>
    </div>

  </body>
  
  <!-- footer -->
  <?php include_once 'includes\layout\scripts.php'; ?>
</html>