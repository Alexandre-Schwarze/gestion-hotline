<?php 

include "membre.php";

$num_appel = rand(1000, 99999);

if(isset($_POST["nouvelappel"]) && $_POST["nouvelappel"] == "OK"){
if(isset($_POST["adresse"]))      $adresse=$_POST["adresse"];
if(isset($_POST["Nom_appelant"]))      $Nom_appelant=$_POST["Nom_appelant"];
if(isset($_POST["prenom"]))      $prenom=$_POST["prenom"];
if(isset($_POST["email"]))      $email=$_POST["email"];
if(isset($_POST["téléphone"]))      $téléphone= $_POST["téléphone"];
else{$téléphone=111;}
if(isset($_POST["revendeur"]))      $revendeur=$_POST["revendeur"];
if(isset($_POST["société"]))      $société=$_POST["société"];

try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'Blacksamba2', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

$num_dossier=$_SESSION['num_dossier'];
$Nom_interlocuteur = $_SESSION['Nom_interlocuteur'];
$sql = $bdd->query("INSERT INTO appel(Interlocuteur_Nom,N°_appel) VALUES ('$Nom_interlocuteur','$num_appel')");
$sql2 = $bdd->query("INSERT INTO appelant(appel_N°_appel,Nom_appelant,prenom,téléphone,email,adresse,société,revendeur) VALUES ('$num_appel','$Nom_appelant','$prenom','$téléphone','$email','$adresse','$société','$revendeur')");
$id_appelant = $bdd->lastInsertId();
$sql3 = $bdd->query("INSERT INTO dossier(N°_dossier,appelant_id_appelant) VALUES ('$num_dossier',(SELECT id_appelant FROM appelant WHERE id_appelant = '$id_appelant'))");
$_SESSION['Nom_appelant'] = $Nom_appelant;
$_SESSION['prenom'] = $prenom;
?> <div style="position:absolute;text-align:center;margin-bottom:400px;margin-left:100px;margin-top:-300px">

<a href="prestation.php"> Nouvelle prestation </a> <br/><br/><br/>
<a href="consultation.php"> Consulter prestations </a>

</div>


<?php
}



else { 
?>


<div style="position:absolute;text-align:center;margin-bottom:400px;margin-left:100px;margin-top:-300px">


<form method="post" action="newappel.php">
 <p> Dossier n° :  <?php echo $_SESSION['num_dossier']; ?></p> 
 <p>  nom de l'appelant :  </p>
 <input type="text" name="Nom_appelant"/> 

<p> prénom : </p> <input type="text" name="prenom" />
 <p> numéro de téléphone (Obligatoire, du type  0143345445) : </p> <input type="text" name="téléphone" size="20%"> 
 <p> email : </p> <input type="email" name="email" size="25%"> 
 <p> adresse : </p> <input type="text" name="adresse" size="40%">
 <p> société : </p> <input type="text" name="société" size="20%">
 <p> revendeur : </p>  <input type="text" name="revendeur"/> </br></br>
 <input type="submit" name="nouvelappel" value="OK"> </br></br></br></br>
</form>
</div>
<?php 
} 

?>