<?php
include('inc/connessione-db.php');
?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta name="author" content="Nelushi Bamunusinghe">
   <title>Forgot Password</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.png">
</head>
<body>
   <div class="content">
      <div class="container">
         <div class="login-box">
            <div class="col-6 background forgot"></div>
            <div class="col-6">
               <div class="form">
                  <div class="text center">
                     <h1 class="center">Password dimenticata?</h1>
                     <p>Inserisci la tua email con cui ti sei registrato e ti invieremo un link per reimpostare una nuova password</p>
                  </div>
                  <?php
                     if(isset($_POST['invia'])) {
                     $email = $_POST['email'];

                     // Verifico che l'email sia presente nel DB
                     $sql = "SELECT * FROM utenti WHERE email=?";
                     
                     $stmt = $mysqli->prepare($sql);
                     $stmt->bind_param('s', $email);
                     $stmt->execute();
                     $res = $stmt->get_result();
                     if($res && $row = $res->fetch_assoc()) {
                        $id_utente = $row['id_utente'];
                        $uniqid = uniqid();
                        setcookie('uniqid', $uniqid, time()+1800);
                        $link_reset = "http://localhost/esercizi_personali/login_page/reset-password.php?id=$id_utente&uniqid=$uniqid";
                        
                        // Visualizza il link direttamente nel markup HTML
                        echo '<div class="alert alert-success">Link di reset: <a href="' . $link_reset . '">' . $link_reset . '</a></div>';
                     } else {
                        echo '<div class="alert alert-danger">Non risulta alcuna registrazione con email indicata</div>';
                     }
                  }
                  ?>
                  <form action="#" method="post" class="divider">
                     <div class="form-group">
                        <input type="email" name="email" placeholder="Inserisci la tua email">
                        <input type="submit" name="invia" value="Invia" >
                     </div>
                  </form>
                  <div class="links center">
                     <a href="index.php">Hai già un account? Effettua il login</a>
                     <a href="register.php">Crea un nuovo account</a>
                  </div> <!--end links-->
               </div> <!--end form-->
            </div> <!--end col-6-->
         </div> <!--end login-box-->
      </div> <!--end container-->
   </div> <!---End content-->
</body>
</html>

<?php $mysqli->close(); ?>