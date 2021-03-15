<?php require ('db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$title = 'Inscription';
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
// var_dump($errors);exit;

if(empty($_POST['password']) || strlen($_POST['password'])< 6){
    array_push($errors, 'Le mot de passe est requis et doit contenir au moins 6 caractères.');
}
//var_dump($errors);exit;

if(empty($errors)){
    $req = $db->prepare('SELECT * FROM Users WHERE nom = :name');
    $req->bindValue(':name', $_POST['name'], PDO::PARAM_STR);//type de valeur string
    $req->execute();

    if($req->rowCount() > 0){//s'il y a déjà un nom semblabe, on envoi un message d'erreur
        array_push($errors, 'un utilisateur est déjà enregistré avec ce nom');
    }

    $req = $db->prepare('SELECT * FROM Users WHERE email = :email');
    $req->bindValue(':email', $_POST['email'], PDO::PARAM_STR);//type de valeur string
    $req->execute();

    if($req->rowCount() > 0){//s'il y a déjà un nom semblabe, on envoi un message d'erreur
        array_push($errors, 'un utilisateur est déjà enregistré avec cet email.');
    }
   

    if(empty($errors)){
$req = $db ->prepare('INSERT INTO Users (name, email, password, created_at)
                    VALUES (:nom, :email, :password, NOW()');
$req->bindValue(':name', $name, PDO::PARAM_STR);//la valeur est de type string
$req->bindValue(':email', $email, PDO::PARAM_STR);
$req->bindValue(':password', password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
$req->execute();
    }

}
}
?>


<?php include('header.php');?>

    <h2><?=$title;?></h2>

    <?php if(!empty($errors));?>
        <div class="alert alert=danger">
            <?php foreach($errors as $error):?>
<p><?=$error;?></p>

                <?php endforeach;?>
        </div>
        

    <form action="" method="post">
      <div class="form-group">
        <label for="name">Nom d'utilisateur</label>
        <input type="text" name="name" class="form-control" placeholder="Nom d'utilisateur" value="<?= $_POST['name'] ?? '' ;?>">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $_POST['email'] ?? '' ;?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Mot de passe">
      </div>
      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>


    <?php include('footer.php'); ?>
