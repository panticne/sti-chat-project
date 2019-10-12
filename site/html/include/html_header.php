<?php

if (isset($_SESSION['name'])) {

    if (isset($pageTitle)) {
        $pageTitle .= ' – ';
    }

    $pageTitle .= $_SESSION['name'];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $pageTitle ?></title>
</head>
<body>