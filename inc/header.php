<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($titre) && $titre != '') echo $titre . ' - ' ?>iContacts</title>
    <link rel="stylesheet" href="<?php echo Controleur::get_path() ?>/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Controleur::get_path() ?>/styles/base.css">
    <script src="<?php echo Controleur::get_path() ?>/js/tinymce/tinymce.min.js"></script>
</head>
<body <?php if(isset($body_class)) echo 'class="' . $body_class . '"' ?>>
<script src="<?php echo Controleur::get_path() ?>/js/base.js"></script>

<div class="container-fluid heading">
    <a href="<?php echo Controleur::get_url('accueil') ?>">
        <img src="<?php echo Controleur::get_path() ?>/images/logo-dark.png" alt="Logo iContacts">
    </a>

    <h1><?php if(isset($titre) && $titre != '') echo $titre ?></h1>

    <?php if (isset($_SESSION['login']) && !empty($_SESSION['login'])) : ?>
    <ul>
        <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['login'] ?></li>
        <li><a href="<?php echo Controleur::get_url('deconnexion') ?>">Deconnexion</a></li>
    </ul>
    <?php endif; ?>
</div>