<?php
   $json = file_get_contents('https://ip.seeip.org/jsonip'); //pour recuperer l'adresse ip
   //Decode JSON
   $json_data = json_decode($json,true); // pour decoder
   $ip= $json_data["ip"]; //la valeur retourner est un dictionnaire, donc j'appelle la cle ip pour recuperer la valeur ip
   $ip = trim($ip); // je supprime les espaces avant et apres

?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
session_start();

if(isset($_POST['submit'])){
	if (isset($_POST['username'])){
		$username = stripslashes($_REQUEST['username']);
		$username = mysqli_real_escape_string($conn, $username);
		$_SESSION['username'] = $username;
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($conn, $password);
		$query = "SELECT * FROM `formateur` WHERE username='$username' and password='".hash('sha256', $password)."'";
		$result = mysqli_query($conn,$query) or die(mysql_error());
	
		if (mysqli_num_rows($result) == 1) {
			$user = mysqli_fetch_assoc($result);
			// vérifier si l'utilisateur est un administrateur ou un utilisateur
		header("Location :admin/home.php");
		}else{
			$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
		}
	}
}
?>
<form class="box"  method="post" name="login">

<h1 class="box-title">Connexion</h1>
<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="text" class="box-input" name="ip" readonly value="<?=$ip?>">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>