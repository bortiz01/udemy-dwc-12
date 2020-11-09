<?php
/* ---------------------------------- POST ---------------------------------- */
  // creara un nuevo registro en la base de datos
  if(isset($_POST['accion'])){
    if ($_POST['accion'] == 'crear') {
      // abrir conexion
      require_once '../functions/db_connection.php';
      
      // sanitizar las entradas
      $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
      $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
      $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);

      try {
        $stmt = $conn->prepare(
            "INSERT INTO contact (name, enterprise, tel) VALUE (?, ?, ?)"
        );
        $stmt->bind_param("sss", $nombre, $empresa, $telefono);
        $stmt->execute();
        
        $response = [
            'response' => 'success',
            'info' => $stmt->affected_rows,            
            'data' => [
              'id' => $stmt->insert_id,
              'nombre' => $nombre,
              'empresa' => $empresa,
              'telefono' => $telefono,
            ]
        ];

        $stmt->close();
        $conn->close();
      } catch (Exception $e) {
        $response = [
            'error' => $e->getMessage(),
        ];
      };

      echo json_encode($response);
    };
  };

/* ----------------------------------- GET ---------------------------------- */
  if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'borrar') {
      // abrir conexion
      require_once '../functions/db_connection.php';
  
      // sanitizar las entradas
      $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

      try {
        $stmt = $conn->prepare('DELETE FROM contact WHERE id_contact = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
          $response = [
            'response' => 'success'
          ];
        };

        $stmt->close();
        $conn->close();
      }catch(Exception $e) {
        $response = [
          'error' => $e->getMessage()
        ];
      };
    
    echo json_encode($response);
    };
  };

  if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'editar') {
      // abrir conexion
      require_once '../functions/db_connection.php';
      
      // sanitizar las entradas
      $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
      $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
      $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
      $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

      try {
        $stmt = $conn->prepare("UPDATE contact SET name = ?, enterprise = ?, tel = ? WHERE id_contact = ?");
        $stmt->bind_param('sssi', $nombre, $empresa, $telefono, $id);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
          $response = [
            'response' => 'success'
          ];
        } else {
          $response = [
            'response' => 'error'
          ];
        };

        $stmt->close();
        $conn->close();
      }catch(Exception $e){
        $response = [
          'error' => $e->getMessage()
        ];
      };
    
      echo json_encode($response);
    };
  };  
?>