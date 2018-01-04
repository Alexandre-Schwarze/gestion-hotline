<?php
ob_start();
// test formulaire de connexion 
if (isset($_POST['connexion'])  && $_POST['connexion'] == 'Connexion'){
if ((isset($_POST['interlocuteur']) && !empty($_POST['interlocuteur'])) AND (isset($_POST['password']) && !empty($_POST['password']))) {
$Nom_interlocuteur = $_POST["interlocuteur"];
$password = $_POST["password"];

// connexion serveur/bdd
try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}


// test entrée de la base 
$sql = "SELECT COUNT(*) FROM hotline.interlocuteur WHERE Nom='$Nom_interlocuteur' AND password='$password'";
$row = $bdd->query($sql);
$data = $row->fetch(PDO::FETCH_BOTH);



if ($data[0] == 1) {
session_start();
$_SESSION['Nom_interlocuteur'] = $Nom_interlocuteur;
header('Location: membre.php');
ob_end_flush();
exit();
}

elseif($data[0] == 0) {
echo "Mauvais nom ou mot de passe, réessayez";
}
else { 
echo "un des champs est vide ";
}
}
}
error_reporting();
ob_end_flush();
?>
