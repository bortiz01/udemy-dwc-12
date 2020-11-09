<?php
  error_reporting(0); // Turn off all error reporting
  
  // credenciales de la base de datos
  define('DB_USER', 'agendaphp');
  define('DB_PASSWORD', 'agenda123');
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'agendaphp');
  define('DB_PORT', '3306'); //opcional

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

  // verificar si la conexion es exitosa
  // echo $conn->ping();
?>