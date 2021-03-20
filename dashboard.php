<?php require ('db.php');
echo 'Hey';
session_destroy();

//si un utilisateur n'est pas connecté, on le redirige vers login.php
/*if(!empty($_SESSION['user'])){
    header('location:login.php');
}

var_dump($_SESSION['user']);*/
?>