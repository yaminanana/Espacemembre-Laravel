<?php require ('db.php');

//si un utilisateur est connecté, on le redirige vers dashboard.php
if(!empty($_SESSION['user'])){
    header('location:dashboard.php');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$title = 'Connection';

if(!empty($_POST)){
    $post = filter_input_array(Input_POST, FILTER_SANITIZE_STRING);//sur input_post on applique un filtre qui supprime les balises potentielles
    //extract($post);//permet d'appeler nos champs 'name' sous forme de variable sans $_POST
    $errors = [];// tableau vide servant à stocker nos erreurs s'il y en a

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        array_push($errors, 'L\'email n\'est pas valide.');
    }

    if(empty($_POST['password'])){
        array_push($errors, 'Le mot de passe est requis.');
    }

   // var_dump($errors);exit;
   //on vérifie la correspondance des identifiants
if(empty($errors)){
$req = $db->prepare('SELECT * FROM Users WHERE email=:email');
$req->bindValue(':email', $email, PDO::PARAM_STR);
$req->execute();
//et on connect l'utilisateur si c'est ok
$user = $req->fetch();
if($user && password_verify($password, $user->password)){
     $_SESSION['user'] = $user;
     header('location:dashboard.php');

}
array_push($errors, 'Mauvais identifiants');
}

}

?>


<?php include('header.php');?>

    <h2><?=$title;?></h2>
 <?php include('messages.php');?>
        

    <form action="login.php" method="post">
      
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $_POST['email'] ?? '' ;?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Mot de passe">
      </div>
      <button type="submit" class="btn btn-primary">Connexion</button>
    </form>


    <?php include('footer.php'); ?>
