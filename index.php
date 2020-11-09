<!DOCTYPE html>
<html lang="en">
  <!-- header -->
  <?php include_once 'includes\layout\head.php'; ?>  
  <?php include_once 'includes\functions\functions.php'; ?>

  <!-- body -->
  <body>
    <div class="container-bar">
      <h1>Agenda de contactos</h1>
    </div>
  
    <div class="bg-yellow container shadow">
      <form action="#" id="contact">
        <legend>Añada un contacto <span>Todos los campos son obligatorios</span></legend>        
        
        <?php require_once('includes\layout\contact_form.php'); ?>              
      </form>
    </div>  

    <div class="bg-white container shadow contacts">      
      <div class="container-contacts">
        <h2>Contactos</h2>

        <input type="text" id="search" class="search shadow" placeholder="Buscar contactos...">
        <p class="total-contacts"><span></span> Contactos</p>

        <div class="container-table">
          <table id="list-contacts" class="list-contacts">
            <thead>            
              <tr>
                <th>Nombre</th>
                <th>Empresa</th>
                <th>Telefono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            
            <tbody>              
              <?php $contacts = getContacts(); ?>
              <?php if ($contacts->num_rows) { ?>                
                <?php foreach($contacts as $contact) { ?>
                  <tr>
                    <td><?php echo $contact['name'];?></td>
                    <td><?php echo $contact['enterprise'];?></td>
                    <td><?php echo $contact['tel'];?></td>
                    <td>                  
                      <a class="btn btn-edit" href="edit.php?id=<?php echo $contact['id_contact'];?>" title="Editar">
                        <i class="fas fa-pen-square"></i>
                      </a>
                      
                      <button data-id=<?php echo $contact['id_contact'];?> type="button" class="btn btn-delete" title="Borrar">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>   
                <?php }; ?>
              <?php }; ?>           
            </tbody>
          </table>
        </div>
      
      </div>
    </div>
  </body>

  <!-- footer -->
  <?php include_once 'includes\layout\scripts.php'; ?>
</html>