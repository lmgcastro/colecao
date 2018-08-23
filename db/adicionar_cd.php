<?php
    include_once "dbh.php";

    $titulo = $_POST['titulo'];
    $artista = $_POST['artista'];
    $ano = $_POST['ano'];
    $selo = $_POST['selo'];
    $duracao = $_POST['duracao'];
    $discos = $_POST['discos'];
    $data = $_POST['data'];

    $sql = "INSERT INTO cds VALUES ('$titulo', '$artista', '$ano', '$selo', '$duracao', '$discos', '$data');";
    mysqli_query($conn, $sql);

    header("Location: ../cds.php?adicionar=sucesso");