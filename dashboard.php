<?php require ('db.php');

$name = $_POST['name'];
$email = $_POST['email'];

//si un utilisateur n'est pas connecté, on le redirige vers login.php
if(empty($_SESSION['user'])){
    header('location:login.php');
}

$user = $_SESSION['user'];
$title = 'Bonjour'. ' ' .$user->name;

if(!empty($_POST)){
    $post = filter_input_array(Input_POST, FILTER_SANITIZE_STRING);//sur input_post on applique un filtre qui supprime les balises potentielles
    //extract($post);//permet d'appeler nos champs 'name' sous forme de variable sans $_POST
    $errors = [];// tableau vide servant à stocker nos erreurs s'il y en a
    
    if(empty($_POST['name']) || strlen($_POST['name']) < 3){
        array_push($errors, 'Le nom est requis et doit contenir au moins 3 caractères.');
    }
   
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
       array_push($errors, 'L\'email n\'est pas valide.');
   }
   
if(empty($errors)){
    $req = $db->prepare('SELECT * FROM Users WHERE name=:name ');
    $req->bindValue(':name', $name, PDO::PARAM_STR);
    //$req->bindValue(':id', $user->id, PDO::PARAM_INT);
    $req->execute();


    if($req->rowCount() > 0){//s'il y a déjà un nom semblabe, on envoi un message d'erreur
        array_push($errors, 'un utilisateur est déjà enregistré avec ce nom.');
    }
    $req = $db->prepare('SELECT * FROM Users WHERE email=:email ');
    $req->bindValue(':email', $email, PDO::PARAM_STR);
    //$req->bindValue(':id', $user->id, PDO::PARAM_INT);
    $req->execute();


    if($req->rowCount() > 0){//s'il y a déjà un nom semblabe, on envoi un message d'erreur
        array_push($errors, 'un utilisateur est déjà enregistré avec cet email.');
    }
}

}

?>
<?php include('header.php');?>

<h2><?=$title;?></h2>
<?php include('messages.php');?>
    

<form action="dashboard.php" method="post">
  <div class="form-group">
    <label for="name">Nom d'utilisateur</label>
    <input type="text" name="name" class="form-control" placeholder="Nom d'utilisateur" value="<?= $_POST['name'] ?? $user->name;?>">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $_POST['email'] ?? $user->email;?>">
  </div>
 
  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<br>
<a style="float: right;"onclick="return confirm('Confirmez la suppresion de votre compte ? ');" href="delete.php" class="btn btn-danger delete">Supprimer mon compte</a>
<p><a href="password.php">Modifier mon mot de passe.</a></p>


<?php include('footer.php'); ?>
