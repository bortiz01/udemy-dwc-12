<div class="fields">
  <div class="field">
    <label for="nombre">Nombre:</label>
    <input 
      type="text" 
      placeholder="Nombre contacto" 
      id="nombre"
      value="<?php echo (isset($contact['name'])) ? $contact['name'] : '';?>"
    >
  </div>
  <div class="field">
    <label for="empresa">Empresa:</label>
    <input 
      type="text" 
      placeholder="Nombre Empresa" 
      id="empresa"
      value="<?php echo (isset($contact['enterprise'])) ? $contact['enterprise'] : ''; ?>"
    >
  </div>
  <div class="field">
    <label for="Telefono">Teléfono:</label>
    <input 
      type="text" 
      placeholder="Telefono contacto" 
      id="telefono"
      value="<?php echo (isset($contact['tel'])) ? $contact['tel'] : ''; ?>"
    >
  </div>
</div>

<div class="field send">
  <?php
    $btnText = (isset($contact['name'])) ? 'Actualizar' : 'Añadir';
    $accion = (isset($contact['name'])) ? 'editar' : 'crear';
  ?>

  <input type="hidden" id="accion" value="<?php echo $accion; ?>">
  <input type="submit" value="<?php echo $btnText; ?>">
  
  <?php if (isset($contact['id_contact'])) { ?>
    <input type="hidden" id="id" value="<?php echo $contact['id_contact']; ?>">
  <?php }; ?>
</div>