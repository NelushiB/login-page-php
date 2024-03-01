<?php
// Attivare la sessione
session_start();

// Aprire la connessione al DB
include('inc/connessione-db.php')
?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta name="author" content="Nelushi Bamunusinghe">
   <title>Login Page</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.png">
</head>
<body>
   <div class="content">
      <div class="box">
         <?php 
         // Controlla se l'utente è loggato
         if (isset($_SESSION['log']) && $_SESSION['log'] == true && isset($_SESSION['id_utente'])) {
            $id_utente = $_SESSION['id_utente'];

            // Prepara la query per ottenere il nome e il cognome
            $sql = "SELECT nome, cognome FROM utenti WHERE id_utente = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id_utente);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se la query ha restituito risultati
            if ($result->num_rows > 0) {
               $row = $result->fetch_assoc();
               $nome = $row['nome'];
               $cognome = $row['cognome'];

               // Ora puoi utilizzare $nome e $cognome come desideri
            } else {
               // Utente non trovato nel database
               echo '<div class="alert alert-danger">Utente non trovato nel database</div>';
            }
         } else {
            // L'utente non è loggato, reindirizza alla pagina di login
            header("Location: login.php");
            exit();
         }

         ?>
         <div class="form">
            <div class="card center">
               <h1 class="center">Bentornato/a <?php echo $nome . ' ' . $cognome; ?>!</h1>
               <p>Hai effettuato l'accesso con successo!!</p>
               <img src="img/minions.gif" alt="minions">
               <a href="logout.php">Fai logout</a>
            </div>  
         </div> <!--end form-->
      </div> <!--end box-->
   </div> <!---end content-->
</body>
</html>

<?php $mysqli->close(); ?>