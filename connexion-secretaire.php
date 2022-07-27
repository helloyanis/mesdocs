<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("bdd.php");
if(isset($_POST["email"]))
    { 
      //Vérification de l'e-mail saisie
      $email = $_POST["email"];
      $req = "SELECT * FROM secretariat WHERE Email LIKE '$email'";;
      $Ores = $Bdd->query($req);   
      if($usr = $Ores->fetch())
      {
        // L'email saisie est inscrit en BDD et correspond bien à un user
        if(isset($_POST["mdp"]))
        {
          //Vérifier si le mot de passe saisie correspond bien au mot de passe de l'user
          $req1 = "SELECT * FROM secretariat WHERE email LIKE '$email' AND mdp LIKE '".md5($_POST["mdp"])."';";;
          $Ores1 = $Bdd->query($req1);
		  
          if($usr = $Ores1->fetch())
          {
            // Le mdp saisie est correct et correspond bien à l'email de l'user
			$_SESSION['id']=$usr->id;
      $_SESSION['userType']=$usr->userType;
      header('Location: moncompte-secretaire.php');

            exit;        
          }
          else
          {
            // Le mdp saisi est incorrect et ne correspond pas à l'email de l'user
            echo '<script language="Javascript"> alert ("Vous êtes bien enregistré mais le mot de passe est incorrect !" ) </script>';
          }      
        }
      }
      else
      {
        // L'email saisie n'est pas inscrit en BDD et correspond à aucun user
        echo '<script language="Javascript"> alert ("L\'identifiant saisi est incorrect ! Veuillez réessayer !" ) </script>';
      }
    }
    if(isset($_SESSION["id"])){
      switch ($_SESSION["userType"]){
        case 1:
          return header('Location: moncompte-docteur.php');
          break;
        case 2:
          return header('Location: moncompte-secretaire.php');
          break;
        case 3:
          return header('Location: moncompte-patient.php');
          break;
      }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="page-compte.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet"> 
</head>
<body>
<header class="navbar">
      <h2 class="logo">MesDocs</h2>
      <div></div>
      <div>
        <!--
      <a href="truc" class="notif primary switchuser">🔔 Notifications</a>
  -->
      <a class="primary switchuser" href="<?php
      if(!isset($_SESSION['id'])){
        echo "connexion-patient.php";
        
      }else{
        echo "moncompte-patient.php";
      }
      ?>">
      <?php
      if(!isset($_SESSION['id'])){
        echo "Se connecter";
        
      }else{
        echo "Mon compte";
      }
      ?>
    </a>
    </div>
      

</header>
    <div class="contbox">
      <h1>Connectez-vous à votre compte secrétaire</h1>
        <form action="" method="POST">
            <input type="email" placeholder="E-mail" name="email" required><br>
            <input type="password" placeholder="Mot de passe" name="mdp" required><br>
            <input type="submit">
        </form>
    </div>
    <div class="contbox">
    <h3>Pour s'inscrire, demandez au personnel.<h3><br>
    <div class="flexline">
    <a href="connexion-patient.php" class="primary switchuser">Vous êtes un patient?</a><br>
    <a href="connexion-docteur.php"class="primary switchuser">Vous êtes un docteur?</a><br>
    </div>
  </div>

</body>
</html>