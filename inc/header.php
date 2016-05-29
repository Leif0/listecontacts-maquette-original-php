<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mes contacts - iContacts</title>
    <link rel="stylesheet" href="<?php echo Controleur::get_path() ?>/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Controleur::get_path() ?>/styles/base.css">
</head>
<body <?php if(isset($body_class)) echo 'class="' . $body_class . '"' ?>>
<script src="<?php echo Controleur::get_path() ?>/js/base.js"></script>

<div class="container-fluid heading">
    <h1><?php if(isset($titre) && $titre != '') echo $titre ?></h1>
</div>


