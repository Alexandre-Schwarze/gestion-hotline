<?php 

include "membre.php";

try{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

$req1 = $bdd>query("SELECT *");

if(isset($_POST["categorie"])  && $_POST['categorie'] == 'Valider') {

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Suivi des appels</title>
</head>
<body>
<form method="post" action="choix.php">
<p> tous les appels par  <p> <select name="categorie" id="choix" tabindex="4" >
<option  value="N°_appel"> N° d'appel </option>
<option value="Nom_appelant"> Nom d'appelant </option>
<option value="téléphone"> N° de téléphone </option>
</select>
<input type="submit" name="categorie" value="Valider"/>

</form>
</body>
</html> 
