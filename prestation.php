<?php
include "membre.php";


$num_dossier = $_SESSION['num_dossier'];

if(isset($_POST["prestation"])  && $_POST['prestation'] == 'Valider') {

if(isset($_POST["modele"]))      $modele=$_POST["modele"];
if(isset($_POST["N°S"]))      $N°S=$_POST["N°S"];
if(isset($_POST["N°S_socle"]))      $N°S_socle=$_POST["N°S_socle"];
if(isset($_POST["marque"]))      $marque=$_POST["marque"];

if(isset($_POST["type"]))      $type=$_POST["type"];
if(isset($_POST["prix"]))      $prix=$_POST["prix"];
if(isset($_POST["description"]))      $description=$_POST["description"];

try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

$objid = $bdd->query("SELECT appelant_id_appelant FROM dossier WHERE N°_dossier = '$num_dossier' ");
while ($donnee = $objid->fetch())
{
$idap = $donnee['appelant_id_appelant'];}

$sql1 = $bdd->query("INSERT INTO TPE(appelant_id_appelant,N°S,N°S_base,Modèle,Marque) VALUES ((SELECT id_appelant FROM appelant WHERE id_appelant = '$idap'),'$N°S','$N°S_socle','$modele','$marque')"); 
$idtpe = $bdd->lastInsertId();
$sql2 = $bdd->query("INSERT INTO Prestation(TPE_idTPE,Type,Prix,description) VALUES((SELECT idTPE FROM TPE WHERE idTPE ='$idtpe'),'$type','$prix','$description')");
$_SESSION['num_dossier'] = $num_dossier;
?>
<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">

<p> Prestation enregistrée </p>
<a href="prestation.php"> Nouvelle prestation pour dossier n° : <?php echo $_SESSION['num_dossier']; echo " de M./Mme   ";echo $_SESSION['Nom_appelant']; ?> </a> <br/><br/><br/>
<a href="consultation.php"> Consulter les prestations du dossier n° : <?php echo $_SESSION['num_dossier']; echo " de M./Mme   ";echo $_SESSION['Nom_appelant']; ?> </a> </div>
<?php
}
else {
?>

<div style="margin-bottom:300px;margin-right:50px;margin-left:250px;margin-top:0px">
 <p style="text-decoration:underline;"> Nouvelle prestation pour Dossier N°  <?php echo $_SESSION['num_dossier']; echo ";";echo "M./Mme ";echo $_SESSION['Nom_appelant']; echo "  "; echo $_SESSION['prenom']; ?></p>
 
<form method="post" action="prestation.php">
  <p> Renseigner le terminal concerné : </p>
  <p> Modèle :<input type="text" name="modele"> </p>
  <p> N° de série TPE : <input type="text" name="N°S"></p>
  <p> N° de série socle (optionnel) : <input type="text" name="N°S_socle"></p>
  <p> Marque (Ingenico/Verifone etc..) : <input type="text" name="marque"></p>
	<p>
       <label for="description"> Description de la panne constatée par l'appelant :</label><br />
       <textarea name="description" ></textarea>
   </p>
 <p> Type de prestation requise  : </p> <select name="type">
	<option>Type1</option>
	<option>Type2</option>
	<option>Type3</option>
	<option>Type4</option>
	<option>Type5</option>
	<option>Autre (préciser) : <input type="text" name="type"/></option>
	</select>
	
	<p> Prix € HT :</p> <input type="number" name="prix"/> <br/><br/>
 <input type="submit" name="prestation" value="Valider">
 
</form> 
 </div>
 <?php }
 ?>
