<?php


include "membre.php";

// connexion serveur/bdd
try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'Blacksamba2', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

if((isset($_POST["choixdossier"])) && $_POST["choixdossier"] == "Valider"){
if(isset($_POST["num_dossier"])) $num_dossier= $_POST["num_dossier"];
$sql = $bdd->query("SELECT N°_dossier,Nom_appelant,prenom,téléphone,Modèle,N°S,N°S_base,idPrestation,description,Type,Prix,Terminée FROM dossier,appelant,TPE,Prestation WHERE N°_dossier='$num_dossier' AND TPE.appelant_id_appelant = id_appelant AND dossier.appelant_id_appelant = id_appelant AND Terminée = 0 AND Prestation.TPE_idTPE = TPE.idTPE");

if(isset($_POST["actionpresta"]) && $_POST["actionpresta"] == "Terminer"){
if(isset($_POST['idpresta'])) $idpresta=$_POST['idpresta'];
$sql2 = $bdd->query("UPDATE Prestation SET Terminée = 1 WHERE idPrestation = '$idpresta'");
echo " La prestation a bien été effectuée/terminée "; 

}
else{
?>
<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">
<table style="border: 3px solid black">
<tr style="position:relative;bottom:100px;left:0px;top:600px"> <td> Dossier</td><td>Appelant </br>Numéro</td><td>terminal</td><td>N°de série TPE</td><td>N° de série base</td><td>Type Prestation</td><td>Prix</td><td>Description</td></tr>
<?php while ( $data = $sql->fetch()) { ?>
<tr style="position:relative;bottom:50pxleft:-1px;top:700px"><?php $idpres = $data['idPrestation'];?><td><?php echo $data['N°_dossier'];?></td><td>M./Mme <?php echo $data['Nom_appelant'];echo " ";echo $data['prenom'];?></br><?php echo $data['téléphone'];?></td><td><?php echo $data['Modèle'];?></td><td><?php echo $data['N°S'];?></td><td><?php echo $data['N°S_base'];?></td><<td><?php echo $data['Type'];?></td><td><?php echo $data['Prix'];?></td><td><?php echo $data['description'];?></td><td><form method="post" action="consultation.php"><input type="hidden" name="idpresta" value="<?phpecho $idpres;?>"/><input type="submit" name="actionpresta" value="Terminer"/></form></td></tr>

<?php } ?>
</table>
</div>
<?php

}
}
else
{
?>


<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">

<form method="post" action="consultation.php">
<p> Sélectionner le dossier : </p><select name="num_dossier">
 <?php $reponse = $bdd->query("SELECT N°_dossier,Nom_appelant FROM dossier,appelant WHERE appelant_id_appelant = id_appelant AND dossier.Validé = 0");
while ( $donnees = $reponse->fetch())
{?>
	<option value="<?php echo $donnees['N°_dossier'];?>"><?php echo $donnees['Nom_appelant']; echo " dossier n° ";echo $donnees['N°_dossier']?></option>
<?php }
?>
</select> </br></br>
<input type="submit" name="choixdossier" value="Valider">
</form>
</div>

<?php 
}
 ?>