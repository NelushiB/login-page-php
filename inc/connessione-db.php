<?php
   // Costanti di connessione
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'root');
   define('DB_NAME', 'my_nelushibamunusinghe');

   // Apro la connessione al db
   $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   // Verifico che la connessione sia andata a buon fine
   if($mysqli->connect_errno) {
      echo 'Errore connessione DB: ' . $mysqli->connect_error;
   }