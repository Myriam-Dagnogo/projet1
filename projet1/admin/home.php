<?php
 
// $host = 'localhost';
 //$dbname = 'form';
 //$username = 'root';
 //$password = '';

 //$dsn = "mysql:host=$host;dbname=$dbname"; 
 // récupérer tous les utilisateurs
  
 try{
	$conn = new PDO("mysql:host=localhost;dbname=form;", "root", "");
}
catch(PDOException $e) {
	die("Erreur : " .$e->getMessage());
}
	// Initialiser la session
	session_start();
	// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
	if(!isset($_SESSION["username"])){
		header("Location: loginf.php");
		exit(); 
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="crossorigin=""/>
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../style.css">
   <script src="main.js"></script>
   
	</head>
	<body >
	
		<div class="sucess">
		<h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
		<p>C'est votre espace admin.</p>
		<h1>Liste de présence</h1>
 <table>
   <thead>
     <tr>
       <th>Nom</th>
       <th>Prénoms</th>
       <th>Mail</th>
       <th>Arrivée</th>
       <th>Départ</th>

     </tr>
   </thead>
   <tbody>
    
     <?php 
     $jour=date("d-m-Y");
      $recup=$conn->query ("SELECT * FROM liste WHERE date_jour ='$jour'");
     while($row = $recup->fetch()) : ?>
     <tr>
       <td><?php echo htmlspecialchars($row['nom']); ?></td>
       <td><?php echo htmlspecialchars($row['prenoms']); ?></td>
       <td><?php echo htmlspecialchars($row['mail']); ?></td>
       <td><?php echo htmlspecialchars($row['arrivee']); ?></td>
       <td><?php echo htmlspecialchars($row['depart']); ?></td>

	   <td><button><a href="delete_user.php?id=<?php echo $row['id'] ?>">supprimer</a></button></td>
	   <td><button><a href="update_user.php?id=<?php echo $row['id'] ?>">modifier</a></button></td>
     </tr>
     <?php endwhile; ?>
   </tbody>
 </table>
 <div class="text-center">
 <a href="add_user.php">AJOUTER utilisateur</a> | | 
		<a href="../logout.php">Déconnexion</a>
  
 </div>
		
		</ul>
		</div>
    <br><br>
	
	</body>
	
</html>

