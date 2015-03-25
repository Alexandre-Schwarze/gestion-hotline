<?php


include "membre.php";

if(isset($_POST["dossier"])  && $_POST['dossier'] == 'Valider') {
if(isset($_POST["num_dossier"])) $num_dossier = $_POST["num_dossier"];
try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'Blacksamba2', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}


$req3 = "SELECT COUNT(*) FROM dossier WHERE N°_dossier = '$num_dossier'";
$row = $bdd->query($req3);
$verif_dossier = $row->fetch(PDO::FETCH_BOTH);


if ($verif_dossier[0] == 0) {

$num_dossier = rand(999,10000);
$_SESSION['num_dossier']=$num_dossier;

?>
<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px"><a href="newappel.php"> >>> Nouveau dossier <<< </div></a>
<?php


}


elseif ($verif_dossier[0] == 1){

try
{$bdd = new PDO('mysql:host=localhost:3309;dbname=hotline', 'root', 'Blacksamba2', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch(Exception $e){die('Erreur : '.$e->getMessage());}

$objid = $bdd->query("SELECT appelant_id_appelant FROM dossier WHERE N°_dossier = '$num_dossier' ");
while ($donnee = $objid->fetch())
{
$idap = $donnee['appelant_id_appelant'];}

$sqll="SELECT Nom_appelant FROM appelant WHERE id_appelant = '$idap' ";
$nomap = $bdd->query($sqll);
while ($donnees = $nomap->fetch())
{ 

$_SESSION['Nom_appelant'] = $donnees['Nom_appelant']; }
$_SESSION['num_dossier']=$num_dossier;
?> <div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">

<a href="prestation.php"> Nouvelle prestation pour dossier n° : <?php echo $_SESSION['num_dossier']; echo " de M./Mme   ";echo $_SESSION['Nom_appelant']; ?> </a> <br/><br/><br/>
<a href="consultation.php"> Consulter les prestations du dossier n° : <?php echo $_SESSION['num_dossier']; echo " de M./Mme   ";echo $_SESSION['Nom_appelant']; ?> </a> 

</div>

<?php
}
}

else{ ?>
<div style="position:absolute;text-align:center;margin-bottom:300px;margin-left:100px;margin-top:-200px">


<form method="post" action="choixdossier.php">
 
 <p>  N° de dossier : </p> <input type="text" name="num_dossier">
 <input type="submit" name="dossier" value="Valider">
 
</form>
</div>
<?php 
}
?>
