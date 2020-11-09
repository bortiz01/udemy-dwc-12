<?php
  // obtener todos los contactos
  function getContacts() {
    include 'db_connection.php';

    try {
      return $conn->query("SELECT * FROM contact");
    }catch(Exception $e) {
      echo 'Error!!' . $e->gerMessage() . '<br>';
      return false;
    }
  };

  // obtener los datos del contacto
  function getContact($id) {
    include 'db_connection.php';

    try {
      return $conn->query("SELECT * FROM contact WHERE id_contact =  $id");
    }catch(Exception $e) {
      echo 'Error!!' . $e->gerMessage() . '<br>';
      return false;
    }
  };
?>