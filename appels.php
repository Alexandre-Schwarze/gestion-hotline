
<?php
include "membre.php";
try{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

if(isset($_POST["appels"]) && $_POST["appels"] == "Valider"){
if(isset($_POST["nom_i"])) $nom_i = $_POST["nom_i"];
if(isset($_POST["nom_ap"])) $nom_ap = $_POST["nom_ap"];

if (empty($nom_i)){
$sqlnom_i = $bdd->query ("SElECT Nom FROM Interlocuteur");            
$row1 = $sqlnom_i->fetch();
$nom_i = $row1['Nom'];

}
else {
$sqlnom_i = $bdd->query ("SELECT Nom FROM Interlocuteur WHERE Nom = '$nom_i'");
$row1 = $sqlnom_i->fetch();
$nom_i = $row1['Nom'];
}
if (empty($nom_ap)){
$sqlnom_ap = $bdd->query ("SELECT id_appelant FROM appelant");
$row2 = $sqlnom_ap->fetch();
$nom_ap = $row2['id_appelant'];
}

else {
$sqlnom_ap = $bdd->query ("SELECT id_appelant FROM appelant WHERE Nom_appelant = '$nom_ap'");
$row2 = $sqlnom_ap->fetch();
$nom_ap = $row2['id_appelant'];

}

$sql = $bdd->query("SELECT N°_appel,date_appel,Nom_appelant FROM appel,appelant WHERE Interlocuteur_Nom = '$nom_i' AND id_appelant = '$nom_ap' AND appel_N°_appel = N°_appel ORDER BY date_appel");


?> <div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">
<p> appels reçus par <?php echo $nom_i; ?> </p>
<?php
while ($row = $sql->fetch())
{
?> <p> appel n° <?php echo $row['N°_appel']; ?> le <?php echo $row['date_appel'] ?>  de M./Mme <?php echo $row['Nom_appelant']; ?></p> <br/>
</div>
<?php
}
}
else{
?>
<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">
<form method="post" action="appels.php">
  <p> Rechercher tous les appels reçus par : </p><select name="nom_i">
 <?php $reponse = $bdd->query('SELECT Nom FROM Interlocuteur');
while ( $donnees = $reponse->fetch())
{?>
	<option value="<?php echo $donnees['Nom'];?>"><?php echo $donnees['Nom'];?></option>
<?php }
?>
	<option > Tous </option>
	</select>
<p> provenant de M./Mme : </p> <select name="nom_ap">
	<?php $reponse1 = $bdd->query("SELECT Nom_appelant FROM appelant");
while ( $donnees1 = $reponse1->fetch())
{?>
	<option value="<?php echo $donnees1['Nom_appelant'];?>"><?php echo $donnees1['Nom_appelant'];?></option>
<?php }
?>	
	<option> Tous </option>
	</select>
	</br> </br> 
<!-- 
Inclure
N°S, Modèle, TypeP,
	
	-->
 <input type="submit" name="appels" value="Valider">
</form> 
 </div>
<?php }
?>
