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
      <div class="container">
         <div class="login-box">
            <div class="col-6 background login"></div>
            <div class="col-6">
               <div class="form">
                  <div class="text center">
                     <h1 class="center">Bentornato!</h1>
                     <p>Inserisci le tue credenziali di accesso</p>
                  </div>
                  <?php
                  // Verifico se il form di login è stato inviato
                  if(isset($_POST['invia'])) {
                     //Recupero i dati del form
                     $user = $_POST['user'];
                     $password = md5($_POST['password']);
                     $ricordami = isset($_POST['ricordami']) ? $_POST['ricordami'] : '';
                     
                     // Prepared statement
                     $sql = "SELECT * FROM utenti WHERE utente=? AND password=?";

                     // Creo oggetto Prepare statement 
                     $stmt = $mysqli->prepare($sql);

                     // Inserisco i valori al posto di ? indicando il tipo di dato accettato
                     $stmt->bind_param('ss', $user, $password);

                     // Eseguo la query
                     $stmt->execute();

                     // Recupero il risultato della query
                     $res = $stmt->get_result();

                     if($res && $row = $res->fetch_assoc()) {
                        $_SESSION['log'] = true;
                        $_SESSION['id_utente'] = $row['id_utente'];
                        $_SESSION['nome'] = $row['nome'];
                        $_SESSION['cognome'] = $row['cognome'];

                        // Controllo se ha deciso di ricordare la login
                        if($ricordami == 'on') {
                           // Creo un cookie della durata di una settimana
                           setcookie('log', $row['id_utente'], time()+604800);
                        }
                     } else {
                        // Credenziali errate
                        $_SESSION['log'] = false;
                        echo '<div class="alert alert-danger">Username e/o password errati</div>';
                     }
                  }
                  ?> 

                  <?php if(isset($_SESSION['log']) && $_SESSION['log']=='true'): ?>
                     <div class="text-center">
                        <div class="alert alert-success">Accesso effettuato con successo</div>
                        <p>Tra pochi secondi sarai reindirizzato alla dashboard</p>
                        <script>
                        setTimeout(function() {
                           location.href = 'login.php';
                        }, 3000);
                        </script>
                     </div>
                  <?php else: ?>
                  <form action="#" method="post" class="divider">
                     <div class="form-group">
                        <input type="text" name="user" placeholder="Username">
                        <input type="password" name="password" placeholder="Password">
                        <div class="remember">
                        <input type="checkbox" name="remember" id=""><label>Ricordami</label>
                        </div>
                        <input type="submit" name="invia" value="Accedi" >
                     </div>
                  </form>
                  <div class="links center">
                     <a href="forgot-password.php">Hai dimenticato la password?</a>
                     <a href="register.php">Crea un nuovo account</a>
                  </div> <!--end links-->
               </div> <!--end form-->

               <?php endif; ?>
            </div> <!--end col-6-->
         </div> <!--end login-box-->
      </div> <!--end container-->
   </div> <!---End content-->
</body>
</html>

<?php $mysqli->close(); ?>