<?php
session_start();
   $json = file_get_contents('https://ip.seeip.org/jsonip'); //pour recuperer l'adresse ip
   //Decode JSON
   $json_data = json_decode($json,true); // pour decoder
   $ip= $json_data["ip"]; //la valeur retourner est un dictionnaire, donc j'appelle la cle ip pour recuperer la valeur ip
   $ip = trim($ip); // je supprime les espaces avant et apres

   try{
       $conn = new PDO("mysql:host=localhost;dbname=form;", "root", "");
   }
   catch(PDOException $e) {
       die("Erreur : " .$e->getMessage());
   }

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

if(isset($_POST['submit'])){
    if (isset($_POST['username']) AND isset($_POST["password"])){
       
        $username = htmlspecialchars($_POST["username"]);
        $password = sha1($_POST["password"]);

        $query = $conn->prepare( "SELECT * FROM apprenant WHERE username=? AND password=?");
        $query->execute(array($username , $password));
        $user= $query ->fetch();
        var_dump($user);
        // $result = mysqli_query($conn,$query) or die(mysql_error());
    
        if ($query->rowCount() !== 0) {
                //if($ip=="196.47.133.39"){
                    // $_SESSION['id']=
                     header('Location:index.php?id='.$user["id"]);
                //}else{
                    //echo "Vous n'êtes pas connnecter au wifi de MTN Academy";
                }else{
                    $message ="Tu n'as pas de compte tu veux quoi ?";
                }
                //105.235.111.211
            }else{
                $message= "Faut remplir tous les champs là tchr";
            }
        }

?>
    <form class="box" method="post" name="login">

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