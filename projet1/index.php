<?php
	// Initialiser la session
	session_start();
try{
	$conn = new PDO("mysql:host=localhost;dbname=form;", "root", "");
}
catch(PDOException $e) {
	die("Erreur : " .$e->getMessage());
}
	
	
	// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
	$day=date("d-m-Y");
	if(isset($_POST["matin"])){
		$arrivee = date("H:i:s");
		$matin= $conn->prepare("INSERT INTO liste(nom,mail,date_jour,arrivee) VALUES (?,?,?,?)");
		$matin->execute(array($data["username"],$data["email"], $day, $arrivee));
	}
	if(isset($_POST["soir"])){
		$depart = date("H:i:s");
		$soir= $conn->prepare("UPDATE liste SET depart=?  WHERE ref = ? AND date_jour =?");
		$soir->execute(array($depart,$id,$day));
	}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</head>

<body class="bg-black" onload="init()">

    <div class="sucess">
        <h1>Bienvenue!</h1>
        <p>C'est votre espace utilisateur.</p>
        <?php
$date = date("d-m-Y-");
$heure = date("H:i:s");
Print("Nous sommes le $date et il est $heure");
?>
        <a href="logout.php">Déconnexion</a>
    </div>
    <div class="text-center">
        <form action="" method="POST">
            <input type="submit" value="Arrivée" name="matin"> 
            <input type="submit" value="Depart" name="soir">
        </form>
    </div>
	<div id="map" style="height: 500px;width: 1345px;"></div>

<script src="admin/main.js"></script>
</body>

</html>