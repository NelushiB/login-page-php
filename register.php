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
   <title>Register Page</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.png">
</head>
<body>
   <div class="content">
      <div class="container">
         <div class="login-box">
            <div class="col-6 background register"></div>
            <div class="col-6">
               <div class="form">
                  <div class="text center">
                     <h1 class="center">Crea un nuovo account</h1>
                  </div>
                  <?php
                     if(isset($_POST['invia'])) :
                        //Recupero i dati del form
                        $nome = strip_tags($_POST['nome']);
                        $cognome = strip_tags($_POST['cognome']);
                        $username = strip_tags($_POST['user']);
                        $email = strip_tags($_POST['email']);
                        $password = $_POST['new_password'];
                        $conferma_password = $_POST['conferma_password'];

                        // Verifico che tutti i campi siano compilati 
                        if ($nome == '' || $cognome == '' || $username == '' || 
                           $email == '' || $password == '') {
                              echo '<div class="alert alert-danger">Devi compilare tutti i campi.</div>';
                        
                        // Verifico che la password sia uguale alla conferma password
                        } elseif ($password != $conferma_password) {
                           echo '<div class="alert alert-danger">Le due password devono coincidere.</div>';
                        
                        // Verifico che l'email e l'utenza esistono già
                        } else {
                           
                           // Verifico se l'email inserito è valido
                           if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                              echo '<div class="alert alert-danger">Email inserito non valido.</div>';
                           } else {
                              $password = md5($password);
                              
                              $sql_user_email = "SELECT * FROM utenti WHERE utente = ? OR email= ?";
                              
                              $stmt = $mysqli->prepare($sql_user_email);
                              $stmt->bind_param("ss", $username, $email);
                              $stmt->execute();
                              $res_user_email = $stmt->get_result();

                              if($res_user_email->num_rows > 0) {
                                 echo '<div class="alert alert-danger">Username/email già utilizzato. Riprova con un altro</div>';
                              } else {
                                 $sql = "INSERT INTO utenti (nome, cognome, utente, password, email) VALUES ('$nome', '$cognome', '$username', '$password', '$email')";

                                 $res = $mysqli->query($sql);

                                 if($res) {
                           ?>

                           <div class="alert alert-success">Utente creato con successo</div>
                              <script>
                                 setTimeout(function() {
                                    location.href = 'login.php';
                                 }, 3000);
                              </script> 

                           <?php

                           } else {
                              echo '<div class="alert alert-danger">Errore eliminazione: ' . $mysqli->error . '</div>';
                           }
                        }  
                        }
                     }
                     endif;
                  ?>
                  <form action="#" method="post">
                     <div class="form-group">
                        <div class="name">
                           <input type="text" name="nome" placeholder="Nome">
                           <input type="text" name="cognome" placeholder="Cognome">
                        </div>
                        <input type="text" name="user" placeholder="Username">
                        <input type="email" name="email" placeholder="Email">
                        <div class="password">
                           <input type="password" name="new_password" placeholder="Password">
                           <input type="password" name="conferma_password" placeholder="Conferma Password">
                        </div>
                        <input type="submit" name="invia" value="Registrati" >
                     </div>
                  </form>
                  <div class="links center">
                     <a href="forgot-password.php">Hai dimenticato la password?</a>
                     <a href="index.php">Hai già un account? Effettua il login</a>
                  </div> <!--end links-->
               </div> <!--end form-->
            </div> <!--end col-6-->
         </div> <!--end login-box-->
      </div> <!--end container-->
   </div> <!---End content-->
</body>
</html>

<?php $mysqli->close(); ?>