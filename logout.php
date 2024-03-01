<?php
// Attivare la sessione
session_start();

// Distruggere la sessione
session_destroy();

// Eliminare il cookie di log
setcookie('log', '', time()-1);

// Reindirizzare alla pagina di login
header('location: index.php');